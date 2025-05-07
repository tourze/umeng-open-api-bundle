<?php

class UmengUminiGetEventListParam
{
    private $sdkStdResult = [];

    /**
     * @return 数据源Id（AppKey）
     */
    public function getDataSourceId()
    {
        $tempResult = $this->sdkStdResult['dataSourceId'];

        return $tempResult;
    }

    /**
     * 设置数据源Id（AppKey）
     *
     * @param string $dataSourceId
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
