<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\MonthlyLaunches;

/**
 * @internal
 */
#[CoversClass(MonthlyLaunches::class)]
final class MonthlyLaunchesTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new MonthlyLaunches();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'value' => ['value', 123],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $entity = $this->createMonthlyLaunches();

        $this->assertEquals(0, $entity->getId());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createMonthlyLaunches();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setValue(500);
        $this->assertEquals(500, $entity->getValue());
    }

    public function testToString(): void
    {
        $entity = $this->createMonthlyLaunches();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createMonthlyLaunches(): MonthlyLaunches
    {
        $reflection = new \ReflectionClass(MonthlyLaunches::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
