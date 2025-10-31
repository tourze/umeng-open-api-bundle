<?php

class UmengApptrackGetActiveDetailDataParam
{
    private $sdkStdResult = [];

    /**
     * @return mixed 应用appkey
     */
    public function getAppKey()
    {
        return $this->sdkStdResult['appKey'];
    }

    /**
     * 设置应用appkey
     *
     * @param string $appKey
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setAppKey($appKey)
    {
        $this->sdkStdResult['appKey'] = $appKey;
    }

    /**
     * @return mixed 计划id
     */
    public function getPlanId()
    {
        return $this->sdkStdResult['planId'];
    }

    /**
     * 设置计划id
     *
     * @param Long $planId
     *                     参数示例：<pre>从用户计划列表接口获取</pre>
     *                     此参数为可选参数
     *                     默认值：<pre></pre>
     */
    public function setPlanId($planId)
    {
        $this->sdkStdResult['planId'] = $planId;
    }

    /**
     * @return string 查询日期
     */
    public function getQueryDate()
    {
        return $this->sdkStdResult['queryDate'];
    }

    /**
     * 设置查询日期
     *
     * @param string $queryDate
     *                          参数示例：<pre>2018-12-19</pre>
     * 此参数必填     */
    public function setQueryDate($queryDate)
    {
        $this->sdkStdResult['queryDate'] = $queryDate;
    }

    /**
     * @return int 当前页数
     */
    public function getPageNum()
    {
        return $this->sdkStdResult['pageNum'];
    }

    /**
     * 设置当前页数
     *
     * @param int $pageNum
     *                     参数示例：<pre>1</pre>
     *                     此参数为可选参数
     *                     默认值：<pre></pre>
     */
    public function setPageNum($pageNum)
    {
        $this->sdkStdResult['pageNum'] = $pageNum;
    }

    /**
     * @return mixed 每页显示的记录数
     */
    public function getPageSize()
    {
        return $this->sdkStdResult['pageSize'];
    }

    /**
     * 设置每页显示的记录数
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

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
