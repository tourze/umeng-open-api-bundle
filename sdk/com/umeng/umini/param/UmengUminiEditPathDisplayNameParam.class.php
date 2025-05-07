<?php

class UmengUminiEditPathDisplayNameParam
{
    private $sdkStdResult = [];

    /**
     * @return 数据源ID（AppKey）
     */
    public function getDataSourceId()
    {
        $tempResult = $this->sdkStdResult['dataSourceId'];

        return $tempResult;
    }

    /**
     * 设置数据源ID（AppKey）
     *
     * @param string $dataSourceId
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return 页面别名
     */
    public function getDisplayName()
    {
        $tempResult = $this->sdkStdResult['displayName'];

        return $tempResult;
    }

    /**
     * 设置页面别名
     *
     * @param string $displayName
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setDisplayName($displayName)
    {
        $this->sdkStdResult['displayName'] = $displayName;
    }

    /**
     * @return 页面URL地址
     */
    public function getPath()
    {
        $tempResult = $this->sdkStdResult['path'];

        return $tempResult;
    }

    /**
     * 设置页面URL地址
     *
     * @param string $path
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setPath($path)
    {
        $this->sdkStdResult['path'] = $path;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
