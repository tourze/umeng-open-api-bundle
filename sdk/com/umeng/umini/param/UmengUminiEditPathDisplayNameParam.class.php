<?php

class UmengUminiEditPathDisplayNameParam
{
    private $sdkStdResult = [];

    /**
     * @return string 数据源ID（AppKey）
     */
    public function getDataSourceId()
    {
        return $this->sdkStdResult['dataSourceId'];
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
     * @return mixed 页面别名
     */
    public function getDisplayName()
    {
        return $this->sdkStdResult['displayName'];
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
     * @return mixed 页面URL地址
     */
    public function getPath()
    {
        return $this->sdkStdResult['path'];
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
