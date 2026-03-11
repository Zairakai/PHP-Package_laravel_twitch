<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Structures;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\CheermoteFragment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CheermoteFragmentTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $cheermoteFragment = CheermoteFragment::from([
            'prefix' => 'Cheer',
            'bits'   => 1000,
            'tier'   => 1000,
        ]);

        $this->assertSame('Cheer', $cheermoteFragment->prefix);
        $this->assertSame(1000, $cheermoteFragment->bits);
        $this->assertSame(1000, $cheermoteFragment->tier);
    }
}
