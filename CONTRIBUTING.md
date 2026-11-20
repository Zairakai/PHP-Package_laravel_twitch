# Contributing

> This project follows the [Zairakai Global Contributing Guide][handbook-contributing].  
> Please read it before contributing. The sections below document project-specific workflow.
> Questions and bugs: [open an issue][issues].

---

## Development Workflow

| Step | Command / Action | Description |
| :--- | :--- | :--- |
| **1. Install** | `composer install` | Install dependencies and set up git hooks. |
| **2. Branch** | `git checkout -b feature/#TICKET-name` | Create a feature branch from `develop`. |
| **3. Code** | *(your IDE)* | Implement your changes following quality standards. |
| **4. Quality** | `make quality` | Run the full quality gate. |
| **5. Test** | `make test` | Ensure all tests are passing. |
| **6. Commit** | `git commit -m "type(scope): #TICKET subject"` | Use [Conventional Commits][git-rules] format. |
| **7. Push** | `git push origin feature/#TICKET-name` | Push and open a Merge Request to `develop`. |

---

## Types of Contributions

| Type | Guidelines |
| :--- | :--- |
| **🐛 Bug Reports** | Open an [issue][issues] with minimal reproduction steps, expected vs actual behavior, PHP/Laravel/Twitch API versions. |
| **✨ Feature Requests** | Describe the use case in an [issue][issues]. Must fit the scope (Helix API, OAuth, EventSub, TwitchUser persistence). |
| **🔌 Helix API Methods** | Add trait in `src/Services/Concerns/Has*Methods.php`. Use existing traits as reference. Add mock-based tests. |
| **🔐 OAuth / Auth** | Covers `TwitchOAuthService`, `TwitchAuthController`, and token lifecycle. All branches must be tested. |
| **📦 DTOs** | In `src/Dto/`. Use `spatie/laravel-data`. Keep DTOs immutable and typed. |
| **⚙️ ServiceProvider** | Registration, config merging, route loading only. No business logic. |

---

## Quality Targets

| Command | Tool | Description |
| :--- | :--- | :--- |
| `make quality` | All | Full static analysis and formatting gate. |
| `make phpstan` | PHPStan | PHP static analysis (Level Max). |
| `make pint` | Pint | Check code style. |
| `make pint-fix` | Pint | Fix code style automatically. |
| `make quality-fix` | All | Apply every automatic fix (Markdown, Rector, layout, Pint). |
| `make test` | PHPUnit | Run unit tests. |
| `make test-ci` | PHPUnit | Run the tests with the coverage and the junit report (`build/logs/`). |
| `make bats` | Bats | Run the structure tests of the repository. |
| `make ci` | All | The whole gate: quality, tests and Bats. |
| `make markdownlint` | Markdownlint | Validate Markdown documentation. |
| `make config-check` | laravel-dev-tools | Check that every configuration file is where its tool reads it. |
| `make setup-check` | laravel-dev-tools | Tell which published files are late on the package (`make setup-update` publishes them again). |

The configuration of each tool is in `config/dev-tools/`: edit it there, never at the root.

---

[handbook-contributing]: https://gitlab.com/zairakai/handbook/-/blob/main/CONTRIBUTING.md
[git-rules]: https://gitlab.com/zairakai/handbook/-/blob/main/policies/git-rules.md
[issues]: https://gitlab.com/zairakai/php-packages/laravel-twitch/-/issues
