<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\MonthlyActiveUsers;

class MonthlyActiveUsersTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new MonthlyActiveUsers();
        
        $this->assertEquals(0, $entity->getId());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new MonthlyActiveUsers();
        $app = new App();
        $date = new \DateTimeImmutable('2024-01-01');
        
        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());
        
        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());
        
        $entity->setValue(1000);
        $this->assertEquals(1000, $entity->getValue());
    }

    public function testToString(): void
    {
        $entity = new MonthlyActiveUsers();
        $this->assertEquals('0', $entity->__toString());
    }
}