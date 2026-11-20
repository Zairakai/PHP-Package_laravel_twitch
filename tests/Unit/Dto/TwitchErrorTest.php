<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\TwitchError;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * The messages are the ones that Twitch really answered (read with a real token).
 */
final class TwitchErrorTest extends TestCase
{
    /**
     * @return array<string, array{int, string, string, array<string, string>}>
     */
    public static function realAnswers(): array
    {
        return [
            'invalid token'        => [
                401,
                'Invalid OAuth token',
                'token_invalid',
                [],
            ],
            'missing scope'        => [
                401,
                'Missing scope: channel:read:stream_key or channel_read',
                'missing_scope',
                [
                    'scope' => 'channel:read:stream_key or channel_read',
                ],
            ],
            'app token only'       => [
                401,
                'The API accepts only an app access token.',
                'app_token_required',
                [],
            ],
            'other user'           => [
                401,
                'incorrect user authorization',
                'user_mismatch',
                [],
            ],
            'user id mismatch'     => [
                401,
                "The ID in user_id must match the user ID found in the request's OAuth token.",
                'user_mismatch',
                [],
            ],
            'client mismatch'      => [
                403,
                'The ID in the Client-Id header must match the client ID used to create the custom reward',
                'client_mismatch',
                [],
            ],
            'no organization'      => [
                403,
                'The client in the OAuth token is not associated with a known organization.',
                'no_organization',
                [],
            ],
            'two filters'          => [
                400,
                'cannot specify more than one filter',
                'multiple_filters',
                [],
            ],
            'malformed parameter'  => [
                400,
                'The parameter "broadcaster_id" was malformed: value must be a positive numeric',
                'malformed_parameter',
                [
                    'parameter' => 'broadcaster_id',
                ],
            ],
            'bad identifiers'      => [
                400,
                'Invalid username(s), email(s), or ID(s). Bad Identifiers.',
                'bad_identifiers',
                [],
            ],
            'nothing planned'      => [
                404,
                'segments were not found',
                'not_found',
                [],
            ],
            'conflict'             => [
                409,
                'x',
                'conflict',
                [],
            ],
            'gone'                 => [
                410,
                'x',
                'gone',
                [],
            ],
            'rate limit'           => [
                429,
                'Too Many Requests',
                'rate_limited',
                [],
            ],
            'twitch is down'       => [
                503,
                'x',
                'server_error',
                [],
            ],
            'unknown status'       => [
                418,
                'x',
                'error',
                [],
            ],
            'unknown 400'          => [
                400,
                'something new',
                'bad_request',
                [],
            ],
        ];
    }

    #[Test]
    public function every_code_is_translated_in_every_language_of_the_package(): void
    {
        $codes = array_keys($this->translations(dirname(__DIR__, 3) . '/lang/en'));
        $dirs  = glob(dirname(__DIR__, 3) . '/lang/*', GLOB_ONLYDIR);

        self::assertIsArray($dirs);

        // The languages of laravel-lang (129): the package loads them all
        self::assertGreaterThanOrEqual(129, count($dirs));

        foreach ($dirs as $dir) {
            $translations = $this->translations($dir);
            self::assertSame(
                $codes,
                array_keys($translations),
                basename($dir),
            );

            foreach ($translations as $key => $text) {
                self::assertNotSame(
                    '',
                    $text,
                    basename($dir) . ' ' . $key,
                );
            }

            // The values given to the translation must stay in it
            self::assertStringContainsString(
                ':scope',
                $translations['missing_scope'],
                basename($dir),
            );
            self::assertStringContainsString(
                ':parameter',
                $translations['malformed_parameter'],
                basename($dir),
            );
        }
    }

    #[Test]
    public function every_code_that_the_error_can_give_has_a_translation(): void
    {
        $source = (string) file_get_contents(dirname(__DIR__, 3) . '/src/Dto/TwitchError.php');
        $codes  = array_keys($this->translations(dirname(__DIR__, 3) . '/lang/en'));

        preg_match_all(
            "/\\[\\d{3}, '[^']+', '([a-z_]+)'\\]/",
            $source,
            $known,
        );
        preg_match_all(
            "/\\d{3} => '([a-z_]+)'/",
            $source,
            $byStatus,
        );

        foreach ([
            ...$known[1],
            ...$byStatus[1],
            'server_error',
            'error',
            'network',
        ] as $code) {
            self::assertContains(
                $code,
                $codes,
                $code,
            );
        }
    }

    #[Test]
    public function it_gives_a_network_error_when_twitch_cannot_be_reached(): void
    {
        $error = TwitchError::from(new ConnectException('down', new Request('GET', 'x')));

        self::assertSame(0, $error->status);
        self::assertSame('network', $error->code);
    }

    /**
     * @param array<string, string> $context
     */
    #[Test]
    #[DataProvider('realAnswers')]
    public function it_gives_a_stable_code_for_what_twitch_answers(
        int $status,
        string $message,
        string $code,
        array $context,
    ): void {
        $body  = (string) json_encode([
            'status'  => $status,
            'message' => $message,
        ]);
        $class = 500 <= $status
            ? ServerException::class
            : ClientException::class;
        $error = TwitchError::from(new $class('x', new Request('GET', 'x'), new Response(
            $status,
            [],
            $body,
        )));

        self::assertSame($status, $error->status);
        self::assertSame($code, $error->code);
        self::assertSame($context, $error->context);
        self::assertSame($message, $error->message);
        self::assertSame('twitch::errors.' . $code, $error->translationKey());
    }

    #[Test]
    public function it_gives_the_code_of_the_status_when_the_body_is_not_json(): void
    {
        $error = TwitchError::from(new ClientException(
            'x',
            new Request('GET', 'x'),
            new Response(
                404,
                [],
                '<html>',
            ),
        ));

        self::assertSame('not_found', $error->code);
        self::assertSame('', $error->message);
    }

    #[Test]
    public function it_is_translated_in_the_language_asked_for(): void
    {
        $error = new TwitchError(401, 'missing_scope', 'Missing scope: moderator:manage:banned_users', [
            'scope' => 'moderator:manage:banned_users',
        ]);

        self::assertStringContainsString('moderator:manage:banned_users', $error->translated('en'));
        self::assertStringContainsString('moderator:manage:banned_users', $error->translated('fr'));
        self::assertNotSame($error->translated('en'), $error->translated('fr'));
        self::assertSame('twitch::errors.missing_scope', $error->toArray()['translation_key']);
    }

    #[Test]
    public function the_exception_carries_the_error_and_the_original_exception(): void
    {
        $previous  = new ClientException(
            'x',
            new Request('GET', 'x'),
            new Response(
                401,
                [],
                '{"message":"Invalid OAuth token"}',
            ),
        );
        $exception = TwitchApiException::from($previous);

        self::assertSame('token_invalid', $exception->errorCode());
        self::assertSame(401, $exception->status());
        self::assertSame('Invalid OAuth token', $exception->getMessage());
        self::assertSame($previous, $exception->getPrevious());
    }

    /**
     * @return array<string, string>
     */
    private function translations(string $directory): array
    {
        $translations = require $directory . '/errors.php';
        $strings      = [];

        self::assertIsArray($translations);

        foreach ($translations as $key => $text) {
            self::assertIsString($key);
            self::assertIsString($text);
            $strings[$key] = $text;
        }

        return $strings;
    }
}
