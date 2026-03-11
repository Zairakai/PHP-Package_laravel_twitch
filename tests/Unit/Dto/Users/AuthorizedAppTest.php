<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\AuthorizedApp;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class AuthorizedAppTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $authorizedApp = AuthorizedApp::from([
            'client_id'   => 'client-abc',
            'description' => 'My Twitch App',
            'scopes'      => ['user:read:email', 'channel:read:subscriptions'],
            'created_at'  => '2023-01-01T00:00:00Z',
            'updated_at'  => '2024-01-01T00:00:00Z',
        ]);

        $this->assertSame('client-abc', $authorizedApp->clientId);
        $this->assertSame(['user:read:email', 'channel:read:subscriptions'], $authorizedApp->scopes);
        $this->assertInstanceOf(Carbon::class, $authorizedApp->createdAt);
        $this->assertInstanceOf(Carbon::class, $authorizedApp->updatedAt);
    }
}
