<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Structures;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\CheermoteFragment;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\EmoteFragment;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\MentionFragment;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\MessageFragment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class MessageFragmentTest extends TestCase
{
    #[Test]
    public function it_creates_a_cheermote_fragment_with_nested_dto(): void
    {
        $messageFragment = MessageFragment::from([
            'type'      => 'cheermote',
            'text'      => 'Cheer100',
            'cheermote' => ['prefix' => 'Cheer', 'bits' => 100, 'tier' => 1],
            'emote'     => null,
            'mention'   => null,
        ]);

        $this->assertSame('cheermote', $messageFragment->type);
        $this->assertInstanceOf(CheermoteFragment::class, $messageFragment->cheermote);
        $this->assertSame(100, $messageFragment->cheermote->bits);
    }

    #[Test]
    public function it_creates_a_mention_fragment_with_nested_dto(): void
    {
        $messageFragment = MessageFragment::from([
            'type'      => 'mention',
            'text'      => '@zairakai',
            'cheermote' => null,
            'emote'     => null,
            'mention'   => ['user_id' => '99999', 'user_login' => 'zairakai', 'user_name' => 'Zairakai'],
        ]);

        $this->assertSame('mention', $messageFragment->type);
        $this->assertInstanceOf(MentionFragment::class, $messageFragment->mention);
        $this->assertSame('zairakai', $messageFragment->mention->userLogin);
    }

    #[Test]
    public function it_creates_a_text_fragment(): void
    {
        $messageFragment = MessageFragment::from([
            'type'       => 'text',
            'text'       => 'Hello world',
            'cheermote'  => null,
            'emote'      => null,
            'mention'    => null,
        ]);

        $this->assertSame('text', $messageFragment->type);
        $this->assertSame('Hello world', $messageFragment->text);
        $this->assertNull($messageFragment->cheermote);
        $this->assertNull($messageFragment->emote);
        $this->assertNull($messageFragment->mention);
    }

    #[Test]
    public function it_creates_an_emote_fragment_with_nested_dto(): void
    {
        $messageFragment = MessageFragment::from([
            'type'      => 'emote',
            'text'      => 'PogChamp',
            'cheermote' => null,
            'emote'     => ['id' => 'emote-1', 'emote_set_id' => 'set-1', 'owner_id' => 'owner-1', 'format' => ['static']],
            'mention'   => null,
        ]);

        $this->assertSame('emote', $messageFragment->type);
        $this->assertInstanceOf(EmoteFragment::class, $messageFragment->emote);
        $this->assertSame('emote-1', $messageFragment->emote->id);
    }
}
