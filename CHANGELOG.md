# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Typed DTOs for all 76 EventSub subscription types Twitch documents (`Dto/EventSub/Events/*`),
  each verified field-by-field against the official example payload (fetched 2026-08-09) -
  covers follows, subs (new/gift/resub/end), cheers, raids, channel points redemptions
  (add/update), polls, predictions, hype train, goals, charity, bans/unbans, moderators, VIPs,
  shoutouts, chat (message/notification/clear/settings/automod holds), shared chat, shield mode,
  guest star, warnings, suspicious users, ad breaks, extensions, drops, conduits and user
  authorization/whisper events
- `GenericEventSubEvent` fallback DTO for any subscription type without a dedicated DTO yet -
  every notification is now typed at the object level, none are silently dropped
- `EventSubEventFactory` resolving a raw notification into its typed DTO
- `EventSubEventFactoryRealPayloadsTest`: round-trips every mapped type through the factory
  using the exact official example payload, proving each DTO actually constructs from real
  Twitch data (not just that it compiles)
- `channel.chat.message` and 18 other high-value trigger types added to the default
  `enabled_events` list in `config/twitch.php`
- GitLab CI/CD pipeline for automated testing and publishing
- Enhanced test coverage reporting
- Security audit and dependency checking automation

### Changed

- **Breaking**: `TwitchAuthController::handleEventSubNotification()` now dispatches a
  `twitch.{type}` Laravel event with a typed DTO payload for every EventSub subscription type,
  replacing the previous hardcoded 4-type dispatch (raw arrays) and the `twitch.webhook.received`
  catch-all event
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
