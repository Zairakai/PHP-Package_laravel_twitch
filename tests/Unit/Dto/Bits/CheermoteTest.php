<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Bits;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Bits\Cheermote;
use Zairakai\LaravelTwitch\Dto\Bits\CheermoteTier;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CheermoteTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_snake_case_array(): void
    {
        $cheermote = Cheermote::from([
            'prefix'       => 'Cheer',
            'tiers'        => [
                [
                    'min_bits'          => 1,
                    'id'                => '1',
                    'color'             => '#979797',
                    'images'            => ['dark' => [], 'light' => []],
                    'can_cheer'         => true,
                    'show_in_bits_card' => true,
                ],
            ],
            'type'          => 'global_first_party',
            'order'         => 1,
            'last_updated'  => '2018-05-22T00:06:04Z',
            'is_charitable' => false,
        ]);

        $this->assertSame('Cheer', $cheermote->prefix);
        $this->assertSame('global_first_party', $cheermote->type);
        $this->assertSame(1, $cheermote->order);
        $this->assertFalse($cheermote->isCharitable);
        $this->assertCount(1, $cheermote->tiers);
        $this->assertInstanceOf(CheermoteTier::class, $cheermote->tiers->first());
    }

    #[Test]
    public function it_maps_tier_fields_correctly(): void
    {
        $cheermote = Cheermote::from([
            'prefix'        => 'BibleThump',
            'tiers'         => [
                [
                    'min_bits'          => 1000,
                    'id'                => '1000',
                    'color'             => '#1db2a5',
                    'images'            => [],
                    'can_cheer'         => true,
                    'show_in_bits_card' => false,
                ],
            ],
            'type'          => 'global_third_party',
            'order'         => 5,
            'last_updated'  => '2020-01-01T00:00:00Z',
            'is_charitable' => false,
        ]);

        $tier = $cheermote->tiers->first();
        $this->assertSame(1000, $tier->minBits);
        $this->assertSame('1000', $tier->id);
        $this->assertSame('#1db2a5', $tier->color);
        $this->assertTrue($tier->canCheer);
        $this->assertFalse($tier->showInBitsCard);
    }
}
