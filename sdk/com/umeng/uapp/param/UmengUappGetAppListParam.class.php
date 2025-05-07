<?php

class UmengUappGetAppListParam
{
    private $sdkStdResult = [];

    /**
     * @return 页号，从1开始
     */
    public function getPage()
    {
        $tempResult = $this->sdkStdResult['page'];

        return $tempResult;
    }

    /**
     * 设置页号，从1开始
     *
     * @param int $page
     *                  参数示例：<pre>1</pre>
     *                  此参数为可选参数
     *                  默认值：<pre></pre>
     */
    public function setPage($page)
    {
        $this->sdkStdResult['page'] = $page;
    }

    /**
     * @return 每页显示数量（最大100）
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
     *                     参数示例：<pre>10</pre>
     *                     此参数为可选参数
     *                     默认值：<pre></pre>
     */
    public function setPerPage($perPage)
    {
        $this->sdkStdResult['perPage'] = $perPage;
    }

    public function getAccessToken()
    {
        $tempResult = $this->sdkStdResult['accessToken'];

        return $tempResult;
    }

    /**
     * 设置
     *
     * @param string $accessToken
     *                            参数示例：<pre></pre>
     *                            此参数为可选参数
     *                            默认值：<pre></pre>
     */
    public function setAccessToken($accessToken)
    {
        $this->sdkStdResult['accessToken'] = $accessToken;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
