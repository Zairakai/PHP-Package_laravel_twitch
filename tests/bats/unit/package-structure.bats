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

@test "phpstan.neon is in config/dev-tools only" {
    assert_file_exists "${PROJECT_ROOT}/config/dev-tools/phpstan.neon"
    [ ! -e "${PROJECT_ROOT}/phpstan.neon" ]
}

@test "config/dev-tools/phpstan.neon includes a config source" {
    assert_file_contains "${PROJECT_ROOT}/config/dev-tools/phpstan.neon" "includes"
}

@test "config/dev-tools/ directory exists" {
    assert_dir_exists "${PROJECT_ROOT}/config/dev-tools"
}

@test "config/dev-tools/ holds the configuration of each tool" {
    local file
    for file in baseline.neon phpinsights.php phpstan.neon phpunit.xml pint.json rector.php .markdownlint.json; do
        assert_file_exists "${PROJECT_ROOT}/config/dev-tools/${file}"
    done
}

@test "config/dev-tools/baseline.neon exists" {
    assert_file_exists "${PROJECT_ROOT}/config/dev-tools/baseline.neon"
}

# ============================================================================
# Translations, migration and configuration
# ============================================================================

@test "lang/ has the errors file in every language of the package" {
    local count=0

    for dir in "${PROJECT_ROOT}"/lang/*/; do
        assert_file_exists "${dir}errors.php"
        count=$((count + 1))
    done

    [ "$count" -ge 129 ]
}

@test "every language has the same keys as English" {
    local expected
    expected="$(grep -oE "^[[:space:]]+'[a-z_]+' =>" "${PROJECT_ROOT}/lang/en/errors.php" | tr -d ' ')"

    for dir in "${PROJECT_ROOT}"/lang/*/; do
        [ "$(grep -oE "^[[:space:]]+'[a-z_]+' =>" "${dir}errors.php" | tr -d ' ')" = "$expected" ]
    done
}

@test "the migration is strict and keeps the login out of the unique indexes" {
    local migration
    migration="$(ls "${PROJECT_ROOT}"/database/migrations/*.php)"

    assert_file_contains "$migration" "declare(strict_types=1);"
    assert_file_contains "$migration" "\$table->string('twitch_id')->unique();"
    assert_file_contains "$migration" "\$table->string('login')->index();"
}

@test "the service provider loads and publishes the migrations and the translations" {
    local provider="${PROJECT_ROOT}/src/TwitchServiceProvider.php"

    assert_file_contains "$provider" "twitch.database.load_migrations"
    assert_file_contains "$provider" "'twitch-migrations'"
    assert_file_contains "$provider" "loadTranslationsFrom"
    assert_file_contains "$provider" "'twitch-translations'"
}

@test "the config says which keys the code reads" {
    assert_file_contains "${PROJECT_ROOT}/config/twitch.php" "Not used yet"
    assert_file_contains "${PROJECT_ROOT}/config/twitch.php" "'redirect_to'"
    assert_file_contains "${PROJECT_ROOT}/config/twitch.php" "'load_migrations'"
}
