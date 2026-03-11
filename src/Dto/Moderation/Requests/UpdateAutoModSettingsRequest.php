<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for updating AutoMod settings.
 *
 * Use either overall_level OR individual category levels, not both.
 * All fields are optional — only provided fields will be updated.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-automod-settings
 */
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateAutoModSettingsRequest extends Data
{
    public function __construct(
        /**
         * @var int|null Overall AutoMod level (0-4). Overrides individual settings.
         */
        public readonly ?int $overallLevel = null,

        /**
         * @var int|null Aggression filter level (0-4)
         */
        public readonly ?int $aggression = null,

        /**
         * @var int|null Bullying filter level (0-4)
         */
        public readonly ?int $bullying = null,

        /**
         * @var int|null Disability filter level (0-4)
         */
        public readonly ?int $disability = null,

        /**
         * @var int|null Misogyny filter level (0-4)
         */
        public readonly ?int $misogyny = null,

        /**
         * @var int|null Race/ethnicity/religion filter level (0-4)
         */
        public readonly ?int $raceEthnicityOrReligion = null,

        /**
         * @var int|null Sex-based terms filter level (0-4)
         */
        public readonly ?int $sexBasedTerms = null,

        /**
         * @var int|null Sexuality/sex/gender filter level (0-4)
         */
        public readonly ?int $sexualitySexOrGender = null,

        /**
         * @var int|null Swearing filter level (0-4)
         */
        public readonly ?int $swearing = null,
    ) {}
}
