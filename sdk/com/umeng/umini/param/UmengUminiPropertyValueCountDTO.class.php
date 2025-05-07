<?php

class UmengUminiPropertyValueCountDTO extends SDKDomain
{
    private $count;

    private $propertyValue;

    private $countRatio;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 触发次数
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
     * @return 属性值
     */
    public function getPropertyValue()
    {
        return $this->propertyValue;
    }

    /**
     * 设置属性值
     *
     * @param string $propertyValue
     *                              参数示例：<pre></pre>
     * 此参数必填     */
    public function setPropertyValue($propertyValue)
    {
        $this->propertyValue = $propertyValue;
    }

    /**
     * @return 触发次数占比
     */
    public function getCountRatio()
    {
        return $this->countRatio;
    }

    /**
     * 设置触发次数占比
     *
     * @param float $countRatio
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setCountRatio($countRatio)
    {
        $this->countRatio = $countRatio;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->{'count'};
        }
        if (property_exists($this->stdResult, 'propertyValue')) {
            $this->propertyValue = $this->stdResult->{'propertyValue'};
        }
        if (property_exists($this->stdResult, 'countRatio')) {
            $this->countRatio = $this->stdResult->{'countRatio'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
        if ($arrayResult->offsetExists('propertyValue')) {
            $this->propertyValue = $arrayResult['propertyValue'];
        }
        if ($arrayResult->offsetExists('countRatio')) {
            $this->countRatio = $arrayResult['countRatio'];
        }
    }
}
