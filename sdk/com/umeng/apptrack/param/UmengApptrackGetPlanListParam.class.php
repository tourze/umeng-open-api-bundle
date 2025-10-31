<?php

class UmengApptrackGetPlanListParam
{
    private $sdkStdResult = [];

    /**
     * @return mixed 应用appKey
     */
    public function getAppKey()
    {
        return $this->sdkStdResult['appKey'];
    }

    /**
     * 设置应用appKey
     *
     * @param string $appKey
     *                       参数示例：<pre></pre>
     *                       此参数为可选参数
     *                       默认值：<pre></pre>
     */
    public function setAppKey($appKey)
    {
        $this->sdkStdResult['appKey'] = $appKey;
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
     *                     默认值：<pre>1</pre>
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
     *                      默认值：<pre>10</pre>
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
