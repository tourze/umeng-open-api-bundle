<?php

class UmengUappGetActiveAccountsParam
{
    private $sdkStdResult = [];

    /**
     * @return string 应用ID
     */
    public function getAppkey()
    {
        return $this->sdkStdResult['appkey'];
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
     * @return string 查询起始日期（例如:2018-01-01）
     */
    public function getStartDate()
    {
        return $this->sdkStdResult['startDate'];
    }

    /**
     * 设置查询起始日期（例如:2018-01-01）
     *
     * @param string $startDate
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setStartDate($startDate)
    {
        $this->sdkStdResult['startDate'] = $startDate;
    }

    /**
     * @return string 查询截止日期（例如:2018-01-01）
     */
    public function getEndDate()
    {
        return $this->sdkStdResult['endDate'];
    }

    /**
     * 设置查询截止日期（例如:2018-01-01）
     *
     * @param string $endDate
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setEndDate($endDate)
    {
        $this->sdkStdResult['endDate'] = $endDate;
    }

    /**
     * @return string 查询类型（按日daily,按周weekly,按月monthly 查询）
     */
    public function getPeriodType()
    {
        return $this->sdkStdResult['periodType'];
    }

    /**
     * 设置查询类型（按日daily,按周weekly,按月monthly 查询）
     *
     * @param string $periodType
     *                           参数示例：<pre></pre>
     *                           此参数为可选参数
     *                           默认值：<pre>daily</pre>
     */
    public function setPeriodType($periodType)
    {
        $this->sdkStdResult['periodType'] = $periodType;
    }

    /**
     * @return string 渠道名称（仅限一个例如:App%20Store）
     */
    public function getChannel()
    {
        return $this->sdkStdResult['channel'];
    }

    /**
     * 设置渠道名称（仅限一个例如:App%20Store）
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
