<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto;

use GuzzleHttp\Exception\BadResponseException;
use Throwable;

/**
 * What went wrong with a call to Twitch, in one format: a stable `code`, the key of its translation, and the message that
 * Twitch gave (in English, as it sent it).
 *
 * The code never changes with the wording of Twitch: the application tests it, or shows `translated()`.
 * The translations are in `lang/<locale>/errors.php` (namespace `twitch`).
 */
final readonly class TwitchError
{
    private const array CODES_BY_STATUS = [
        400 => 'bad_request',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'not_found',
        409 => 'conflict',
        410 => 'gone',
        422 => 'unprocessable',
        429 => 'rate_limited',
    ];

    /**
     * Codes that depend on the message of Twitch: [status, pattern of the message (lowercase), code]. The first that
     * matches wins; a status with no match gets the code of its family (see CODES_BY_STATUS).
     */
    private const array KNOWN_MESSAGES = [
        [
            401,
            '/invalid oauth token/',
            'token_invalid',
        ],
        [
            401,
            '/missing scope: (?<scope>.+)$/',
            'missing_scope',
        ],
        [
            401,
            '/accepts only an app access token/',
            'app_token_required',
        ],
        [
            401,
            '/incorrect user authorization|must match the user id found in the request/',
            'user_mismatch',
        ],
        [
            403,
            '/client-id header must match the client id/',
            'client_mismatch',
        ],
        [
            403,
            '/not associated with a known organization/',
            'no_organization',
        ],
        [
            400,
            '/more than one filter/',
            'multiple_filters',
        ],
        [
            400,
            '/parameter "(?<parameter>[^"]+)" was malformed/',
            'malformed_parameter',
        ],
        [
            400,
            '/bad identifiers/',
            'bad_identifiers',
        ],
        [
            400,
            '/invalid authorization code/',
            'invalid_code',
        ],
        [
            400,
            '/invalid refresh token/',
            'invalid_refresh_token',
        ],
    ];

    /**
     * @param int                   $status  HTTP status (0 when Twitch could not be reached)
     * @param string                $code    Stable code: token_invalid, missing_scope, not_found, rate_limited, network...
     * @param string                $message The message of Twitch, in English ('' when there is none)
     * @param array<string, string> $context Values of the translation (`scope`, `parameter`)
     */
    public function __construct(
        public int $status,
        public string $code,
        public string $message = '',
        public array $context = [],
    ) {}

    /**
     * The error of a failed call: the answer of Twitch when there is one, else a network error.
     */
    public static function from(Throwable $throwable): self
    {
        if (! $throwable instanceof BadResponseException) {
            return new self(
                0,
                'network',
                $throwable->getMessage(),
            );
        }

        $body = json_decode((string) $throwable->getResponse()->getBody(), true);
        $text = is_array($body) && is_string($body['message'] ?? null)
            ? $body['message']
            : '';

        return self::classify($throwable->getResponse()->getStatusCode(), $text);
    }

    /**
     * @return array{status: int, code: string, translation_key: string, message: string, context: array<string, string>}
     */
    public function toArray(): array
    {
        return [
            'status'          => $this->status,
            'code'            => $this->code,
            'translation_key' => $this->translationKey(),
            'message'         => $this->message,
            'context'         => $this->context,
        ];
    }

    /**
     * The message in the language of the application (or of `$locale`). The English message of Twitch is `:message`.
     */
    public function translated(?string $locale = null): string
    {
        $text = trans($this->translationKey(), [
            ...$this->context,
            'message' => $this->message,
        ], $locale);

        return is_string($text)
            ? $text
            : $this->code;
    }

    /**
     * The key of the translation of the code: `twitch::errors.token_invalid`.
     */
    public function translationKey(): string
    {
        return 'twitch::errors.' . $this->code;
    }

    private static function classify(int $status, string $text): self
    {
        foreach (self::KNOWN_MESSAGES as [$expected, $pattern, $code]) {
            if (
                $expected === $status
                && 1      === preg_match(
                    $pattern . 'i',
                    $text,
                    $found,
                )
            ) {
                return new self(
                    $status,
                    $code,
                    $text,
                    self::named($found),
                );
            }
        }

        return new self(
            $status,
            self::codeOfStatus($status),
            $text,
        );
    }

    private static function codeOfStatus(int $status): string
    {
        if (500 <= $status) {
            return 'server_error';
        }

        return self::CODES_BY_STATUS[$status] ?? 'error';
    }

    /**
     * @param array<int|string, mixed> $found
     *
     * @return array<string, string>
     */
    private static function named(array $found): array
    {
        $named = [];

        foreach ($found as $key => $value) {
            if (
                is_string($key)
                && is_string($value)
            ) {
                $named[$key] = $value;
            }
        }

        return $named;
    }
}
