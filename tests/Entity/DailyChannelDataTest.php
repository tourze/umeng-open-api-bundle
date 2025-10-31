<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\Channel;
use UmengOpenApiBundle\Entity\DailyChannelData;

/**
 * @internal
 */
#[CoversClass(DailyChannelData::class)]
final class DailyChannelDataTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyChannelData();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'launch' => ['launch', 100],
            'duration' => ['duration', '3600'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $entity = $this->createDailyChannelData();

        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getChannel());
        // getDate() method requires a date to be set first
        $this->assertNull($entity->getLaunch());
        $this->assertNull($entity->getDuration());
        $this->assertNull($entity->getTotalUserRate());
        $this->assertNull($entity->getActiveUser());
        $this->assertNull($entity->getNewUser());
        $this->assertNull($entity->getTotalUser());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createDailyChannelData();
        $channel = $this->createChannel();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setChannel($channel);
        $this->assertSame($channel, $entity->getChannel());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setLaunch(100);
        $this->assertEquals(100, $entity->getLaunch());

        $entity->setDuration('3600');
        $this->assertEquals('3600', $entity->getDuration());

        $entity->setTotalUserRate(0.25);
        $this->assertEquals(0.25, $entity->getTotalUserRate());

        $entity->setActiveUser(50);
        $this->assertEquals(50, $entity->getActiveUser());

        $entity->setNewUser(10);
        $this->assertEquals(10, $entity->getNewUser());

        $entity->setTotalUser(200);
        $this->assertEquals(200, $entity->getTotalUser());
    }

    public function testToString(): void
    {
        $entity = $this->createDailyChannelData();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createDailyChannelData(): DailyChannelData
    {
        $reflection = new \ReflectionClass(DailyChannelData::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createChannel(): Channel
    {
        return new Channel();
    }
}
