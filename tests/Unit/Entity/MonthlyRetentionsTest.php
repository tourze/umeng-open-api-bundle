<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\MonthlyRetentions;

class MonthlyRetentionsTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new MonthlyRetentions();
        
        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getTotalInstallUser());
        $this->assertNull($entity->getRetentionRate());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new MonthlyRetentions();
        $app = new App();
        $date = new \DateTimeImmutable('2024-01-01');
        
        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());
        
        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());
        
        $entity->setTotalInstallUser(5000);
        $this->assertEquals(5000, $entity->getTotalInstallUser());
        
        $entity->setRetentionRate(80.5);
        $this->assertEquals(80.5, $entity->getRetentionRate());
    }

    public function testToString(): void
    {
        $entity = new MonthlyRetentions();
        $this->assertEquals('0', $entity->__toString());
    }
}