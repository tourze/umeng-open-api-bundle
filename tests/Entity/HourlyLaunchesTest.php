<?php

namespace UmengOpenApiBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyLaunches;

/**
 * @internal
 */
#[CoversClass(HourlyLaunches::class)]
final class HourlyLaunchesTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new HourlyLaunches();
    }

    /**
     * @return iterable<string, array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            // HourlyLaunches 使用 HourTrait，有24个小时的 setter/getter 方法
            // 测试其中一个作为示例
            'hour0' => ['hour0', 100],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // 空实现，满足 TestCase 要求
    }

    public function testBasicProperties(): void
    {
        $entity = $this->createHourlyLaunches();

        $this->assertEquals(0, $entity->getId());

        // Test hour properties from HourTrait
        $this->assertNull($entity->getHour0());
        $this->assertNull($entity->getHour1());
        $this->assertNull($entity->getHour2());
        $this->assertNull($entity->getHour3());
        $this->assertNull($entity->getHour4());
        $this->assertNull($entity->getHour5());
        $this->assertNull($entity->getHour6());
        $this->assertNull($entity->getHour7());
        $this->assertNull($entity->getHour8());
        $this->assertNull($entity->getHour9());
        $this->assertNull($entity->getHour10());
        $this->assertNull($entity->getHour11());
        $this->assertNull($entity->getHour12());
        $this->assertNull($entity->getHour13());
        $this->assertNull($entity->getHour14());
        $this->assertNull($entity->getHour15());
        $this->assertNull($entity->getHour16());
        $this->assertNull($entity->getHour17());
        $this->assertNull($entity->getHour18());
        $this->assertNull($entity->getHour19());
        $this->assertNull($entity->getHour20());
        $this->assertNull($entity->getHour21());
        $this->assertNull($entity->getHour22());
        $this->assertNull($entity->getHour23());
    }

    public function testSettersAndGetters(): void
    {
        $entity = $this->createHourlyLaunches();
        $app = $this->createApp();
        $date = new \DateTimeImmutable('2024-01-01');

        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());

        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());

        // Test hour setters from HourTrait
        $entity->setHour0(0);
        $this->assertEquals(0, $entity->getHour0());
        $entity->setHour1(10);
        $this->assertEquals(10, $entity->getHour1());
        $entity->setHour2(20);
        $this->assertEquals(20, $entity->getHour2());
        $entity->setHour3(30);
        $this->assertEquals(30, $entity->getHour3());
        $entity->setHour4(40);
        $this->assertEquals(40, $entity->getHour4());
        $entity->setHour5(50);
        $this->assertEquals(50, $entity->getHour5());
        $entity->setHour6(60);
        $this->assertEquals(60, $entity->getHour6());
        $entity->setHour7(70);
        $this->assertEquals(70, $entity->getHour7());
        $entity->setHour8(80);
        $this->assertEquals(80, $entity->getHour8());
        $entity->setHour9(90);
        $this->assertEquals(90, $entity->getHour9());
        $entity->setHour10(100);
        $this->assertEquals(100, $entity->getHour10());
        $entity->setHour11(110);
        $this->assertEquals(110, $entity->getHour11());
        $entity->setHour12(120);
        $this->assertEquals(120, $entity->getHour12());
        $entity->setHour13(130);
        $this->assertEquals(130, $entity->getHour13());
        $entity->setHour14(140);
        $this->assertEquals(140, $entity->getHour14());
        $entity->setHour15(150);
        $this->assertEquals(150, $entity->getHour15());
        $entity->setHour16(160);
        $this->assertEquals(160, $entity->getHour16());
        $entity->setHour17(170);
        $this->assertEquals(170, $entity->getHour17());
        $entity->setHour18(180);
        $this->assertEquals(180, $entity->getHour18());
        $entity->setHour19(190);
        $this->assertEquals(190, $entity->getHour19());
        $entity->setHour20(200);
        $this->assertEquals(200, $entity->getHour20());
        $entity->setHour21(210);
        $this->assertEquals(210, $entity->getHour21());
        $entity->setHour22(220);
        $this->assertEquals(220, $entity->getHour22());
        $entity->setHour23(230);
        $this->assertEquals(230, $entity->getHour23());
    }

    public function testToString(): void
    {
        $entity = $this->createHourlyLaunches();
        $this->assertEquals('0', $entity->__toString());
    }

    private function createHourlyLaunches(): HourlyLaunches
    {
        $reflection = new \ReflectionClass(HourlyLaunches::class);

        return $reflection->newInstanceWithoutConstructor();
    }

    private function createApp(): App
    {
        $reflection = new \ReflectionClass(App::class);

        return $reflection->newInstanceWithoutConstructor();
    }
}
