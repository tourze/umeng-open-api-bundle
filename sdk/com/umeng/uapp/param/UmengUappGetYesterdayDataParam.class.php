<?php

class UmengUappGetYesterdayDataParam
{
    private $sdkStdResult = [];

    /**
     * @return 应用ID
     */
    public function getAppkey()
    {
        $tempResult = $this->sdkStdResult['appkey'];

        return $tempResult;
    }

    /**
     * 设置应用ID
     *
     * @param string $appkey
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setAppkey($appkey)
    {
        $this->sdkStdResult['appkey'] = $appkey;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
