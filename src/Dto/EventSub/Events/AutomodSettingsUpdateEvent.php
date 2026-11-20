<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `automod.settings.update` EventSub notification.
 *
 * Unlike every other EventSub type, Twitch's own official example wraps this
 * event's fields in a single-item `data` array (verified verbatim against the
 * docs on 2026-08-09, not an extraction artifact) - kept as-is to match the
 * documented contract rather than silently reshaping it.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#automodsettingsupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutomodSettingsUpdateEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public ?string $broadcasterUserId = null,
        public ?string $broadcasterUserLogin = null,
        public ?string $broadcasterUserName = null,
        public ?string $moderatorUserId = null,
        public ?string $moderatorUserLogin = null,
        public ?string $moderatorUserName = null,

        /**
         * @var int|null Overall level, null when the individual settings do not match one
         */
        public ?int $overallLevel = null,
        public ?int $disability = null,
        public ?int $aggression = null,
        public ?int $sexualitySexOrGender = null,
        public ?int $misogyny = null,
        public ?int $bullying = null,
        public ?int $swearing = null,
        public ?int $raceEthnicityOrReligion = null,
        public ?int $sexBasedTerms = null,

        /**
         * @var array<int, array<string, mixed>> The example of the reference wraps the settings in a single-item
         *                                       list: they are also read from there, so both shapes give the fields above
         */
        public array $data = [],
    ) {}

    /**
     * The reference lists the settings at the top level, its example wraps them in `data[0]`: either is read.
     *
     * @param array<mixed> $properties
     *
     * @return array<mixed>
     */
    public static function prepareForPipeline(array $properties): array
    {
        $properties = parent::prepareForPipeline($properties);
        $data       = $properties['data'] ?? null;
        $wrapped    = is_array($data)
            ? ($data[0] ?? null)
            : null;

        if (is_array($wrapped)) {
            $properties += $wrapped;
        }

        return $properties;
    }

    public function getBroadcasterUserId(): ?string
    {
        return $this->broadcasterUserId;
    }
}
