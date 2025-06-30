<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\DailyData;

class DailyDataTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dailyData = new DailyData();
        
        $this->assertEquals(0, $dailyData->getId());
    }
    
    public function testToString(): void
    {
        $dailyData = new DailyData();
        $this->assertEquals('0', $dailyData->__toString());
    }
}