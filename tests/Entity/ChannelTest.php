<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\Channel;

/**
 * @internal
 */
#[CoversClass(Channel::class)]
final class ChannelTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new Channel();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'name' => ['name', 'test_value'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $channel = $this->createChannel();

        $this->assertNull($channel->getId());
        $this->assertNull($channel->getCode());
    }

    public function testSettersAndGetters(): void
    {
        $channel = $this->createChannel();

        $channel->setName('Test Channel');
        $this->assertEquals('Test Channel', $channel->getName());

        $channel->setCode('test_channel');
        $this->assertEquals('test_channel', $channel->getCode());
    }

    private function createChannel(): Channel
    {
        return new Channel();
    }
}
