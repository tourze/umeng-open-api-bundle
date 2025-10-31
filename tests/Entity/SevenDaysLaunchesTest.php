<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\SevenDaysLaunches;

/**
 * @internal
 */
#[CoversClass(SevenDaysLaunches::class)]
final class SevenDaysLaunchesTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new SevenDaysLaunches();
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
        $entity = $this->createSevenDaysLaunches();

        $this->assertEquals(0, $entity->getId());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createSevenDaysLaunches();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        $entity->setValue(350);
        $this->assertEquals(350, $entity->getValue());
    }

    public function testToString(): void
    {
        $entity = $this->createSevenDaysLaunches();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createSevenDaysLaunches(): SevenDaysLaunches
    {
        $reflection = new \ReflectionClass(SevenDaysLaunches::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
