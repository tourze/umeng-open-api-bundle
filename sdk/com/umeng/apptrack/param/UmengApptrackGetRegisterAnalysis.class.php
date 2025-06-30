<?php

class UmengApptrackGetRegisterAnalysis extends SDKDomain
{
    private $registerId;

    private $eventDs;

    private $activateDs;

    private $clickDs;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 注册id
     */
    public function getRegisterId()
    {
        return $this->registerId;
    }

    /**
     * 设置注册id
     *
     * @param string $registerId
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setRegisterId($registerId)
    {
        $this->registerId = $registerId;
    }

    /**
     * @return string 注册日期
     */
    public function getEventDs()
    {
        return $this->eventDs;
    }

    /**
     * 设置注册日期
     *
     * @param string $eventDs
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventDs($eventDs)
    {
        $this->eventDs = $eventDs;
    }

    /**
     * @return string 激活日期
     */
    public function getActivateDs()
    {
        return $this->activateDs;
    }

    /**
     * 设置激活日期
     *
     * @param string $activateDs
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setActivateDs($activateDs)
    {
        $this->activateDs = $activateDs;
    }

    /**
     * @return string 点击日期
     */
    public function getClickDs()
    {
        return $this->clickDs;
    }

    /**
     * 设置点击日期
     *
     * @param string $clickDs
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setClickDs($clickDs)
    {
        $this->clickDs = $clickDs;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'registerId')) {
            $this->registerId = $this->stdResult->{'registerId'};
        }
        if (property_exists($this->stdResult, 'eventDs')) {
            $this->eventDs = $this->stdResult->{'eventDs'};
        }
        if (property_exists($this->stdResult, 'activateDs')) {
            $this->activateDs = $this->stdResult->{'activateDs'};
        }
        if (property_exists($this->stdResult, 'clickDs')) {
            $this->clickDs = $this->stdResult->{'clickDs'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('registerId')) {
            $this->registerId = $arrayResult['registerId'];
        }
        if ($arrayResult->offsetExists('eventDs')) {
            $this->eventDs = $arrayResult['eventDs'];
        }
        if ($arrayResult->offsetExists('activateDs')) {
            $this->activateDs = $arrayResult['activateDs'];
        }
        if ($arrayResult->offsetExists('clickDs')) {
            $this->clickDs = $arrayResult['clickDs'];
        }
    }
}
