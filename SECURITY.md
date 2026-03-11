# Security Policy

> This project follows the [Zairakai Global Security Policy][handbook-security].
> Please refer to it for standard protections, response timeline, and contact information.

---

## 🔒 Reporting Vulnerabilities

| Channel | Description | Contact / Link |
| :--- | :--- | :--- |
| **GitLab Issues** | For non-sensitive issues (bugs, public vulnerabilities). | [Open Issue][issues] |
| **Service Desk** | Preferred channel for sensitive reports. | `contact-project+zairakai-php-packages-laravel-twitch-80185450-issue-@incoming.gitlab.com` |
| **Email** | Alternative secure contact. | `security@the-white-rabbits.fr` |

Please **do not disclose vulnerabilities publicly** until they have been reviewed.

---

## 🛡️ Security Features

### Protection Layers

| Layer | Security Protection |
| :--- | :--- |
| **Static Analysis** | PHPStan Level Max + Larastan compliance and Rector modernizations. |
| **CI Pipeline** | Automated secret detection in GitLab CI. |

---

## 🔍 Security Scope

`zairakai/laravel-twitch` integrates Twitch OAuth, Helix API calls, and EventSub webhook processing:

- external HTTP calls to Twitch endpoints via Guzzle
- OAuth access/refresh token handling and storage
- webhook signature validation (`Twitch-Eventsub-Message-Signature` header)

Store credentials in environment variables only. Always set a strong `TWITCH_WEBHOOK_SECRET`
and use HTTPS for all callback and webhook URLs in production.

---

[handbook-security]: https://gitlab.com/zairakai/handbook/-/blob/main/SECURITY.md
[issues]: https://gitlab.com/zairakai/php-packages/laravel-twitch/-/issues
