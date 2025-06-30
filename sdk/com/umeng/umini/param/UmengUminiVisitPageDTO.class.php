<?php

class UmengUminiVisitPageDTO extends SDKDomain
{
    private $displayName;

    private $pageDuration;

    private $page;

    private $visitUser;

    private $visitTimes;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 页面备注
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * 设置页面备注
     *
     * @param string $displayName
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed 平均页面访问时长
     */
    public function getPageDuration()
    {
        return $this->pageDuration;
    }

    /**
     * 设置平均页面访问时长
     *
     * @param string $pageDuration
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setPageDuration($pageDuration)
    {
        $this->pageDuration = $pageDuration;
    }

    /**
     * @return mixed 页面URL
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * 设置页面URL
     *
     * @param string $page
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed 页面访问用户数
     */
    public function getVisitUser()
    {
        return $this->visitUser;
    }

    /**
     * 设置页面访问用户数
     *
     * @param Long $visitUser
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setVisitUser($visitUser)
    {
        $this->visitUser = $visitUser;
    }

    /**
     * @return int 页面访问次数
     */
    public function getVisitTimes()
    {
        return $this->visitTimes;
    }

    /**
     * 设置页面访问次数
     *
     * @param Long $visitTimes
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setVisitTimes($visitTimes)
    {
        $this->visitTimes = $visitTimes;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'displayName')) {
            $this->displayName = $this->stdResult->{'displayName'};
        }
        if (property_exists($this->stdResult, 'pageDuration')) {
            $this->pageDuration = $this->stdResult->{'pageDuration'};
        }
        if (property_exists($this->stdResult, 'page')) {
            $this->page = $this->stdResult->{'page'};
        }
        if (property_exists($this->stdResult, 'visitUser')) {
            $this->visitUser = $this->stdResult->{'visitUser'};
        }
        if (property_exists($this->stdResult, 'visitTimes')) {
            $this->visitTimes = $this->stdResult->{'visitTimes'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('displayName')) {
            $this->displayName = $arrayResult['displayName'];
        }
        if ($arrayResult->offsetExists('pageDuration')) {
            $this->pageDuration = $arrayResult['pageDuration'];
        }
        if ($arrayResult->offsetExists('page')) {
            $this->page = $arrayResult['page'];
        }
        if ($arrayResult->offsetExists('visitUser')) {
            $this->visitUser = $arrayResult['visitUser'];
        }
        if ($arrayResult->offsetExists('visitTimes')) {
            $this->visitTimes = $arrayResult['visitTimes'];
        }
    }
}
