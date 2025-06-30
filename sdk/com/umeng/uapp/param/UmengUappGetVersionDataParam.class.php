<?php

class UmengUappGetVersionDataParam
{
    private $sdkStdResult = [];

    /**
     * @return string 应用ID
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

    /**
     * @return string 查询日期
     */
    public function getDate()
    {
        $tempResult = $this->sdkStdResult['date'];

        return $tempResult;
    }

    /**
     * 设置查询日期
     *
     * @param string $date
     *                     参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->sdkStdResult['date'] = $date;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
