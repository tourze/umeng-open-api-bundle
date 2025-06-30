<?php

class UmengUappGetLaunchesParam
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
     * @return string 查询起始日期
     */
    public function getStartDate()
    {
        $tempResult = $this->sdkStdResult['startDate'];

        return $tempResult;
    }

    /**
     * 设置查询起始日期
     *
     * @param string $startDate
     *                          参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setStartDate($startDate)
    {
        $this->sdkStdResult['startDate'] = $startDate;
    }

    /**
     * @return string 查询截止日期
     */
    public function getEndDate()
    {
        $tempResult = $this->sdkStdResult['endDate'];

        return $tempResult;
    }

    /**
     * 设置查询截止日期
     *
     * @param string $endDate
     *                        参数示例：<pre>2018-01-01</pre>
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
        $tempResult = $this->sdkStdResult['periodType'];

        return $tempResult;
    }

    /**
     * 设置查询类型（按日daily,按周weekly,按月monthly 查询）
     *
     * @param string $periodType
     *                           参数示例：<pre>daily</pre>
     *                           此参数为可选参数
     *                           默认值：<pre>daily</pre>
     */
    public function setPeriodType($periodType)
    {
        $this->sdkStdResult['periodType'] = $periodType;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
