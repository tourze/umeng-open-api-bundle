<?php

class UmengUminiGetMultiOverviewParam
{
    private $sdkStdResult = [];

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
     *                             参数示例：<pre>1dfe1b2f3597245664499a91</pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return string 分组名称
     */
    public function getIsv()
    {
        return $this->sdkStdResult['isv'];
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
     *                         参数示例：<pre>2020-10-10</pre>
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
     *                       参数示例：<pre>2020-10-31</pre>
     * 此参数必填     */
    public function setToDate($toDate)
    {
        $this->sdkStdResult['toDate'] = $toDate;
    }

    /**
     * @return string 时间颗粒度，枚举范围day,7day,30day,week,month（逗号分隔）
     */
    public function getTimeUnit()
    {
        return $this->sdkStdResult['timeUnit'];
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
     * @return mixed 分组层级(仅支持最低层级)
     */
    public function getGroupName()
    {
        return $this->sdkStdResult['groupName'];
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
