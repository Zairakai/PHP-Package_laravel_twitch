<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\AutoModSettings;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class AutoModSettingsTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $autoModSettings = AutoModSettings::from([
            'broadcaster_id'             => '12345',
            'moderator_id'               => '67890',
            'overall_level'              => 2,
            'aggression'                 => 2,
            'bullying'                   => 1,
            'disability'                 => 0,
            'misogyny'                   => 0,
            'race_ethnicity_or_religion' => 1,
            'sex_based_terms'            => 0,
            'sexuality_sex_or_gender'    => 0,
            'swearing'                   => 0,
        ]);

        $this->assertSame('12345', $autoModSettings->broadcasterId);
        $this->assertSame('67890', $autoModSettings->moderatorId);
        $this->assertSame(2, $autoModSettings->overallLevel);
        $this->assertSame(2, $autoModSettings->aggression);
        $this->assertSame(1, $autoModSettings->bullying);
    }

    #[Test]
    public function it_defaults_level_fields_to_zero(): void
    {
        $autoModSettings = AutoModSettings::from([
            'broadcaster_id' => '12345',
            'moderator_id'   => '67890',
        ]);

        $this->assertNull($autoModSettings->overallLevel);
        $this->assertSame(0, $autoModSettings->aggression);
        $this->assertSame(0, $autoModSettings->swearing);
    }
}
