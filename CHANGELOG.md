# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- GitLab CI/CD pipeline for automated testing and publishing
- Enhanced test coverage reporting
- Security audit and dependency checking automation

### Changed

- Improved development workflow with standardized scripts
- Enhanced code quality with PHPStan strict analysis

### Fixed

- Better error handling in API requests
- Improved token refresh mechanism
- Enhanced EventSub webhook validation

## [1.0.0] - 2025-09-02

### Added

- Initial release of zairakai/laravel-twitch
- Complete Twitch OAuth 2.0 integration with TwitchOAuthService
- Comprehensive Twitch API wrapper with TwitchApiService
- EventSub webhook support for real-time events
- TwitchUser Eloquent model with token management
- Laravel Facades (Twitch, TwitchOAuth) for easy access
- Database migrations for Twitch user storage
- Extensive configuration options via config/twitch.php
- Comprehensive test suite with PHPUnit
- PHPStan static analysis integration
- PHP-CS-Fixer code style enforcement
- Support for Laravel 11+ and PHP 8.2+

### Features

- User authentication and token management
- Stream, user, and game data retrieval
- Followers and subscribers API integration
- EventSub subscription management
- Custom badge system support
- Rate limiting and caching
- Error handling and logging
- Event-driven architecture integration
