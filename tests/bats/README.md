# BATS Tests — laravel-twitch

This directory contains BATS (Bash Automated Testing System) tests for validating the package structure and tooling integration.

## Structure

```
tests/bats/
├── helpers/
│   └── test_helper.bash        # Shared assertions and setup/teardown
├── unit/
│   └── package-structure.bats  # Package metadata and file structure (36 tests)
├── integration/
│   └── composer-scripts.bats   # Composer scripts and dev-tools integration (9 tests)
└── README.md
```

## Test Coverage

### Unit — `package-structure.bats` (36 tests)

Validates package metadata, source files (services, facades, controller, model),
config/migrations, tests directory, and CI/tooling config files.

### Integration — `composer-scripts.bats` (9 tests)

Validates that composer scripts are defined, dev-tools are installed,
`phpunit.xml` is a copy (not a symlink), the git repository exists,
and `composer validate` passes.

## Running Tests

```bash
# All BATS tests
bats tests/bats/ --recursive

# Individual suites
bats tests/bats/unit/package-structure.bats
bats tests/bats/integration/composer-scripts.bats
```

## Available Assertions

From `helpers/test_helper.bash`:

```bash
assert_file_exists <path>
assert_dir_exists <path>
assert_file_contains <path> <string>
assert_output_contains <string>
assert_success
```

---

**Total BATS Tests**: 45
