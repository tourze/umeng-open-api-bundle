<?php

class UmengUappGetChannelDataParam
{
    private $sdkStdResult = [];

    /**
     * @return string 应用ID
     */
    public function getAppkey()
    {
        $tempResult = $this->sdkStdResult['appkey'];

        return $tempResult;
    }

    /**
     * 设置应用ID
     *
     * @param string $appkey
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setAppkey($appkey)
    {
        $this->sdkStdResult['appkey'] = $appkey;
    }

    /**
     * @return string 查询日期
     */
    public function getDate()
    {
        $tempResult = $this->sdkStdResult['date'];

        return $tempResult;
    }

    /**
     * 设置查询日期
     *
     * @param string $date
     *                     参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->sdkStdResult['date'] = $date;
    }

    /**
     * @return int 每页显示数量（最大100）
     */
    public function getPerPage()
    {
        $tempResult = $this->sdkStdResult['perPage'];

        return $tempResult;
    }

    /**
     * 设置每页显示数量（最大100）
     *
     * @param int $perPage
     *                     参数示例：<pre></pre>
     *                     此参数为可选参数
     *                     默认值：<pre>10</pre>
     */
    public function setPerPage($perPage)
    {
        $this->sdkStdResult['perPage'] = $perPage;
    }

    /**
     * @return int 页数
     */
    public function getPage()
    {
        $tempResult = $this->sdkStdResult['page'];

        return $tempResult;
    }

    /**
     * 设置页数
     *
     * @param int $page
     *                  参数示例：<pre></pre>
     *                  此参数为可选参数
     *                  默认值：<pre>1</pre>
     */
    public function setPage($page)
    {
        $this->sdkStdResult['page'] = $page;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
