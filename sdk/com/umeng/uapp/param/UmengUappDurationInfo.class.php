<?php

class UmengUappDurationInfo extends SDKDomain
{
    private $name;

    private $value;

    private $percent;

    private $stdResult;

    private $arrayResult;

    /**
     * @return string 时间区间单位秒
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置时间区间单位秒
     *
     * @param string $name
     *                     参数示例：<pre>1-3,4-10,11-30</pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int 启动次数/用户数
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * 设置启动次数/用户数
     *
     * @param int $value
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed 此区间的时长占
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * 设置此区间的时长占
     *
     * @param float $percent
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setPercent($percent)
    {
        $this->percent = $percent;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->{'name'};
        }
        if (property_exists($this->stdResult, 'value')) {
            $this->value = $this->stdResult->{'value'};
        }
        if (property_exists($this->stdResult, 'percent')) {
            $this->percent = $this->stdResult->{'percent'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('value')) {
            $this->value = $arrayResult['value'];
        }
        if ($arrayResult->offsetExists('percent')) {
            $this->percent = $arrayResult['percent'];
        }
    }
}
