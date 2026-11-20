<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\User;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UserTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_snake_case_array(): void
    {
        $user = User::from([
            'id'                => '12345',
            'login'             => 'zairakai',
            'display_name'      => 'Zairakai',
            'type'              => '',
            'broadcaster_type'  => 'affiliate',
            'description'       => 'Hello world',
            'profile_image_url' => 'https://example.com/avatar.jpg',
            'offline_image_url' => 'https://example.com/offline.jpg',
            'view_count'        => 9999,
            'created_at'        => '2020-01-15T12:00:00Z',
        ]);

        self::assertSame('12345', $user->id);
        self::assertSame('zairakai', $user->login);
        self::assertSame('Zairakai', $user->displayName);
        self::assertSame('', $user->type);
        self::assertSame('affiliate', $user->broadcasterType);
        self::assertSame('Hello world', $user->description);
        self::assertSame('https://example.com/avatar.jpg', $user->profileImageUrl);
        self::assertSame('https://example.com/offline.jpg', $user->offlineImageUrl);
        self::assertSame(9999, $user->viewCount);
        self::assertInstanceOf(Carbon::class, $user->createdAt);
    }

    #[Test]
    public function it_sets_email_when_scope_is_granted(): void
    {
        $user = User::from([
            'id'                => '12345',
            'login'             => 'zairakai',
            'display_name'      => 'Zairakai',
            'type'              => '',
            'broadcaster_type'  => '',
            'description'       => '',
            'profile_image_url' => '',
            'offline_image_url' => '',
            'view_count'        => 0,
            'email'             => 'stanislas@example.com',
        ]);

        self::assertSame('stanislas@example.com', $user->email);
        self::assertNull($user->createdAt);
    }
}
