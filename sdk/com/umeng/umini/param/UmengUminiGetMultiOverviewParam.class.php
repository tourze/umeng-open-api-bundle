<?php

class UmengUminiGetMultiOverviewParam
{
    private $sdkStdResult = [];

    /**
     * @return 数据源id（AppKey）
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
     *                             参数示例：<pre>1dfe1b2f3597245664499a91</pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return 分组名称
     */
    public function getIsv()
    {
        $tempResult = $this->sdkStdResult['isv'];

        return $tempResult;
    }

    /**
     * 设置分组名称
     *
     * @param string $isv
     *                    参数示例：<pre>isv8</pre>
     * 此参数必填     */
    public function setIsv($isv)
    {
        $this->sdkStdResult['isv'] = $isv;
    }

    /**
     * @return 开始时间
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
     *                         参数示例：<pre>2020-10-10</pre>
     * 此参数必填     */
    public function setFromDate($fromDate)
    {
        $this->sdkStdResult['fromDate'] = $fromDate;
    }

    /**
     * @return 结束时间
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
     *                       参数示例：<pre>2020-10-31</pre>
     * 此参数必填     */
    public function setToDate($toDate)
    {
        $this->sdkStdResult['toDate'] = $toDate;
    }

    /**
     * @return 时间颗粒度，枚举范围day,7day,30day,week,month（逗号分隔）
     */
    public function getTimeUnit()
    {
        $tempResult = $this->sdkStdResult['timeUnit'];

        return $tempResult;
    }

    /**
     * 设置时间颗粒度，枚举范围day,7day,30day,week,month（逗号分隔）
     *
     * @param string $timeUnit
     *                         参数示例：<pre>day</pre>
     * 此参数必填     */
    public function setTimeUnit($timeUnit)
    {
        $this->sdkStdResult['timeUnit'] = $timeUnit;
    }

    /**
     * @return 分组层级(仅支持最低层级)
     */
    public function getGroupName()
    {
        $tempResult = $this->sdkStdResult['groupName'];

        return $tempResult;
    }

    /**
     * 设置分组层级(仅支持最低层级)
     *
     * @param string $groupName
     *                          参数示例：<pre>门店</pre>
     * 此参数必填     */
    public function setGroupName($groupName)
    {
        $this->sdkStdResult['groupName'] = $groupName;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
