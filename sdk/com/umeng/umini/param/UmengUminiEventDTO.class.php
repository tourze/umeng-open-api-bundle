<?php

class UmengUminiEventDTO extends SDKDomain
{
    private $eventName;

    private $displayName;

    private $stdResult;

    /**
     * @return mixed 事件名
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * 设置事件名
     *
     * @param string $eventName
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return mixed 事件显示名
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * 设置事件显示名
     *
     * @param string $displayName
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'eventName')) {
            $this->eventName = $this->stdResult->eventName;
        }
        if (property_exists($this->stdResult, 'displayName')) {
            $this->displayName = $this->stdResult->displayName;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('eventName')) {
            $this->eventName = $arrayResult['eventName'];
        }
        if ($arrayResult->offsetExists('displayName')) {
            $this->displayName = $arrayResult['displayName'];
        }
    }
}
