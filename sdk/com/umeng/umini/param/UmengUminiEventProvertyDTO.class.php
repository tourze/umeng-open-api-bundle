<?php

class UmengUminiEventProvertyDTO extends SDKDomain
{
    private $propertyName;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 属性名
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

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'propertyName')) {
            $this->propertyName = $this->stdResult->{'propertyName'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('propertyName')) {
            $this->propertyName = $arrayResult['propertyName'];
        }
    }
}
