<?php

class UmengUminiGetSceneOverviewParam
{
    private $sdkStdResult = [];

    /**
     * @return string 时间颗粒度（可选参数：5min,hour,day,7day,30day）
     */
    public function getTimeUnit()
    {
        return $this->sdkStdResult['timeUnit'];
    }

    /**
     * 设置时间颗粒度（可选参数：5min,hour,day,7day,30day）
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
     * @return mixed 场景值( 帮助文档：https://developer.umeng.com/docs/147615/detail/175369 )
     */
    public function getScene()
    {
        return $this->sdkStdResult['scene'];
    }

    /**
     * 设置场景值( 帮助文档：https://developer.umeng.com/docs/147615/detail/175369 )
     *
     * @param string $scene
     *                      参数示例：<pre>alipay_1090</pre>
     * 此参数必填     */
    public function setScene($scene)
    {
        $this->sdkStdResult['scene'] = $scene;
    }

    /**
     * @return mixed 页码
     */
    public function getPageIndex()
    {
        return $this->sdkStdResult['pageIndex'];
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
        return $this->sdkStdResult['pageSize'];
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

    /**
     * @return mixed 指标值
     */
    public function getIndicators()
    {
        return $this->sdkStdResult['indicators'];
    }

    /**
     * 设置指标值
     *
     * @param string $indicators
     *                           参数示例：<pre>多个指标时，以逗号分隔（newUser,activeUser,launch,visitTimes,onceDuration）</pre>
     * 此参数必填     */
    public function setIndicators($indicators)
    {
        $this->sdkStdResult['indicators'] = $indicators;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
