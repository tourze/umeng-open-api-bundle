<?php

class UmengUappParamValueInfo extends SDKDomain
{
    private $name;

    private $count;

    private $percent;

    private $stdResult;

    /**
     * @return int 参数值名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置参数值名称
     *
     * @param string $name
     *                     参数示例：<pre>%e7%a4%ba%e4%be%8b（示例）</pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed 统计的消息数
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * 设置统计的消息数
     *
     * @param int $count
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int 当前事件下此参数值消息数的占比
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * 设置当前事件下此参数值消息数的占比
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
            $this->name = $this->stdResult->name;
        }
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->count;
        }
        if (property_exists($this->stdResult, 'percent')) {
            $this->percent = $this->stdResult->percent;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
        if ($arrayResult->offsetExists('percent')) {
            $this->percent = $arrayResult['percent'];
        }
    }
}
