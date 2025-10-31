<?php

class UmengUminiGetSceneInfoListParam
{
    private $sdkStdResult = [];

    /**
     * @return UmengUminiGetSceneInfo 数据源id（AppKey）
     */
    public function getDataSourceId()
    {
        return $this->sdkStdResult['dataSourceId'];
    }

    /**
     * 设置数据源id（AppKey）
     *
     * @param string $dataSourceId
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return string 场景值类型,活动campaign 渠道channel
     */
    public function getSourceType()
    {
        return $this->sdkStdResult['sourceType'];
    }

    /**
     * 设置场景值类型,活动campaign 渠道channel
     *
     * @param string $sourceType
     *                           参数示例：<pre>campaign</pre>
     * 此参数必填     */
    public function setSourceType($sourceType)
    {
        $this->sdkStdResult['sourceType'] = $sourceType;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
