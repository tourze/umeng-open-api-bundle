<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\DailyDuration;

class DailyDurationTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dailyDuration = new DailyDuration();
        
        $this->assertEquals(0, $dailyDuration->getId());
    }
    
    public function testToString(): void
    {
        $dailyDuration = new DailyDuration();
        $this->assertEquals('0', $dailyDuration->__toString());
    }
}