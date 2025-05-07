<?php

class UmengUappEventInfo extends SDKDomain
{
    private $name;

    private $count;

    private $id;

    private $displayName;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 事件名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置事件名称
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return 统计次数
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * 设置统计次数
     *
     * @param int $count
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 设置ID
     *
     * @param string $id
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return 显示名称
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * 设置显示名称
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
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->{'name'};
        }
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->{'count'};
        }
        if (property_exists($this->stdResult, 'id')) {
            $this->id = $this->stdResult->{'id'};
        }
        if (property_exists($this->stdResult, 'displayName')) {
            $this->displayName = $this->stdResult->{'displayName'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
        if ($arrayResult->offsetExists('id')) {
            $this->id = $arrayResult['id'];
        }
        if ($arrayResult->offsetExists('displayName')) {
            $this->displayName = $arrayResult['displayName'];
        }
    }
}
