<?php

class UmengUminiLandingPageDTO extends SDKDomain
{
    private $page;

    private $displayName;

    private $visitTimes;

    private $visitUser;

    private $jumpRatio;

    private $stdResult;

    private $arrayResult;

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
     * @return int 入口页次数
     */
    public function getVisitTimes()
    {
        return $this->visitTimes;
    }

    /**
     * 设置入口页次数
     *
     * @param Long $visitTimes
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setVisitTimes($visitTimes)
    {
        $this->visitTimes = $visitTimes;
    }

    /**
     * @return mixed 入口页人数
     */
    public function getVisitUser()
    {
        return $this->visitUser;
    }

    /**
     * 设置入口页人数
     *
     * @param Long $visitUser
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setVisitUser($visitUser)
    {
        $this->visitUser = $visitUser;
    }

    /**
     * @return mixed 跳出率
     */
    public function getJumpRatio()
    {
        return $this->jumpRatio;
    }

    /**
     * 设置跳出率
     *
     * @param string $jumpRatio
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setJumpRatio($jumpRatio)
    {
        $this->jumpRatio = $jumpRatio;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'page')) {
            $this->page = $this->stdResult->{'page'};
        }
        if (property_exists($this->stdResult, 'displayName')) {
            $this->displayName = $this->stdResult->{'displayName'};
        }
        if (property_exists($this->stdResult, 'visitTimes')) {
            $this->visitTimes = $this->stdResult->{'visitTimes'};
        }
        if (property_exists($this->stdResult, 'visitUser')) {
            $this->visitUser = $this->stdResult->{'visitUser'};
        }
        if (property_exists($this->stdResult, 'jumpRatio')) {
            $this->jumpRatio = $this->stdResult->{'jumpRatio'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('page')) {
            $this->page = $arrayResult['page'];
        }
        if ($arrayResult->offsetExists('displayName')) {
            $this->displayName = $arrayResult['displayName'];
        }
        if ($arrayResult->offsetExists('visitTimes')) {
            $this->visitTimes = $arrayResult['visitTimes'];
        }
        if ($arrayResult->offsetExists('visitUser')) {
            $this->visitUser = $arrayResult['visitUser'];
        }
        if ($arrayResult->offsetExists('jumpRatio')) {
            $this->jumpRatio = $arrayResult['jumpRatio'];
        }
    }
}
