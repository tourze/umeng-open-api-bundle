<?php

class UmengUminiGetRetentionByDataSourceIdParam
{
    private $sdkStdResult = [];

    /**
     * @return 数据源ID(appkey)
     */
    public function getDataSourceId()
    {
        $tempResult = $this->sdkStdResult['dataSourceId'];

        return $tempResult;
    }

    /**
     * 设置数据源ID(appkey)
     *
     * @param string $dataSourceId
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return 开始时间 yyyy-MM-dd
     */
    public function getFromDate()
    {
        $tempResult = $this->sdkStdResult['fromDate'];

        return $tempResult;
    }

    /**
     * 设置开始时间 yyyy-MM-dd
     *
     * @param string $fromDate
     *                         参数示例：<pre>2021-01-19</pre>
     * 此参数必填     */
    public function setFromDate($fromDate)
    {
        $this->sdkStdResult['fromDate'] = $fromDate;
    }

    /**
     * @return 结束时间 yyyy-MM-dd
     */
    public function getToDate()
    {
        $tempResult = $this->sdkStdResult['toDate'];

        return $tempResult;
    }

    /**
     * 设置结束时间 yyyy-MM-dd
     *
     * @param string $toDate
     *                       参数示例：<pre>2021-01-01</pre>
     * 此参数必填     */
    public function setToDate($toDate)
    {
        $this->sdkStdResult['toDate'] = $toDate;
    }

    /**
     * @return 时间颗粒度 day,week
     */
    public function getTimeUnit()
    {
        $tempResult = $this->sdkStdResult['timeUnit'];

        return $tempResult;
    }

    /**
     * 设置时间颗粒度 day,week
     *
     * @param string $timeUnit
     *                         参数示例：<pre>day</pre>
     * 此参数必填     */
    public function setTimeUnit($timeUnit)
    {
        $this->sdkStdResult['timeUnit'] = $timeUnit;
    }

    /**
     * @return 页码
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
     *                       默认值：<pre></pre>
     */
    public function setPageIndex($pageIndex)
    {
        $this->sdkStdResult['pageIndex'] = $pageIndex;
    }

    /**
     * @return 每页条数
     */
    public function getPageSize()
    {
        $tempResult = $this->sdkStdResult['pageSize'];

        return $tempResult;
    }

    /**
     * 设置每页条数
     *
     * @param int $pageSize
     *                      参数示例：<pre>10</pre>
     *                      此参数为可选参数
     *                      默认值：<pre></pre>
     */
    public function setPageSize($pageSize)
    {
        $this->sdkStdResult['pageSize'] = $pageSize;
    }

    /**
     * @return 指标：新增用户（newuser） 活跃用户 activeUser
     */
    public function getIndicator()
    {
        $tempResult = $this->sdkStdResult['indicator'];

        return $tempResult;
    }

    /**
     * 设置指标：新增用户（newuser） 活跃用户 activeUser
     *
     * @param string $indicator
     *                          参数示例：<pre>activeUser</pre>
     *                          此参数为可选参数
     *                          默认值：<pre></pre>
     */
    public function setIndicator($indicator)
    {
        $this->sdkStdResult['indicator'] = $indicator;
    }

    /**
     * @return 数据类型：留存率（rate) 留存数（num)
     */
    public function getValueType()
    {
        $tempResult = $this->sdkStdResult['valueType'];

        return $tempResult;
    }

    /**
     * 设置数据类型：留存率（rate) 留存数（num)
     *
     * @param string $valueType
     *                          参数示例：<pre>rate</pre>
     * 此参数必填     */
    public function setValueType($valueType)
    {
        $this->sdkStdResult['valueType'] = $valueType;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
