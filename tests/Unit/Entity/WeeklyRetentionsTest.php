<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\WeeklyRetentions;

class WeeklyRetentionsTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new WeeklyRetentions();
        
        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getTotalInstallUser());
        $this->assertNull($entity->getRetentionRate());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new WeeklyRetentions();
        $app = new App();
        $date = new \DateTimeImmutable('2024-01-01');
        
        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());
        
        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());
        
        $entity->setTotalInstallUser(2000);
        $this->assertEquals(2000, $entity->getTotalInstallUser());
        
        $entity->setRetentionRate(75.3);
        $this->assertEquals(75.3, $entity->getRetentionRate());
    }

    public function testToString(): void
    {
        $entity = new WeeklyRetentions();
        $this->assertEquals('0', $entity->__toString());
    }
}