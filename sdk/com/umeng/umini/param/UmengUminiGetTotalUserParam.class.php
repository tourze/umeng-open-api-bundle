<?php

class UmengUminiGetTotalUserParam
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
     *                             参数示例：<pre>5dfe1b2f3597245664499a9c</pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
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
     *                         参数示例：<pre>2020-03-01</pre>
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
     *                       参数示例：<pre>2020-03-01</pre>
     * 此参数必填     */
    public function setToDate($toDate)
    {
        $this->sdkStdResult['toDate'] = $toDate;
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
     * @return mixed 每页记录条数
     */
    public function getPageSize()
    {
        $tempResult = $this->sdkStdResult['pageSize'];

        return $tempResult;
    }

    /**
     * 设置每页记录条数
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

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
