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
                'cost'         => [
                    'amount' => 100,
                    'type'   => 'bits',
                ],
                'display_name' => 'Test Product',
            ],
        ]);

        self::assertSame('tx-uuid-1234', $extensionTransaction->id);
        self::assertSame('2024-01-28T04:15:53.325Z', $extensionTransaction->timestamp);
        self::assertSame('439964613', $extensionTransaction->broadcasterId);
        self::assertSame('twitchdev', $extensionTransaction->broadcasterLogin);
        self::assertSame('TwitchDev', $extensionTransaction->broadcasterName);
        self::assertSame('527115020', $extensionTransaction->userId);
        self::assertSame('twitchuser', $extensionTransaction->userLogin);
        self::assertSame('TwitchUser', $extensionTransaction->userName);
        self::assertSame('BITS_IN_EXTENSION', $extensionTransaction->productType);
        self::assertIsArray($extensionTransaction->productData);
        self::assertSame('testSku100', $extensionTransaction->productData['sku']);
    }
}
