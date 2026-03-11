<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\MethodCyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\InlineDocCommentDeclarationSniff;

/*
 * PHP Insights Configuration — zairakai/laravel-twitch
 * -----------------------------------------------------
 *
 * This file extends the base configuration from laravel-dev-tools.
 *
 * IMPORTANT: For arrays with numeric keys (remove, add, exclude),
 * use the spread operator [...] to merge. Do NOT use array_replace_recursive()
 * as it replaces by index instead of merging.
 */

/* Load base configuration from package */
$baseConfig = [];

$currentFile   = __FILE__;
$possiblePaths = [
    /* Normal Laravel project */
    dirname(__DIR__, 2) . '/vendor/zairakai/laravel-dev-tools/config/insights.base.php',

    /* Testbench environment */
    dirname(__DIR__, 6) . '/config/insights.base.php',

    /* Local project config */
    dirname(__DIR__, 2) . '/config/insights.base.php',
];

foreach ($possiblePaths as $path) {
    if (
        file_exists($path)
        && realpath($path) !== realpath($currentFile)
    ) {
        $baseConfig = require $path;

        break;
    }
}

/*
 * ── Cyclomatic complexity ─────────────────────────────────────────────────────
 *
 * API service classes and the OAuth controller accumulate complexity through
 * branching on HTTP responses, query parameters, and optional request fields —
 * refactoring would produce dozens of tiny private methods with no readability
 * gain. These exclusions are intentional and bounded.
 */
$baseConfig['config'][CyclomaticComplexityIsHigh::class] = [
    ...($baseConfig['config'][CyclomaticComplexityIsHigh::class] ?? []),
    'exclude' => [
        ...($baseConfig['config'][CyclomaticComplexityIsHigh::class]['exclude'] ?? []),
        'Services/TwitchApiService.php',
        'Services/TwitchOAuthService.php',
        'Http/Controllers/TwitchAuthController.php',
        'Services/Concerns/HasStreamMethods.php',
        'Services/Concerns/HasModerationMethods.php',
    ],
];

$baseConfig['config'][MethodCyclomaticComplexityIsHigh::class] = [
    ...($baseConfig['config'][MethodCyclomaticComplexityIsHigh::class] ?? []),
    'exclude' => [
        ...($baseConfig['config'][MethodCyclomaticComplexityIsHigh::class]['exclude'] ?? []),
        'Services/TwitchApiService.php',
        'Services/Concerns/HasDropsMethods.php',
        'Services/Concerns/HasStreamMethods.php',
        'Services/Concerns/HasModerationMethods.php',
    ],
];

/*
 * ── Forbidden setter ─────────────────────────────────────────────────────────
 *
 * This package wraps the Twitch Helix API. Methods like setShieldMode(),
 * setExtensionConfigurationSegment(), and setAccessToken() are HTTP endpoint
 * wrappers or service configuration — not POJO setters violating DI principles.
 * The Laravel preset allows `set*Attribute` for Eloquent; we also allow the
 * broader `set*` pattern for this HTTP client context.
 */
$baseConfig['config'][ForbiddenSetterSniff::class] = [
    ...($baseConfig['config'][ForbiddenSetterSniff::class] ?? []),
    'allowedMethodRegex' => [
        ...($baseConfig['config'][ForbiddenSetterSniff::class]['allowedMethodRegex'] ?? []),
        '/^set[A-Z]/',
    ],
];

/*
 * ── ReturnAssignmentFixer — PHPStan conflict ─────────────────────────────────
 *
 * PHPStan requires `@var DataCollection<int, T> $var` annotations on named
 * variables before `return` statements — the named variable is the annotation
 * target. ReturnAssignmentFixer would inline these returns and break the
 * PHPStan type narrowing. Removing this fixer is necessary for max-level
 * PHPStan compliance.
 */
$baseConfig['remove'] = [
    ...($baseConfig['remove'] ?? []),
    ReturnAssignmentFixer::class,
    /*
     * ── InlineDocCommentDeclarationSniff — PHPStan conflict ───────────────────
     *
     * PHPStan uses `/** @var type *\/` (without $varName) to narrow return types
     * from opaque expressions like Cache::remember() and json_decode().
     * The sniff requires `@var type $varName` which is incompatible with the
     * return-statement annotation pattern PHPStan mandates at max level.
     */
    InlineDocCommentDeclarationSniff::class,
];

/*
 * ── DocCommentSpacingSniff — Pint conflict ────────────────────────────────────
 *
 * PHPInsights (Slevocat) requires 1 blank line between different annotation
 * types (@deprecated → @see). Pint's phpdoc_separation fixer removes that
 * blank line when the @deprecated has a continuation line. Since Pint is the
 * canonical formatter, we exclude the one affected file from this check.
 */
$baseConfig['config'][DocCommentSpacingSniff::class] = [
    ...($baseConfig['config'][DocCommentSpacingSniff::class] ?? []),
    'exclude' => [
        ...($baseConfig['config'][DocCommentSpacingSniff::class]['exclude'] ?? []),
        'Services/Concerns/HasTagsMethods.php',
    ],
];

/*
 * ── Line length — Rector conflict ────────────────────────────────────────────
 *
 * Rector's RenameParamToMatchTypeRector generates parameter names that match
 * the full type name (e.g. $updateConduitShardRequest). Combined with the
 * static fn closure signature and return type, the resulting line exceeds
 * 120 characters. Shortening the parameter name would be reverted by Rector
 * on the next run. We exclude the affected file rather than fight the rule.
 */
$baseConfig['config'][LineLengthSniff::class] = [
    ...($baseConfig['config'][LineLengthSniff::class] ?? []),
    'exclude' => [
        ...($baseConfig['config'][LineLengthSniff::class]['exclude'] ?? []),
        'Services/Concerns/HasConduitsMethods.php',
    ],
];

return $baseConfig;
