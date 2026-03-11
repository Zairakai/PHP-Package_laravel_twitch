<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Bits;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Bits\ExtensionTransaction;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ExtensionTransactionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_snake_case_array(): void
    {
        $extensionTransaction = ExtensionTransaction::from([
            'id'                => 'tx-uuid-1234',
            'timestamp'         => '2024-01-28T04:15:53.325Z',
            'broadcaster_id'    => '439964613',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'user_id'           => '527115020',
            'user_login'        => 'twitchuser',
            'user_name'         => 'TwitchUser',
            'product_type'      => 'BITS_IN_EXTENSION',
            'product_data'      => [
                'sku'          => 'testSku100',
                'cost'         => ['amount' => 100, 'type' => 'bits'],
                'display_name' => 'Test Product',
            ],
        ]);

        $this->assertSame('tx-uuid-1234', $extensionTransaction->id);
        $this->assertSame('2024-01-28T04:15:53.325Z', $extensionTransaction->timestamp);
        $this->assertSame('439964613', $extensionTransaction->broadcasterId);
        $this->assertSame('twitchdev', $extensionTransaction->broadcasterLogin);
        $this->assertSame('TwitchDev', $extensionTransaction->broadcasterName);
        $this->assertSame('527115020', $extensionTransaction->userId);
        $this->assertSame('twitchuser', $extensionTransaction->userLogin);
        $this->assertSame('TwitchUser', $extensionTransaction->userName);
        $this->assertSame('BITS_IN_EXTENSION', $extensionTransaction->productType);
        $this->assertIsArray($extensionTransaction->productData);
        $this->assertSame('testSku100', $extensionTransaction->productData['sku']);
    }
}
