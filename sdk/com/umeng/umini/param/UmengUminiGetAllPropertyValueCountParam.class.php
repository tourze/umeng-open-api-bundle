<?php

class UmengUminiGetAllPropertyValueCountParam
{
    private $sdkStdResult = [];

    /**
     * @return string 时间颗粒度(可选day)
     */
    public function getTimeUnit()
    {
        $tempResult = $this->sdkStdResult['timeUnit'];

        return $tempResult;
    }

    /**
     * 设置时间颗粒度(可选day)
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
        $tempResult = $this->sdkStdResult['fromDate'];

        return $tempResult;
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
        $tempResult = $this->sdkStdResult['toDate'];

        return $tempResult;
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
     * @return mixed 属性名
     */
    public function getPropertyName()
    {
        $tempResult = $this->sdkStdResult['propertyName'];

        return $tempResult;
    }

    /**
     * 设置属性名
     *
     * @param string $propertyName
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setPropertyName($propertyName)
    {
        $this->sdkStdResult['propertyName'] = $propertyName;
    }

    /**
     * @return mixed 页码
     */
    public function getPageIndex()
    {
        $tempResult = $this->sdkStdResult['pageIndex'];

        return $tempResult;
    }

    /**
     * 设置页码
     *
     * @param int $pageIndex
     *                       参数示例：<pre>1</pre>
     *                       此参数为可选参数
     *                       默认值：<pre>1</pre>
     */
    public function setPageIndex($pageIndex)
    {
        $this->sdkStdResult['pageIndex'] = $pageIndex;
    }

    /**
     * @return mixed 每页记录数
     */
    public function getPageSize()
    {
        $tempResult = $this->sdkStdResult['pageSize'];

        return $tempResult;
    }

    /**
     * 设置每页记录数
     *
     * @param int $pageSize
     *                      参数示例：<pre>30</pre>
     *                      此参数为可选参数
     *                      默认值：<pre>30</pre>
     */
    public function setPageSize($pageSize)
    {
        $this->sdkStdResult['pageSize'] = $pageSize;
    }

    /**
     * @return mixed 事件名
     */
    public function getEventName()
    {
        $tempResult = $this->sdkStdResult['eventName'];

        return $tempResult;
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
        $tempResult = $this->sdkStdResult['dataSourceId'];

        return $tempResult;
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
