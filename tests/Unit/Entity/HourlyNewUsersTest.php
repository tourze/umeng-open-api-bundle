<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\HourlyNewUsers;

class HourlyNewUsersTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new HourlyNewUsers();
        
        $this->assertEquals(0, $entity->getId());
        
        // Test hour properties from HourTrait
        for ($i = 0; $i < 24; $i++) {
            $getter = 'getHour' . $i;
            /** @phpstan-ignore-next-line */
            $this->assertNull($entity->$getter());
        }
    }

    public function testSettersAndGetters(): void
    {
        $entity = new HourlyNewUsers();
        $app = new App();
        $date = new \DateTimeImmutable('2024-01-01');
        
        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());
        
        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());
        
        // Test hour setters from HourTrait
        for ($i = 0; $i < 24; $i++) {
            $setter = 'setHour' . $i;
            $getter = 'getHour' . $i;
            $value = $i * 10;
            
            /** @phpstan-ignore-next-line */
            $entity->$setter($value);
            /** @phpstan-ignore-next-line */
            $this->assertEquals($value, $entity->$getter());
        }
    }

    public function testToString(): void
    {
        $entity = new HourlyNewUsers();
        $this->assertEquals('0', $entity->__toString());
    }
}