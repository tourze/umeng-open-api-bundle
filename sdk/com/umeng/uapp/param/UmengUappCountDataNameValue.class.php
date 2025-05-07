<?php

class UmengUappCountDataNameValue extends SDKDomain
{
    private $name;

    private $value;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 版本或渠道名
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置版本或渠道名
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return 统计数
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * 设置统计数
     *
     * @param int $value
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setValue($value)
    {
        $this->value = $value;
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
    }
}
