<?php

class UmengUminiMultiIndiceDTO extends SDKDomain
{
    private $gmtModified;

    private $indicesId;

    private $code;

    private $propertyName;

    private $displayName;

    private $eventName;

    private $stdResult;

    private $arrayResult;

    /**
     * @return string 修改时间
     */
    public function getGmtModified()
    {
        return $this->gmtModified;
    }

    /**
     * 设置修改时间
     *
     * @param string $gmtModified
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setGmtModified($gmtModified)
    {
        $this->gmtModified = $gmtModified;
    }

    /**
     * @return string 指标ID
     */
    public function getIndicesId()
    {
        return $this->indicesId;
    }

    /**
     * 设置指标ID
     *
     * @param string $indicesId
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setIndicesId($indicesId)
    {
        $this->indicesId = $indicesId;
    }

    /**
     * @return int 指标类型（触发用户数：event_device，触发次数：event_count，累计值：property_num_sum）
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 设置指标类型（触发用户数：event_device，触发次数：event_count，累计值：property_num_sum）
     *
     * @param string $code
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed 属性名
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * 设置属性名
     *
     * @param string $propertyName
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return mixed 指标名
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * 设置指标名
     *
     * @param string $displayName
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string 事件名称
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * 设置事件名称
     *
     * @param string $eventName
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'gmtModified')) {
            $this->gmtModified = $this->stdResult->{'gmtModified'};
        }
        if (property_exists($this->stdResult, 'indicesId')) {
            $this->indicesId = $this->stdResult->{'indicesId'};
        }
        if (property_exists($this->stdResult, 'code')) {
            $this->code = $this->stdResult->{'code'};
        }
        if (property_exists($this->stdResult, 'propertyName')) {
            $this->propertyName = $this->stdResult->{'propertyName'};
        }
        if (property_exists($this->stdResult, 'displayName')) {
            $this->displayName = $this->stdResult->{'displayName'};
        }
        if (property_exists($this->stdResult, 'eventName')) {
            $this->eventName = $this->stdResult->{'eventName'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('gmtModified')) {
            $this->gmtModified = $arrayResult['gmtModified'];
        }
        if ($arrayResult->offsetExists('indicesId')) {
            $this->indicesId = $arrayResult['indicesId'];
        }
        if ($arrayResult->offsetExists('code')) {
            $this->code = $arrayResult['code'];
        }
        if ($arrayResult->offsetExists('propertyName')) {
            $this->propertyName = $arrayResult['propertyName'];
        }
        if ($arrayResult->offsetExists('displayName')) {
            $this->displayName = $arrayResult['displayName'];
        }
        if ($arrayResult->offsetExists('eventName')) {
            $this->eventName = $arrayResult['eventName'];
        }
    }
}
