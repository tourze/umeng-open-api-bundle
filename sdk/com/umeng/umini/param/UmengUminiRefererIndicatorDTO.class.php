<?php

class UmengUminiRefererIndicatorDTO extends SDKDomain
{
    private $dateTime;

    private $newUser;

    private $activeUser;

    private $launch;

    private $visitTimes;

    private $onceDuration;

    private $stdResult;

    private $arrayResult;

    /**
     * @return string 时间
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * 设置时间
     *
     * @param string $dateTime
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return mixed 新增用户
     */
    public function getNewUser()
    {
        return $this->newUser;
    }

    /**
     * 设置新增用户
     *
     * @param Long $newUser
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setNewUser($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * @return mixed 活跃用户
     */
    public function getActiveUser()
    {
        return $this->activeUser;
    }

    /**
     * 设置活跃用户
     *
     * @param Long $activeUser
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setActiveUser($activeUser)
    {
        $this->activeUser = $activeUser;
    }

    /**
     * @return int 打开次数
     */
    public function getLaunch()
    {
        return $this->launch;
    }

    /**
     * 设置打开次数
     *
     * @param Long $launch
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setLaunch($launch)
    {
        $this->launch = $launch;
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

    /**
     * @return mixed 次均停留时长
     */
    public function getOnceDuration()
    {
        return $this->onceDuration;
    }

    /**
     * 设置次均停留时长
     *
     * @param string $onceDuration
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setOnceDuration($onceDuration)
    {
        $this->onceDuration = $onceDuration;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'dateTime')) {
            $this->dateTime = $this->stdResult->{'dateTime'};
        }
        if (property_exists($this->stdResult, 'newUser')) {
            $this->newUser = $this->stdResult->{'newUser'};
        }
        if (property_exists($this->stdResult, 'activeUser')) {
            $this->activeUser = $this->stdResult->{'activeUser'};
        }
        if (property_exists($this->stdResult, 'launch')) {
            $this->launch = $this->stdResult->{'launch'};
        }
        if (property_exists($this->stdResult, 'visitTimes')) {
            $this->visitTimes = $this->stdResult->{'visitTimes'};
        }
        if (property_exists($this->stdResult, 'onceDuration')) {
            $this->onceDuration = $this->stdResult->{'onceDuration'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('dateTime')) {
            $this->dateTime = $arrayResult['dateTime'];
        }
        if ($arrayResult->offsetExists('newUser')) {
            $this->newUser = $arrayResult['newUser'];
        }
        if ($arrayResult->offsetExists('activeUser')) {
            $this->activeUser = $arrayResult['activeUser'];
        }
        if ($arrayResult->offsetExists('launch')) {
            $this->launch = $arrayResult['launch'];
        }
        if ($arrayResult->offsetExists('visitTimes')) {
            $this->visitTimes = $arrayResult['visitTimes'];
        }
        if ($arrayResult->offsetExists('onceDuration')) {
            $this->onceDuration = $arrayResult['onceDuration'];
        }
    }
}
