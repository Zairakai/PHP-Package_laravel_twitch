<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Channel\SearchChannel;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\CustomReward;
use Zairakai\LaravelTwitch\Dto\TwitchData;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * A DTO hands back what Twitch sent, typed: "false" must not become true, "5" must become 5.
 */
final class TwitchDataTest extends TestCase
{
    /**
     * @return iterable<string, array{0: mixed, 1: bool}>
     */
    public static function booleans(): iterable
    {
        yield 'true'         => [
            true,
            true,
        ];

        yield 'false'        => [
            false,
            false,
        ];

        yield 'string true'  => [
            'true',
            true,
        ];

        yield 'string false' => [
            'false',
            false,
        ];

        yield 'upper false'  => [
            'FALSE',
            false,
        ];

        yield 'padded true'  => [
            ' true ',
            true,
        ];

        yield 'string 1'     => [
            '1',
            true,
        ];

        yield 'string 0'     => [
            '0',
            false,
        ];

        yield 'int 1'        => [
            1,
            true,
        ];

        yield 'int 0'        => [
            0,
            false,
        ];

        yield 'empty'        => [
            '',
            false,
        ];
    }

    #[Test]
    #[DataProvider('booleans')]
    public function it_converts_a_boolean_sent_in_any_form(mixed $sent, bool $expected): void
    {
        self::assertSame($expected, $this->make([
            'is_live' => $sent,
        ])->isLive);
    }

    #[Test]
    public function it_converts_numbers_sent_as_strings(): void
    {
        $dto = $this->make([
            'view_count' => '42',
            'duration'   => '12.5',
            'delay'      => '-3',
        ]);

        self::assertSame(42, $dto->viewCount);
        self::assertSame(12.5, $dto->duration);
        self::assertSame(-3, $dto->delay);
    }

    #[Test]
    public function it_converts_the_booleans_of_a_real_dto(): void
    {
        $searchChannel = SearchChannel::from([
            'id'                   => '1',
            'display_name'         => 'Someone',
            'broadcaster_login'    => 'someone',
            'broadcaster_language' => 'en',
            'game_id'              => '',
            'game_name'            => '',
            'title'                => '',
            'is_live'              => 'false',
            'thumbnail_url'        => '',
        ]);

        self::assertFalse($searchChannel->isLive);
    }

    #[Test]
    public function it_keeps_a_cost_of_one_point_a_number(): void
    {
        $customReward = CustomReward::from([
            'broadcaster_id'                        => '1',
            'broadcaster_login'                     => 'b',
            'broadcaster_name'                      => 'B',
            'id'                                    => 'r1',
            'title'                                 => 'One point',
            'prompt'                                => '',
            'cost'                                  => 1,
            'background_color'                      => '#9147FF',
            'is_enabled'                            => 1,
            'is_user_input_required'                => 0,
            'is_paused'                             => false,
            'is_in_stock'                           => true,
            'should_redemptions_skip_request_queue' => false,
            'redemptions_redeemed_current_stream'   => 1,
        ]);

        self::assertSame(1, $customReward->cost);
        self::assertSame(1, $customReward->redemptionsRedeemedCurrentStream);
        self::assertTrue($customReward->isEnabled);
        self::assertFalse($customReward->isUserInputRequired);
    }

    #[Test]
    public function it_keeps_null_for_a_nullable_property(): void
    {
        $dto = $this->make([
            'is_mature' => null,
            'delay'     => null,
        ]);

        self::assertNull($dto->isMature);
        self::assertNull($dto->delay);
    }

    #[Test]
    public function it_never_turns_a_real_number_into_a_boolean(): void
    {
        // A count, a cost in channel points or a delay can legitimately be 1 or 0: only a property declared bool
        // is converted to a boolean.
        $dto = $this->make([
            'view_count' => 1,
            'duration'   => 1,
            'delay'      => 0,
        ]);

        self::assertSame(1, $dto->viewCount);
        self::assertSame(1.0, $dto->duration);
        self::assertSame(0, $dto->delay);

        $dto = $this->make([
            'view_count' => '1',
            'delay'      => '0',
        ]);

        self::assertSame(1, $dto->viewCount);
        self::assertSame(0, $dto->delay);
    }

    #[Test]
    public function it_reads_a_converted_value_under_a_renamed_key(): void
    {
        self::assertFalse($this->make([
            'FLAG' => 'false',
        ])->flagged);
    }

    /**
     * @param array<string, mixed> $overrides
     */
    private function make(array $overrides): ConvertedValues
    {
        return ConvertedValues::from($overrides + [
            'is_live'    => true,
            'is_mature'  => false,
            'view_count' => 1,
            'duration'   => 1.0,
        ]);
    }
}

#[MapInputName(SnakeCaseMapper::class)]
final class ConvertedValues extends TwitchData
{
    public function __construct(
        public bool $isLive,
        public ?bool $isMature,
        public int $viewCount,
        public float $duration,
        public ?int $delay = null,
        #[MapInputName('FLAG')]
        public bool $flagged = true,
    ) {}
}
