#!/usr/bin/env bash
#
# BATS Test Helpers
# Common utilities for laravel-twitch BATS tests
#

# Setup test environment
setup_test_env() {
    # Create temporary test directory
    export TEST_TEMP_DIR="${BATS_TEST_TMPDIR}/laravel-twitch-test-$$"
    mkdir -p "$TEST_TEMP_DIR"

    # Export package root (tests are in tests/bats/{unit,integration}/)
    export PROJECT_ROOT
    PROJECT_ROOT="$(cd "${BATS_TEST_DIRNAME}/../../.." && pwd)"
}

# Teardown test environment
teardown_test_env() {
    if [[ -n "${TEST_TEMP_DIR:-}" ]] && [[ -d "$TEST_TEMP_DIR" ]]; then
        rm -rf "$TEST_TEMP_DIR"
    fi
}

# Assert file exists
assert_file_exists() {
    local file="$1"

    if [[ ! -f "$file" ]]; then
        echo "ASSERTION FAILED: File does not exist: $file" >&2
        return 1
    fi
}

# Assert directory exists
assert_dir_exists() {
    local dir="$1"

    if [[ ! -d "$dir" ]]; then
        echo "ASSERTION FAILED: Directory does not exist: $dir" >&2
        return 1
    fi
}

# Assert file contains string
assert_file_contains() {
    local file="$1"
    local needle="$2"

    if ! grep -q "$needle" "$file"; then
        echo "ASSERTION FAILED: '$file' does not contain: $needle" >&2
        return 1
    fi
}

# Assert last run command succeeded
assert_success() {
    if [[ "$status" -ne 0 ]]; then
        echo "ASSERTION FAILED: Expected success (exit 0), got status $status" >&2
        echo "Output: $output" >&2
        return 1
    fi
}

# Assert output contains string
assert_output_contains() {
    local needle="$1"

    if [[ ! "$output" =~ $needle ]]; then
        echo "ASSERTION FAILED: Output does not contain: $needle" >&2
        echo "Actual output: $output" >&2
        return 1
    fi
}
