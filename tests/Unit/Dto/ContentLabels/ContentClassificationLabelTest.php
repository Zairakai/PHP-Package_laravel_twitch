<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\ContentLabels;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\ContentLabels\ContentClassificationLabel;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ContentClassificationLabelTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $contentClassificationLabel = ContentClassificationLabel::from([
            'id'          => 'MatureGame',
            'description' => 'Indicates that the game being played may have mature-rated content.',
            'name'        => 'Mature-rated game',
        ]);

        $this->assertSame('MatureGame', $contentClassificationLabel->id);
        $this->assertSame('Indicates that the game being played may have mature-rated content.', $contentClassificationLabel->description);
        $this->assertSame('Mature-rated game', $contentClassificationLabel->name);
    }
}
