<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\DailyData;

/**
 * @internal
 */
#[CoversClass(DailyData::class)]
final class DailyDataTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyData();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'activityUsers' => ['activityUsers', 100],
            'totalUsers' => ['totalUsers', 200],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $dailyData = $this->createDailyData();

        $this->assertEquals(0, $dailyData->getId());
    }

    public function testToString(): void
    {
        $dailyData = $this->createDailyData();
        $this->assertEquals('0', $dailyData->__toString());
    }

    private function createDailyData(): DailyData
    {
        $reflection = new \ReflectionClass(DailyData::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
