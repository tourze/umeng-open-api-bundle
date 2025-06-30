<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\MonthlyLaunches;

class MonthlyLaunchesTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new MonthlyLaunches();
        
        $this->assertEquals(0, $entity->getId());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new MonthlyLaunches();
        $app = new App();
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
        $entity = new MonthlyLaunches();
        $this->assertEquals('0', $entity->__toString());
    }
}