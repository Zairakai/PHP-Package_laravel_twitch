<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Sleep;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Process\Process;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * .gitlab/scripts/twitch-watch.php opens one issue per new entry of the Twitch announcements. It runs here on feeds
 * written on the fly (the dates are relative to today) and, for the issues, against a local fake GitLab.
 */
final class TwitchWatchScriptTest extends TestCase
{
    private string $directory;

    private ?Process $server = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->directory = sys_get_temp_dir() . '/twitch-watch-' . uniqid();
        mkdir($this->directory);

        $recent = gmdate('D, d M Y 00:00:00 +0000', strtotime('-2 days'));
        $old    = gmdate('D, d M Y 00:00:00 +0000', strtotime('-90 days'));

        file_put_contents($this->directory . '/changelog.xml', $this->feed([
            [
                'Changelog recent',
                $recent,
            ],
            [
                'Changelog old',
                $old,
            ],
        ]));
        file_put_contents($this->directory . '/announcements.xml', $this->feed([
            [
                'New endpoint',
                $recent,
            ],
        ]));
    }

    protected function tearDown(): void
    {
        $this->server?->stop();
        new Filesystem()->deleteDirectory($this->directory);

        parent::tearDown();
    }

    #[Test]
    public function a_refused_token_fails_the_job(): void
    {
        $api = $this->fakeGitLab();

        $process = $this->script($this->gitlabEnvironment($api, 'wrong') + [
            'WATCH_FEEDS' => 'Changelog=' . $this->directory . '/changelog.xml',
        ]);

        self::assertSame(1, $process->getExitCode());
    }

    #[Test]
    public function an_unreadable_feed_and_a_feed_that_is_not_rss_fail_the_job(): void
    {
        file_put_contents($this->directory . '/bad.xml', 'not xml');

        self::assertSame(1, $this->script([
            'WATCH_FEEDS' => 'Changelog=' . $this->directory . '/missing.xml',
        ], [
            '--dry-run',
        ])->getExitCode());
        self::assertSame(1, $this->script([
            'WATCH_FEEDS' => 'Changelog=' . $this->directory . '/bad.xml',
        ], [
            '--dry-run',
        ])->getExitCode());
    }

    #[Test]
    public function dry_run_lists_the_recent_entries_of_every_feed_and_skips_the_old_ones(): void
    {
        $process = $this->script([
            'WATCH_FEEDS' => $this->feeds(),
        ], [
            '--dry-run',
        ]);

        self::assertSame(0, $process->getExitCode());
        self::assertStringContainsString('WOULD OPEN: Changelog: Changelog recent', $process->getOutput());
        self::assertStringContainsString('WOULD OPEN: Announcement: New endpoint', $process->getOutput());
        self::assertStringNotContainsString('Changelog old', $process->getOutput());
        self::assertStringContainsString('Done: 2 issue(s), 0 failure(s)', $process->getOutput());
    }

    #[Test]
    public function it_opens_an_issue_for_a_new_entry_and_not_for_one_that_already_has_an_issue(): void
    {
        $api = $this->fakeGitLab();
        file_put_contents($this->directory . '/existing', 'Changelog: Changelog recent');

        $process = $this->script($this->gitlabEnvironment($api, 'secret') + [
            'WATCH_FEEDS' => $this->feeds(),
        ]);

        self::assertSame(
            0,
            $process->getExitCode(),
            $process->getErrorOutput(),
        );
        self::assertStringContainsString('OPENED: Announcement: New endpoint', $process->getOutput());
        self::assertStringNotContainsString('OPENED: Changelog: Changelog recent', $process->getOutput());

        // The label of the automated issues, and the assignee: the user of the token (7 for the fake server)
        self::assertSame("Announcement: New endpoint|Automated|7\n", file_get_contents($this->directory . '/created'));
    }

    #[Test]
    public function the_window_is_set_by_watch_since_days(): void
    {
        $process = $this->script([
            'WATCH_SINCE_DAYS' => '120',
            'WATCH_FEEDS'      => 'Changelog=' . $this->directory . '/changelog.xml',
        ], [
            '--dry-run',
        ]);

        self::assertStringContainsString('Changelog old', $process->getOutput());
    }

    #[Test]
    public function without_dry_run_it_refuses_to_run_without_a_token(): void
    {
        $process = $this->script([
            'FRESHNESS_TOKEN' => '',
            'GITLAB_TOKEN'    => '',
            'WATCH_FEEDS'     => $this->feeds(),
        ]);

        self::assertSame(1, $process->getExitCode());
        self::assertStringContainsString('required', $process->getErrorOutput());
    }

    /**
     * A tiny local server plays GitLab: it lists the issue already opened (the file "existing") and records each
     * creation with its label and assignee.
     */
    private function fakeGitLab(): string
    {
        file_put_contents($this->directory . '/router.php', <<<'PHP_WRAP'
        <?php
        $dir  = getenv('FAKE_DIR');
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        header('Content-Type: application/json');
        if ($_SERVER['HTTP_PRIVATE_TOKEN'] !== 'secret') { http_response_code(401); echo '{}'; return; }
        if ($path === '/api/v4/user') { echo '{"id":7}'; return; }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $existing = is_file("$dir/existing") ? trim((string) file_get_contents("$dir/existing")) : '';
            echo json_encode($existing === '' ? [] : [['title' => $existing]]);
            return;
        }
        file_put_contents("$dir/created", ($_POST['title'] ?? '') . '|' . ($_POST['labels'] ?? '') . '|' . ($_POST['assignee_ids'] ?? '') . "\n", FILE_APPEND);
        echo '{"iid":1}';
        PHP_WRAP);

        $port         = random_int(20000, 40000);
        $this->server = new Process([
            PHP_BINARY,
            '-S',
            '127.0.0.1:' . $port,
            $this->directory . '/router.php',
        ], null, [
            'FAKE_DIR' => $this->directory,
        ]);
        $this->server->start();
        Sleep::usleep(500000);

        return 'http://127.0.0.1:' . $port . '/api/v4';
    }

    /**
     * @param list<array{string, string}> $items
     */
    private function feed(array $items): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"><channel><title>Fixture</title>';

        foreach ($items as [$title, $date]) {
            $xml .= "<item><title>{$title}</title><link>https://example.test/#{$title}</link><pubDate>{$date}</pubDate>"
                . '<description><![CDATA[<p>Text.</p>]]></description></item>';
        }

        return $xml . '</channel></rss>';
    }

    private function feeds(): string
    {
        return 'Changelog=' . $this->directory . '/changelog.xml,Announcement=' . $this->directory . '/announcements.xml';
    }

    /**
     * @return array<string, string>
     */
    private function gitlabEnvironment(string $api, string $token): array
    {
        return [
            'FRESHNESS_TOKEN' => $token,
            'CI_PROJECT_ID'   => '1',
            'CI_API_V4_URL'   => $api,
        ];
    }

    /**
     * @param array<string, string> $environment
     * @param list<string>          $arguments
     */
    private function script(array $environment, array $arguments = []): Process
    {
        $process = new Process([
            PHP_BINARY,
            dirname(__DIR__, 2) . '/.gitlab/scripts/twitch-watch.php',
            ...$arguments,
        ], null, $environment);
        $process->run();

        return $process;
    }
}
