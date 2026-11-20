<?php

declare(strict_types=1);

/**
 * Watches the Twitch developer announcements and opens one issue per new entry, so that any developer can
 * make the update the entry requires.
 *
 * Sources (RSS): the developer changelog and the Announcements category of the developer forum.
 * Environment:
 *   WATCH_SINCE_DAYS     only the entries of the last N days are considered (default 14)
 *   WATCH_FEEDS          feeds, "label=url" separated by commas (default: the two sources above; tests use files)
 *   FRESHNESS_TOKEN or GITLAB_TOKEN   token that opens the issues (group variables, as for the audit of the dependencies)
 *   ISSUE_ASSIGNEE_ID    assignee of the issues; without it, the user of the token (as the audit of the dependencies)
 *   CI_API_V4_URL, CI_PROJECT_ID      given by GitLab CI
 * Options: --dry-run prints the issues instead of opening them.
 *
 * An issue is opened only when no issue (open or closed) already has the same title: running it twice does nothing,
 * and an entry whose issue was closed is not opened again. The label is Automated, as for the issues of the audit.
 */

const DEFAULT_FEEDS = 'Changelog=https://dev.twitch.tv/docs/rss/change-log.xml,Announcement=https://discuss.dev.twitch.com/c/announcements/13.rss';

/**
 * @return list<array{title: string, link: string, date: DateTimeImmutable, text: string}>
 */
function readFeed(string $label, string $source): array
{
    $context = stream_context_create(['http' => ['timeout' => 30, 'header' => "User-Agent: twitch-watch\r\n"]]);
    $xml     = @file_get_contents($source, false, $context);

    if ($xml === false) {
        throw new RuntimeException("Cannot read the feed {$label}: {$source}");
    }

    $feed = simplexml_load_string($xml);

    if ($feed === false || ! isset($feed->channel->item)) {
        throw new RuntimeException("The feed {$label} is not a valid RSS feed");
    }

    $entries = [];

    foreach ($feed->channel->item as $item) {
        $text = html_entity_decode(strip_tags((string) $item->description), ENT_QUOTES | ENT_HTML5);

        $entries[] = [
            'title' => $label . ': ' . trim((string) $item->title),
            'link'  => trim((string) $item->link),
            'date'  => new DateTimeImmutable((string) $item->pubDate),
            'text'  => trim((string) preg_replace('/\s+/', ' ', $text)),
        ];
    }

    return $entries;
}

/**
 * @param array{title: string, link: string, date: DateTimeImmutable, text: string} $entry
 */
function issueBody(array $entry): string
{
    $text = mb_substr($entry['text'], 0, 3000);

    return <<<MD
        Published {$entry['date']->format('Y-m-d')} by Twitch: {$entry['link']}

        > {$text}

        ## To do

        - [ ] Read the entry and decide whether `src/` is concerned (Helix endpoints, EventSub types, fields, scopes, deprecations).
        - [ ] If so: update the code, the DTOs and the tests, then run `make ci`.
        - [ ] Close this issue (or say why nothing is needed).

        Opened by the Twitch watch job (`.gitlab/scripts/twitch-watch.php`).
        MD;
}

function api(string $method, string $path, string $token, ?array $form = null): array
{
    $options = ['http' => ['method' => $method, 'timeout' => 30, 'ignore_errors' => true, 'header' => "PRIVATE-TOKEN: {$token}\r\nUser-Agent: twitch-watch\r\n"]];

    if ($form !== null) {
        $options['http']['header']  .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $options['http']['content']  = http_build_query($form);
    }

    $body   = file_get_contents(rtrim((string) getenv('CI_API_V4_URL'), '/') . $path, false, stream_context_create($options));
    $status = (int) (preg_match('#HTTP/\S+ (\d{3})#', $http_response_header[0] ?? '', $m) ? $m[1] : 0);

    if ($body === false || $status < 200 || $status >= 300) {
        throw new RuntimeException("GitLab API {$method} {$path} answered {$status}");
    }

    $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

    return is_array($decoded) ? $decoded : [];
}

$dryRun = in_array('--dry-run', $argv, true);
$days   = (int) (getenv('WATCH_SINCE_DAYS') ?: 14);
$since  = new DateTimeImmutable("-{$days} days");
$token  = (string) (getenv('FRESHNESS_TOKEN') ?: getenv('GITLAB_TOKEN'));
$feeds  = (string) (getenv('WATCH_FEEDS') ?: DEFAULT_FEEDS);

if (! $dryRun && ($token === '' || getenv('CI_PROJECT_ID') === false || getenv('CI_API_V4_URL') === false)) {
    fwrite(STDERR, "FRESHNESS_TOKEN (or GITLAB_TOKEN), CI_PROJECT_ID and CI_API_V4_URL are required\n");
    exit(1);
}

$failures = 0;
$created  = 0;
$assignee = null;

foreach (explode(',', $feeds) as $definition) {
    [$label, $source] = array_pad(explode('=', trim($definition), 2), 2, '');

    try {
        $entries = readFeed($label, $source);
    } catch (RuntimeException $e) {
        fwrite(STDERR, $e->getMessage() . "\n");
        ++$failures;

        continue;
    }

    foreach ($entries as $entry) {
        if ($entry['date'] < $since) {
            continue;
        }

        if ($dryRun) {
            echo "WOULD OPEN: {$entry['title']}\n";
            ++$created;

            continue;
        }

        try {
            $existing = api('GET', '/projects/' . getenv('CI_PROJECT_ID') . '/issues?in=title&state=all&per_page=100&search=' . rawurlencode($entry['title']), $token);
            $exists   = array_filter($existing, static fn (mixed $issue): bool => is_array($issue) && ($issue['title'] ?? null) === $entry['title']);

            if ($exists !== []) {
                continue;
            }

            $assignee ??= (int) (getenv('ISSUE_ASSIGNEE_ID') ?: (api('GET', '/user', $token)['id'] ?? 0));

            api('POST', '/projects/' . getenv('CI_PROJECT_ID') . '/issues', $token, [
                'title'        => $entry['title'],
                'description'  => issueBody($entry),
                'labels'       => 'Automated',
                'assignee_ids' => $assignee > 0 ? (string) $assignee : '',
            ]);
            echo "OPENED: {$entry['title']}\n";
            ++$created;
        } catch (Throwable $e) {
            fwrite(STDERR, $e->getMessage() . "\n");
            ++$failures;
        }
    }
}

echo "Done: {$created} issue(s), {$failures} failure(s)\n";
exit($failures === 0 ? 0 : 1);
