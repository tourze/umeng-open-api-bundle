<?php

namespace UmengOpenApiBundle\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use UmengOpenApiBundle\Entity\Channel;

class ChannelTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $channel = new Channel();
        
        $this->assertNull($channel->getId());
        $this->assertNull($channel->getCode());
    }

    public function testSettersAndGetters(): void
    {
        $channel = new Channel();
        
        $channel->setName('Test Channel');
        $this->assertEquals('Test Channel', $channel->getName());
        
        $channel->setCode('test_channel');
        $this->assertEquals('test_channel', $channel->getCode());
    }
}