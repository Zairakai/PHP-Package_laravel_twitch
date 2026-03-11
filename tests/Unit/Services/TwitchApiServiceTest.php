<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services;

use DateTime;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Zairakai\LaravelTwitch\Services\Concerns\HasAdsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasAnalyticsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasBitsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasChannelMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasChannelPointsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasCharityMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasChatMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasConduitsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasContentLabelsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasDropsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasEventSubMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasExtensionsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasGameMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasGoalsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasGuestStarMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasModerationMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasPollMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasPredictionMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasRaidMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasStreamMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasTagsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasTeamsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasUserMethods;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchApiServiceTest extends TestCase
{
    // ── TWITCH_API_DOC_DATE ───────────────────────────────────────────────────

    #[Test]
    public function it_has_a_valid_twitch_api_doc_date_constant(): void
    {
        $date = TwitchApiService::TWITCH_API_DOC_DATE;

        $parsed = DateTime::createFromFormat('Y-m-d', $date);

        $this->assertNotFalse($parsed, "TWITCH_API_DOC_DATE '{$date}' is not a valid Y-m-d date.");
        $this->assertSame($date, $parsed->format('Y-m-d'));
    }

    // ── Trait usage ───────────────────────────────────────────────────────────

    #[Test]
    public function it_uses_all_23_expected_traits(): void
    {
        $expectedTraits = [
            HasAdsMethods::class,
            HasAnalyticsMethods::class,
            HasBitsMethods::class,
            HasChannelMethods::class,
            HasChannelPointsMethods::class,
            HasCharityMethods::class,
            HasChatMethods::class,
            HasConduitsMethods::class,
            HasContentLabelsMethods::class,
            HasDropsMethods::class,
            HasEventSubMethods::class,
            HasExtensionsMethods::class,
            HasGameMethods::class,
            HasGoalsMethods::class,
            HasGuestStarMethods::class,
            HasModerationMethods::class,
            HasPollMethods::class,
            HasPredictionMethods::class,
            HasRaidMethods::class,
            HasStreamMethods::class,
            HasTagsMethods::class,
            HasTeamsMethods::class,
            HasUserMethods::class,
        ];

        $reflectionClass  = new ReflectionClass(TwitchApiService::class);
        $usedTraits       = array_keys($reflectionClass->getTraits());

        $this->assertCount(23, $expectedTraits);

        foreach ($expectedTraits as $expectedTrait) {
            $this->assertContains(
                $expectedTrait,
                $usedTraits,
                "TwitchApiService is expected to use trait {$expectedTrait} but it does not.",
            );
        }
    }

    #[Test]
    public function it_uses_exactly_23_traits(): void
    {
        $reflectionClass = new ReflectionClass(TwitchApiService::class);
        $usedTraits      = $reflectionClass->getTraits();

        $this->assertCount(23, $usedTraits, sprintf(
            'TwitchApiService uses %d trait(s), but exactly 23 are expected.',
            count($usedTraits),
        ));
    }
}
