<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\DailyDuration;

/**
 * @internal
 */
#[CoversClass(DailyDuration::class)]
final class DailyDurationTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new DailyDuration();
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
        $dailyDuration = $this->createDailyDuration();

        $this->assertEquals(0, $dailyDuration->getId());
    }

    public function testToString(): void
    {
        $dailyDuration = $this->createDailyDuration();
        $this->assertEquals('0', $dailyDuration->__toString());
    }

    private function createDailyDuration(): DailyDuration
    {
        $reflection = new \ReflectionClass(DailyDuration::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
