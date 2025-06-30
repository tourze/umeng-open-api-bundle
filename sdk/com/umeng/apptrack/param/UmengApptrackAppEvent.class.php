<?php

class UmengApptrackAppEvent extends SDKDomain
{
    private $eventName;

    private $eventNumber;

    private $stdResult;

    private $arrayResult;

    /**
     * @return string 自定义事件名称
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * 设置自定义事件名称
     *
     * @param string $eventName
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return mixed 自定义事件值
     */
    public function getEventNumber()
    {
        return $this->eventNumber;
    }

    /**
     * 设置自定义事件值
     *
     * @param Long $eventNumber
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventNumber($eventNumber)
    {
        $this->eventNumber = $eventNumber;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'eventName')) {
            $this->eventName = $this->stdResult->{'eventName'};
        }
        if (property_exists($this->stdResult, 'eventNumber')) {
            $this->eventNumber = $this->stdResult->{'eventNumber'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('eventName')) {
            $this->eventName = $arrayResult['eventName'];
        }
        if ($arrayResult->offsetExists('eventNumber')) {
            $this->eventNumber = $arrayResult['eventNumber'];
        }
    }
}
