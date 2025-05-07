<?php

class ExampleHouse extends SDKDomain
{
    private $location;

    private $areaSize;

    private $rent;

    private $rooms;

    private $stdResult;

    private $arrayResult;

    public function getLocation()
    {
        return $this->location;
    }

    /**
     * 设置
     *
     * @param string $location
     *                         参数示例：<pre></pre>
     *                         此参数必填
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getAreaSize()
    {
        return $this->areaSize;
    }

    /**
     * 设置
     *
     * @param int $areaSize
     *                      参数示例：<pre></pre>
     *                      此参数必填
     */
    public function setAreaSize($areaSize)
    {
        $this->areaSize = $areaSize;
    }

    public function getRent()
    {
        return $this->rent;
    }

    /**
     * 设置
     *
     * @param bool $rent
     *                   参数示例：<pre></pre>
     *                   此参数必填
     */
    public function setRent($rent)
    {
        $this->rent = $rent;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * 设置
     *
     * @param int $rooms
     *                   参数示例：<pre></pre>
     *                   此参数必填
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'location')) {
            $this->location = $this->stdResult->{'location'};
        }
        if (property_exists($this->stdResult, 'areaSize')) {
            $this->areaSize = $this->stdResult->{'areaSize'};
        }
        if (property_exists($this->stdResult, 'rent')) {
            $this->rent = $this->stdResult->{'rent'};
        }
        if (property_exists($this->stdResult, 'rooms')) {
            $this->rooms = $this->stdResult->{'rooms'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('location')) {
            $this->location = $arrayResult['location'];
        }
        if ($arrayResult->offsetExists('areaSize')) {
            $this->areaSize = $arrayResult['areaSize'];
        }
        if ($arrayResult->offsetExists('rent')) {
            $this->rent = $arrayResult['rent'];
        }
        if ($arrayResult->offsetExists('rooms')) {
            $this->rooms = $arrayResult['rooms'];
        }
    }
}
