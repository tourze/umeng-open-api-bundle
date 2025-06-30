<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\App;
use UmengOpenApiBundle\Entity\DailyRetentions;

class DailyRetentionsTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $entity = new DailyRetentions();
        
        $this->assertEquals(0, $entity->getId());
        $this->assertNull($entity->getTotalInstallUser());
        $this->assertNull($entity->getRetentionRate());
    }

    public function testSettersAndGetters(): void
    {
        $entity = new DailyRetentions();
        $app = new App();
        $date = new \DateTimeImmutable('2024-01-01');
        
        $entity->setApp($app);
        $this->assertSame($app, $entity->getApp());
        
        $entity->setDate($date);
        $this->assertSame($date, $entity->getDate());
        
        $entity->setTotalInstallUser(1000);
        $this->assertEquals(1000, $entity->getTotalInstallUser());
        
        $retentionData = ['1' => 800, '7' => 500, '30' => 200];
        $entity->setRetentionRate($retentionData);
        $this->assertEquals($retentionData, $entity->getRetentionRate());
    }

    public function testToString(): void
    {
        $entity = new DailyRetentions();
        $this->assertEquals('0', $entity->__toString());
    }
}