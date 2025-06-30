<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyPerLaunchDuration;

class DailyPerLaunchDurationTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new DailyPerLaunchDuration();
        
        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getName());
        $this->assertEquals(0, $entity->getValue());
        $this->assertNull($entity->getPercent());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new DailyPerLaunchDuration();
        $app = new App();
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
        $entity = new DailyPerLaunchDuration();
        $this->assertEquals('0', $entity->__toString());
    }
}