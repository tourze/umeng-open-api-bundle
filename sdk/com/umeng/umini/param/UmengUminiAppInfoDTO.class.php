<?php

class UmengUminiAppInfoDTO extends SDKDomain
{
    private $secondLevel;

    private $dataSourceId;

    private $appName;

    private $gmtCreate;

    private $firstLevel;

    private $userName;

    private $platform;

    private $stdResult;

    /**
     * @return mixed 二级分类
     */
    public function getSecondLevel()
    {
        return $this->secondLevel;
    }

    /**
     * 设置二级分类
     *
     * @param string $secondLevel
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setSecondLevel($secondLevel)
    {
        $this->secondLevel = $secondLevel;
    }

    /**
     * @return UmengUminiAppInfo 数据源id
     */
    public function getDataSourceId()
    {
        return $this->dataSourceId;
    }

    /**
     * 设置数据源id
     *
     * @param string $dataSourceId
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->dataSourceId = $dataSourceId;
    }

    /**
     * @return string 数据源名称
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * 设置数据源名称
     *
     * @param string $appName
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }

    /**
     * @return string 创建时间
     */
    public function getGmtCreate()
    {
        return $this->gmtCreate;
    }

    /**
     * 设置创建时间
     *
     * @param string $gmtCreate
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setGmtCreate($gmtCreate)
    {
        $this->gmtCreate = $gmtCreate;
    }

    /**
     * @return mixed 一级分类
     */
    public function getFirstLevel()
    {
        return $this->firstLevel;
    }

    /**
     * 设置一级分类
     *
     * @param string $firstLevel
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setFirstLevel($firstLevel)
    {
        $this->firstLevel = $firstLevel;
    }

    /**
     * @return mixed 用户名
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * 设置用户名
     *
     * @param string $userName
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string 小程序平台
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * 设置小程序平台
     *
     * @param string $platform
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'secondLevel')) {
            $this->secondLevel = $this->stdResult->secondLevel;
        }
        if (property_exists($this->stdResult, 'dataSourceId')) {
            $this->dataSourceId = $this->stdResult->dataSourceId;
        }
        if (property_exists($this->stdResult, 'appName')) {
            $this->appName = $this->stdResult->appName;
        }
        if (property_exists($this->stdResult, 'gmtCreate')) {
            $this->gmtCreate = $this->stdResult->gmtCreate;
        }
        if (property_exists($this->stdResult, 'firstLevel')) {
            $this->firstLevel = $this->stdResult->firstLevel;
        }
        if (property_exists($this->stdResult, 'userName')) {
            $this->userName = $this->stdResult->userName;
        }
        if (property_exists($this->stdResult, 'platform')) {
            $this->platform = $this->stdResult->platform;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('secondLevel')) {
            $this->secondLevel = $arrayResult['secondLevel'];
        }
        if ($arrayResult->offsetExists('dataSourceId')) {
            $this->dataSourceId = $arrayResult['dataSourceId'];
        }
        if ($arrayResult->offsetExists('appName')) {
            $this->appName = $arrayResult['appName'];
        }
        if ($arrayResult->offsetExists('gmtCreate')) {
            $this->gmtCreate = $arrayResult['gmtCreate'];
        }
        if ($arrayResult->offsetExists('firstLevel')) {
            $this->firstLevel = $arrayResult['firstLevel'];
        }
        if ($arrayResult->offsetExists('userName')) {
            $this->userName = $arrayResult['userName'];
        }
        if ($arrayResult->offsetExists('platform')) {
            $this->platform = $arrayResult['platform'];
        }
    }
}
