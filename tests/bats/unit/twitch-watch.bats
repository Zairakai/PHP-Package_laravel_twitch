#!/usr/bin/env bats
#
# Unit Tests: Twitch watch (.gitlab/scripts/twitch-watch.php)
#
# The script opens one issue per new entry of the Twitch announcements. Here it runs in dry-run mode on feeds written
# on the fly (the dates are relative to today), so nothing is read from the network and no issue is opened.
#

load '../helpers/test_helper'

setup() {
    setup_test_env
    SCRIPT="${PROJECT_ROOT}/.gitlab/scripts/twitch-watch.php"

    recent="$(date -u -d '-2 days' '+%a, %d %b %Y 00:00:00 +0000')"
    old="$(date -u -d '-90 days' '+%a, %d %b %Y 00:00:00 +0000')"

    cat > "${TEST_TEMP_DIR}/changelog.xml" <<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"><channel><title>Fixture</title>
<item><title>Changelog recent</title><link>https://example.test/#recent</link><pubDate>${recent}</pubDate><description><![CDATA[<p>New field <b>foo</b>.</p>]]></description></item>
<item><title>Changelog old</title><link>https://example.test/#old</link><pubDate>${old}</pubDate><description><![CDATA[<p>Old.</p>]]></description></item>
</channel></rss>
XML
    cat > "${TEST_TEMP_DIR}/announcements.xml" <<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"><channel><title>Fixture</title>
<item><title>New endpoint</title><link>https://example.test/t/1</link><pubDate>${recent}</pubDate><description><![CDATA[<p>Hello</p>]]></description></item>
</channel></rss>
XML
}

teardown() {
    teardown_test_env
}

@test "the watch script exists" {
    assert_file_exists "${SCRIPT}"
}

@test "the watch script has valid PHP syntax" {
    run php -l "${SCRIPT}"

    [ "$status" -eq 0 ]
}

@test "dry-run lists the recent entries of every feed and skips the old ones" {
    WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/changelog.xml,Announcement=${TEST_TEMP_DIR}/announcements.xml" \
        run php "${SCRIPT}" --dry-run

    [ "$status" -eq 0 ]
    [[ "$output" == *"WOULD OPEN: Changelog: Changelog recent"* ]]
    [[ "$output" == *"WOULD OPEN: Announcement: New endpoint"* ]]
    [[ "$output" != *"Changelog old"* ]]
    [[ "$output" == *"Done: 2 issue(s), 0 failure(s)"* ]]
}

@test "WATCH_SINCE_DAYS widens the window" {
    WATCH_SINCE_DAYS=120 WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/changelog.xml" \
        run php "${SCRIPT}" --dry-run

    [ "$status" -eq 0 ]
    [[ "$output" == *"Changelog old"* ]]
}

@test "an unreadable feed fails the job" {
    WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/missing.xml" run php "${SCRIPT}" --dry-run

    [ "$status" -eq 1 ]
}

@test "a feed that is not RSS fails the job" {
    echo "not xml" > "${TEST_TEMP_DIR}/bad.xml"

    WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/bad.xml" run php "${SCRIPT}" --dry-run

    [ "$status" -eq 1 ]
}

@test "without dry-run the script refuses to run without a token" {
    FRESHNESS_TOKEN="" GITLAB_TOKEN="" WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/changelog.xml" run php "${SCRIPT}"

    [ "$status" -eq 1 ]
    [[ "$output" == *"required"* ]]
}

# A tiny local server plays GitLab: it lists the issues already opened (the file "existing") and records each creation.
start_fake_gitlab() {
    cat > "${TEST_TEMP_DIR}/router.php" <<'PHP'
<?php
$dir = getenv('FAKE_DIR');
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
PHP
    FAKE_DIR="${TEST_TEMP_DIR}" php -S 127.0.0.1:18765 "${TEST_TEMP_DIR}/router.php" > /dev/null 2>&1 &
    FAKE_PID=$!
    sleep 1
}

@test "it opens an issue for a new entry and not for one that already has an issue" {
    start_fake_gitlab
    echo "Changelog: Changelog recent" > "${TEST_TEMP_DIR}/existing"

    FRESHNESS_TOKEN=secret CI_PROJECT_ID=1 CI_API_V4_URL=http://127.0.0.1:18765/api/v4 \
        WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/changelog.xml,Announcement=${TEST_TEMP_DIR}/announcements.xml" \
        run php "${SCRIPT}"
    kill "${FAKE_PID}" 2>/dev/null || true

    [ "$status" -eq 0 ]
    [[ "$output" == *"OPENED: Announcement: New endpoint"* ]]
    [[ "$output" != *"OPENED: Changelog: Changelog recent"* ]]
    run cat "${TEST_TEMP_DIR}/created"
    # Label of the automated issues and assignee = user of the token (7 for the fake server)
    [ "$output" = "Announcement: New endpoint|Automated|7" ]
}

@test "a refused token fails the job" {
    start_fake_gitlab

    FRESHNESS_TOKEN=wrong CI_PROJECT_ID=1 CI_API_V4_URL=http://127.0.0.1:18765/api/v4 \
        WATCH_FEEDS="Changelog=${TEST_TEMP_DIR}/changelog.xml" run php "${SCRIPT}"
    kill "${FAKE_PID}" 2>/dev/null || true

    [ "$status" -eq 1 ]
}

@test "the pipeline has a twitch:watch job started by a schedule only" {
    assert_file_contains "${PROJECT_ROOT}/.gitlab-ci.yml" "twitch:watch:"
    assert_file_contains "${PROJECT_ROOT}/.gitlab-ci.yml" 'WATCH_TWITCH_API == "true" && $UPDATE_DEPENDENCIES == "true" && $CI_PIPELINE_SOURCE == "schedule"'
}

@test "the update and audit jobs of the template are kept out of the watch pipeline" {
    run grep -cF 'WATCH_TWITCH_API == "true"' "${PROJECT_ROOT}/.gitlab-ci.yml"

    # twitch:watch, deps:update and deps:audit
    [ "$output" -eq 3 ]
}

@test "the watch script is left out of the package archive" {
    assert_file_contains "${PROJECT_ROOT}/.gitattributes" "/.gitlab export-ignore"
}
