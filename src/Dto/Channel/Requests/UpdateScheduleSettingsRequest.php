<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for updating the broadcaster's stream schedule settings (e.g. vacation mode).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-channel-stream-schedule
 */
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateScheduleSettingsRequest extends Data
{
    public function __construct(
        /**
         * @var bool|null Whether vacation mode is enabled
         */
        public readonly ?bool $isVacationEnabled = null,

        /**
         * @var string|null Vacation start time (RFC3339, required if is_vacation_enabled = true)
         */
        public readonly ?string $vacationStartTime = null,

        /**
         * @var string|null Vacation end time (RFC3339, required if is_vacation_enabled = true)
         */
        public readonly ?string $vacationEndTime = null,

        /**
         * @var string|null IANA timezone (e.g. America/Los_Angeles, required if enabling vacation)
         */
        public readonly ?string $timezone = null,
    ) {}
}
