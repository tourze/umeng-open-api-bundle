<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyNewUsers;

class DailyNewUsersTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new DailyNewUsers();
        
        $this->assertEquals(0, $entity->getId());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new DailyNewUsers();
        $app = new App();
        $date = new \DateTimeImmutable('2024-01-01');
        
        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());
        
        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());
        
        $entity->setValue(50);
        $this->assertEquals(50, $entity->getValue());
    }

    public function testToString(): void
    {
        $entity = new DailyNewUsers();
        $this->assertEquals('0', $entity->__toString());
    }
}