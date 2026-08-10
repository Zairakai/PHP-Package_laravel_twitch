<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.moderate` payload when `action` is `automod_terms`.
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ModerateAutomodTermsAction extends Data
{
    public function __construct(
        /**
         * @var string add or remove
         */
        public string $action,

        /**
         * @var string blocked or permitted
         */
        public string $list,

        /**
         * @var array<int, string>
         */
        public array $terms,
        public bool $fromAutomod,
    ) {}
}
