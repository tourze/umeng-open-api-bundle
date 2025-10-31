<?php

class UmengUappParamInfo extends SDKDomain
{
    private $paramId;

    private $name;

    private $displayName;

    private $stdResult;

    /**
     * @return string 参数ID
     */
    public function getParamId()
    {
        return $this->paramId;
    }

    /**
     * 设置参数ID
     *
     * @param string $paramId
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setParamId($paramId)
    {
        $this->paramId = $paramId;
    }

    /**
     * @return string 参数名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置参数名称
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string 参数显示名称
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * 设置参数显示名称
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
        if (property_exists($this->stdResult, 'paramId')) {
            $this->paramId = $this->stdResult->paramId;
        }
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->name;
        }
        if (property_exists($this->stdResult, 'displayName')) {
            $this->displayName = $this->stdResult->displayName;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('paramId')) {
            $this->paramId = $arrayResult['paramId'];
        }
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('displayName')) {
            $this->displayName = $arrayResult['displayName'];
        }
    }
}
