#!/usr/bin/env bats
#
# Unit Tests: Package Structure
#
# Validates that all required files and directories of laravel-twitch
# are present and correctly configured.
#

# Load test helpers
load '../helpers/test_helper'

setup() {
    setup_test_env
}

teardown() {
    teardown_test_env
}

# ============================================================================
# composer.json
# ============================================================================

@test "composer.json exists" {
    assert_file_exists "${PROJECT_ROOT}/composer.json"
}

@test "composer.json has correct package name" {
    run grep -q '"name": "zairakai/laravel-twitch"' "${PROJECT_ROOT}/composer.json"

    [ "$status" -eq 0 ]
}

@test "composer.json has library type" {
    run grep -q '"type": "library"' "${PROJECT_ROOT}/composer.json"

    [ "$status" -eq 0 ]
}

@test "composer.json requires php ^8.3" {
    run grep -q '"php":' "${PROJECT_ROOT}/composer.json"

    [ "$status" -eq 0 ]
}

@test "composer.json defines quality scripts" {
    local scripts=("analyse" "quality-fast" "test" "rector" "cs")

    for script in "${scripts[@]}"; do
        run grep -q "\"${script}\"" "${PROJECT_ROOT}/composer.json"
        [ "$status" -eq 0 ]
    done
}

@test "composer.json requires laravel-dev-tools" {
    run grep -q '"zairakai/laravel-dev-tools"' "${PROJECT_ROOT}/composer.json"

    [ "$status" -eq 0 ]
}

@test "composer.json requires guzzlehttp/guzzle" {
    run grep -q '"guzzlehttp/guzzle"' "${PROJECT_ROOT}/composer.json"

    [ "$status" -eq 0 ]
}

# ============================================================================
# Source Files
# ============================================================================

@test "src/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/src"
}

@test "TwitchServiceProvider.php exists" {
    assert_file_exists "${PROJECT_ROOT}/src/TwitchServiceProvider.php"
}

@test "TwitchServiceProvider.php declares strict_types" {
    run grep -q "declare(strict_types=1)" "${PROJECT_ROOT}/src/TwitchServiceProvider.php"

    [ "$status" -eq 0 ]
}

@test "TwitchApiService.php exists" {
    assert_file_exists "${PROJECT_ROOT}/src/Services/TwitchApiService.php"
}

@test "TwitchApiService.php declares strict_types" {
    run grep -q "declare(strict_types=1)" "${PROJECT_ROOT}/src/Services/TwitchApiService.php"

    [ "$status" -eq 0 ]
}

@test "TwitchOAuthService.php exists" {
    assert_file_exists "${PROJECT_ROOT}/src/Services/TwitchOAuthService.php"
}

@test "TwitchOAuthService.php declares strict_types" {
    run grep -q "declare(strict_types=1)" "${PROJECT_ROOT}/src/Services/TwitchOAuthService.php"

    [ "$status" -eq 0 ]
}

@test "TwitchAuthController.php exists" {
    assert_file_exists "${PROJECT_ROOT}/src/Http/Controllers/TwitchAuthController.php"
}

@test "TwitchAuthController.php declares strict_types" {
    run grep -q "declare(strict_types=1)" "${PROJECT_ROOT}/src/Http/Controllers/TwitchAuthController.php"

    [ "$status" -eq 0 ]
}

@test "TwitchUser model exists" {
    assert_file_exists "${PROJECT_ROOT}/src/Models/TwitchUser.php"
}

@test "TwitchUser model declares strict_types" {
    run grep -q "declare(strict_types=1)" "${PROJECT_ROOT}/src/Models/TwitchUser.php"

    [ "$status" -eq 0 ]
}

@test "Twitch facade exists" {
    assert_file_exists "${PROJECT_ROOT}/src/Facades/Twitch.php"
}

@test "TwitchOAuth facade exists" {
    assert_file_exists "${PROJECT_ROOT}/src/Facades/TwitchOAuth.php"
}

# ============================================================================
# Config / Migrations
# ============================================================================

@test "config/twitch.php exists" {
    assert_file_exists "${PROJECT_ROOT}/config/twitch.php"
}

@test "config/twitch.php has client_id" {
    assert_file_contains "${PROJECT_ROOT}/config/twitch.php" "client_id"
}

@test "config/twitch.php has client_secret" {
    assert_file_contains "${PROJECT_ROOT}/config/twitch.php" "client_secret"
}

@test "database/migrations/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/database/migrations"
}

@test "twitch_users migration file exists" {
    run find "${PROJECT_ROOT}/database/migrations" -name "*twitch_users*" -type f

    [ "$status" -eq 0 ]
    [ -n "$output" ]
}

# ============================================================================
# Tests Directory
# ============================================================================

@test "tests/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/tests"
}

@test "tests/Unit/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/tests/Unit"
}

@test "tests/Feature/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/tests/Feature"
}

# ============================================================================
# CI / Tooling
# ============================================================================

@test ".gitlab-ci.yml exists" {
    assert_file_exists "${PROJECT_ROOT}/.gitlab-ci.yml"
}

@test ".gitlab-ci.yml references laravel-dev-tools pipeline" {
    assert_file_contains "${PROJECT_ROOT}/.gitlab-ci.yml" "pipeline-php-package.yml"
}

@test ".gitlab-ci.yml has correct CACHE_KEY" {
    assert_file_contains "${PROJECT_ROOT}/.gitlab-ci.yml" "CACHE_KEY.*laravel-twitch"
}

@test ".gitlab-ci.yml has correct PACKAGIST_PACKAGE" {
    assert_file_contains "${PROJECT_ROOT}/.gitlab-ci.yml" "zairakai/laravel-twitch"
}

@test "Makefile exists" {
    assert_file_exists "${PROJECT_ROOT}/Makefile"
}

@test "phpstan.neon exists" {
    assert_file_exists "${PROJECT_ROOT}/phpstan.neon"
}

@test "phpstan.neon includes larastan" {
    assert_file_contains "${PROJECT_ROOT}/phpstan.neon" "larastan"
}

@test "config/dev-tools/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/config/dev-tools"
}

@test "config/dev-tools/baseline.neon exists" {
    assert_file_exists "${PROJECT_ROOT}/config/dev-tools/baseline.neon"
}
