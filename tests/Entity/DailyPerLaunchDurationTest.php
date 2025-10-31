<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;

/**
 * @internal
 */
#[CoversClass(DailyPerLaunchDuration::class)]
final class DailyPerLaunchDurationTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyPerLaunchDuration();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'name' => ['name', '0-10'],
            'value' => ['value', 123],
            'percent' => ['percent', 25.5],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $entity = $this->createDailyPerLaunchDuration();

        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getName());
        $this->assertEquals(0, $entity->getValue());
        $this->assertNull($entity->getPercent());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createDailyPerLaunchDuration();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setName('0-10');
        $this->assertEquals('0-10', $entity->getName());

        $entity->setValue(100);
        $this->assertEquals(100, $entity->getValue());

        $entity->setPercent(25.5);
        $this->assertEquals(25.5, $entity->getPercent());
    }

    public function testToString(): void
    {
        $entity = $this->createDailyPerLaunchDuration();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createDailyPerLaunchDuration(): DailyPerLaunchDuration
    {
        $reflection = new \ReflectionClass(DailyPerLaunchDuration::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
