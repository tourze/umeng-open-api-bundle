<?php

class UmengUappGetDailyDataParam
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

    /**
     * @return string 版本名称（选填，仅一次一个）
     */
    public function getVersion()
    {
        $tempResult = $this->sdkStdResult['version'];

        return $tempResult;
    }

    /**
     * 设置版本名称（选填，仅一次一个）
     *
     * @param string $version
     *                        参数示例：<pre></pre>
     *                        此参数为可选参数
     *                        默认值：<pre></pre>
     */
    public function setVersion($version)
    {
        $this->sdkStdResult['version'] = $version;
    }

    /**
     * @return string 渠道名称（选填，仅一次一个）
     */
    public function getChannel()
    {
        $tempResult = $this->sdkStdResult['channel'];

        return $tempResult;
    }

    /**
     * 设置渠道名称（选填，仅一次一个）
     *
     * @param string $channel
     *                        参数示例：<pre></pre>
     *                        此参数为可选参数
     *                        默认值：<pre></pre>
     */
    public function setChannel($channel)
    {
        $this->sdkStdResult['channel'] = $channel;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
