<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a broadcaster's AutoMod settings.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-automod-settings
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutoModSettings extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Moderator ID
         */
        public string $moderatorId,

        /**
         * @var int|null Overall level (0-4). Null if individual settings are used.
         */
        public ?int $overallLevel = null,

        /**
         * @var int Aggression filter level (0-4)
         */
        public int $aggression = 0,

        /**
         * @var int Bullying filter level (0-4)
         */
        public int $bullying = 0,

        /**
         * @var int Disability filter level (0-4)
         */
        public int $disability = 0,

        /**
         * @var int Misogyny filter level (0-4)
         */
        public int $misogyny = 0,

        /**
         * @var int Race/ethnicity/religion filter level (0-4)
         */
        public int $raceEthnicityOrReligion = 0,

        /**
         * @var int Sex-based terms filter level (0-4)
         */
        public int $sexBasedTerms = 0,

        /**
         * @var int Sexuality/sex/gender filter level (0-4)
         */
        public int $sexualitySexOrGender = 0,

        /**
         * @var int Swearing filter level (0-4)
         */
        public int $swearing = 0,
    ) {}
}
