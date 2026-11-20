<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Exceptions;

use RuntimeException;
use Throwable;
use Zairakai\LaravelTwitch\Dto\TwitchError;

/**
 * A call to Twitch failed. {@see $error} says why, in one format whatever the endpoint: a stable code, the key of its
 * translation and the message of Twitch. The exception of the HTTP client is {@see getPrevious()}.
 */
final class TwitchApiException extends RuntimeException
{
    public function __construct(
        public readonly TwitchError $error,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            '' !== $error->message
                ? $error->message
                : $error->code,
            $error->status,
            $previous,
        );
    }

    public static function from(Throwable $throwable): self
    {
        return new self(TwitchError::from($throwable), $throwable);
    }

    public function errorCode(): string
    {
        return $this->error->code;
    }

    public function status(): int
    {
        return $this->error->status;
    }
}
