<?php

class UmengUminiGetEventOverviewParam
{
    private $sdkStdResult = [];

    /**
     * @return string 时间颗粒度
     */
    public function getTimeUnit()
    {
        return $this->sdkStdResult['timeUnit'];
    }

    /**
     * 设置时间颗粒度
     *
     * @param string $timeUnit
     *                         参数示例：<pre>day</pre>
     * 此参数必填     */
    public function setTimeUnit($timeUnit)
    {
        $this->sdkStdResult['timeUnit'] = $timeUnit;
    }

    /**
     * @return string 开始时间
     */
    public function getFromDate()
    {
        return $this->sdkStdResult['fromDate'];
    }

    /**
     * 设置开始时间
     *
     * @param string $fromDate
     *                         参数示例：<pre>2020-03-10</pre>
     * 此参数必填     */
    public function setFromDate($fromDate)
    {
        $this->sdkStdResult['fromDate'] = $fromDate;
    }

    /**
     * @return string 结束时间
     */
    public function getToDate()
    {
        return $this->sdkStdResult['toDate'];
    }

    /**
     * 设置结束时间
     *
     * @param string $toDate
     *                       参数示例：<pre>2020-03-31</pre>
     * 此参数必填     */
    public function setToDate($toDate)
    {
        $this->sdkStdResult['toDate'] = $toDate;
    }

    /**
     * @return mixed 事件名
     */
    public function getEventName()
    {
        return $this->sdkStdResult['eventName'];
    }

    /**
     * 设置事件名
     *
     * @param string $eventName
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventName($eventName)
    {
        $this->sdkStdResult['eventName'] = $eventName;
    }

    /**
     * @return mixed 数据源id（AppKey）
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

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
