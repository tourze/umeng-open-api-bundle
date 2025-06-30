<?php

class UmengUminiEventIndicatorDTO extends SDKDomain
{
    private $dateTime;

    private $count;

    private $device;

    private $stdResult;

    private $arrayResult;

    /**
     * @return string 时间
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * 设置时间
     *
     * @param string $dateTime
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return int 触发次数
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * 设置触发次数
     *
     * @param Long $count
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed 触发用户数
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * 设置触发用户数
     *
     * @param Long $device
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'dateTime')) {
            $this->dateTime = $this->stdResult->{'dateTime'};
        }
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->{'count'};
        }
        if (property_exists($this->stdResult, 'device')) {
            $this->device = $this->stdResult->{'device'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('dateTime')) {
            $this->dateTime = $arrayResult['dateTime'];
        }
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
        if ($arrayResult->offsetExists('device')) {
            $this->device = $arrayResult['device'];
        }
    }
}
