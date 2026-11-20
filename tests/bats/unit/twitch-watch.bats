#!/usr/bin/env bats
#
# Unit Tests: Twitch watch (structure)
#
# The script .gitlab/scripts/twitch-watch.php opens one issue per new entry of the Twitch announcements. What it does
# is tested by PHPUnit (tests/Feature/TwitchWatchScriptTest.php); here only the structure that must stay: the script,
# its job, and the exclusions that keep the other jobs of the template out of its pipeline.
#

load '../helpers/test_helper'

setup() {
    setup_test_env
    SCRIPT="${PROJECT_ROOT}/.gitlab/scripts/twitch-watch.php"
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
