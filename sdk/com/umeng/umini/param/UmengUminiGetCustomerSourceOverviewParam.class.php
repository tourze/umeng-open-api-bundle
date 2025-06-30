<?php

class UmengUminiGetCustomerSourceOverviewParam
{
    private $sdkStdResult = [];

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

    /**
     * @return string 获客来源类型（活动：campaign；场景：scene；渠道：channel ）
     */
    public function getSourceType()
    {
        $tempResult = $this->sdkStdResult['sourceType'];

        return $tempResult;
    }

    /**
     * 设置获客来源类型（活动：campaign；场景：scene；渠道：channel ）
     *
     * @param string $sourceType
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setSourceType($sourceType)
    {
        $this->sdkStdResult['sourceType'] = $sourceType;
    }

    /**
     * @return string 开始时间（yyyy-MM-dd)
     */
    public function getFromDate()
    {
        $tempResult = $this->sdkStdResult['fromDate'];

        return $tempResult;
    }

    /**
     * 设置开始时间（yyyy-MM-dd)
     *
     * @param string $fromDate
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setFromDate($fromDate)
    {
        $this->sdkStdResult['fromDate'] = $fromDate;
    }

    /**
     * @return string 结束时间（yyyy-MM-dd)
     */
    public function getToDate()
    {
        $tempResult = $this->sdkStdResult['toDate'];

        return $tempResult;
    }

    /**
     * 设置结束时间（yyyy-MM-dd)
     *
     * @param string $toDate
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setToDate($toDate)
    {
        $this->sdkStdResult['toDate'] = $toDate;
    }

    /**
     * @return string 时间颗粒度（day,7day,30day）
     */
    public function getTimeUnit()
    {
        $tempResult = $this->sdkStdResult['timeUnit'];

        return $tempResult;
    }

    /**
     * 设置时间颗粒度（day,7day,30day）
     *
     * @param string $timeUnit
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setTimeUnit($timeUnit)
    {
        $this->sdkStdResult['timeUnit'] = $timeUnit;
    }

    /**
     * @return int 排序指标，默认新增用户（新增用户：newUser；打开次数：launch；活跃用户：activeUser；页面访问次数：visitTimes；次均停留时长：onceDuration；创建时间：createDateTime）
     */
    public function getOrderBy()
    {
        $tempResult = $this->sdkStdResult['orderBy'];

        return $tempResult;
    }

    /**
     * 设置排序指标，默认新增用户（新增用户：newUser；打开次数：launch；活跃用户：activeUser；页面访问次数：visitTimes；次均停留时长：onceDuration；创建时间：createDateTime）
     *
     * @param string $orderBy
     *                        参数示例：<pre></pre>
     *                        此参数为可选参数
     *                        默认值：<pre></pre>
     */
    public function setOrderBy($orderBy)
    {
        $this->sdkStdResult['orderBy'] = $orderBy;
    }

    /**
     * @return mixed 排序方向，默认倒序（正序：asc；倒序：desc）
     */
    public function getDirection()
    {
        $tempResult = $this->sdkStdResult['direction'];

        return $tempResult;
    }

    /**
     * 设置排序方向，默认倒序（正序：asc；倒序：desc）
     *
     * @param string $direction
     *                          参数示例：<pre></pre>
     *                          此参数为可选参数
     *                          默认值：<pre></pre>
     */
    public function setDirection($direction)
    {
        $this->sdkStdResult['direction'] = $direction;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
