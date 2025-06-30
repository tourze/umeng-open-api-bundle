<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\DailyActiveUsers;
use UmengOpenApiBundle\Entity\App;
use DateTime;

class DailyActiveUsersTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dailyActiveUsers = new DailyActiveUsers();
        
        $this->assertEquals(0, $dailyActiveUsers->getId());
    }

    public function testSettersAndGetters(): void
    {
        $dailyActiveUsers = new DailyActiveUsers();
        $date = new DateTime('2023-01-01');
        $app = new App();
        
        $dailyActiveUsers->setDate($date);
        $this->assertEquals($date, $dailyActiveUsers->getDate());
        
        $dailyActiveUsers->setValue(1000);
        $this->assertEquals(1000, $dailyActiveUsers->getValue());
        
        $dailyActiveUsers->setApp($app);
        $this->assertSame($app, $dailyActiveUsers->getApp());
    }

    public function testToString(): void
    {
        $dailyActiveUsers = new DailyActiveUsers();
        $this->assertEquals('0', $dailyActiveUsers->__toString());
    }
}