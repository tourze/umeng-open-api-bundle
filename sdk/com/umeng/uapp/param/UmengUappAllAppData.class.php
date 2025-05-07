<?php

class UmengUappAllAppData extends SDKDomain
{
    private $todayActivityUsers;

    private $todayNewUsers;

    private $todayLaunches;

    private $yesterdayActivityUsers;

    private $yesterdayNewUsers;

    private $yesterdayLaunches;

    private $yesterdayUniqNewUsers;

    private $yesterdayUniqActiveUsers;

    private $totalUsers;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 今日活跃用户
     */
    public function getTodayActivityUsers()
    {
        return $this->todayActivityUsers;
    }

    /**
     * 设置今日活跃用户
     *
     * @param int $todayActivityUsers
     *                                参数示例：<pre></pre>
     * 此参数必填     */
    public function setTodayActivityUsers($todayActivityUsers)
    {
        $this->todayActivityUsers = $todayActivityUsers;
    }

    /**
     * @return 今日新增用户
     */
    public function getTodayNewUsers()
    {
        return $this->todayNewUsers;
    }

    /**
     * 设置今日新增用户
     *
     * @param int $todayNewUsers
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setTodayNewUsers($todayNewUsers)
    {
        $this->todayNewUsers = $todayNewUsers;
    }

    /**
     * @return 今日启动次数
     */
    public function getTodayLaunches()
    {
        return $this->todayLaunches;
    }

    /**
     * 设置今日启动次数
     *
     * @param int $todayLaunches
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setTodayLaunches($todayLaunches)
    {
        $this->todayLaunches = $todayLaunches;
    }

    /**
     * @return 昨日活跃用户
     */
    public function getYesterdayActivityUsers()
    {
        return $this->yesterdayActivityUsers;
    }

    /**
     * 设置昨日活跃用户
     *
     * @param int $yesterdayActivityUsers
     *                                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setYesterdayActivityUsers($yesterdayActivityUsers)
    {
        $this->yesterdayActivityUsers = $yesterdayActivityUsers;
    }

    /**
     * @return 昨日新增用户
     */
    public function getYesterdayNewUsers()
    {
        return $this->yesterdayNewUsers;
    }

    /**
     * 设置昨日新增用户
     *
     * @param int $yesterdayNewUsers
     *                               参数示例：<pre></pre>
     * 此参数必填     */
    public function setYesterdayNewUsers($yesterdayNewUsers)
    {
        $this->yesterdayNewUsers = $yesterdayNewUsers;
    }

    /**
     * @return 昨日启动次数
     */
    public function getYesterdayLaunches()
    {
        return $this->yesterdayLaunches;
    }

    /**
     * 设置昨日启动次数
     *
     * @param int $yesterdayLaunches
     *                               参数示例：<pre></pre>
     * 此参数必填     */
    public function setYesterdayLaunches($yesterdayLaunches)
    {
        $this->yesterdayLaunches = $yesterdayLaunches;
    }

    /**
     * @return 昨日独立新增用户数
     */
    public function getYesterdayUniqNewUsers()
    {
        return $this->yesterdayUniqNewUsers;
    }

    /**
     * 设置昨日独立新增用户数
     *
     * @param int $yesterdayUniqNewUsers
     *                                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setYesterdayUniqNewUsers($yesterdayUniqNewUsers)
    {
        $this->yesterdayUniqNewUsers = $yesterdayUniqNewUsers;
    }

    /**
     * @return 昨日独立活跃用户数
     */
    public function getYesterdayUniqActiveUsers()
    {
        return $this->yesterdayUniqActiveUsers;
    }

    /**
     * 设置昨日独立活跃用户数
     *
     * @param int $yesterdayUniqActiveUsers
     *                                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setYesterdayUniqActiveUsers($yesterdayUniqActiveUsers)
    {
        $this->yesterdayUniqActiveUsers = $yesterdayUniqActiveUsers;
    }

    /**
     * @return 总用户数
     */
    public function getTotalUsers()
    {
        return $this->totalUsers;
    }

    /**
     * 设置总用户数
     *
     * @param int $totalUsers
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalUsers($totalUsers)
    {
        $this->totalUsers = $totalUsers;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'todayActivityUsers')) {
            $this->todayActivityUsers = $this->stdResult->{'todayActivityUsers'};
        }
        if (property_exists($this->stdResult, 'todayNewUsers')) {
            $this->todayNewUsers = $this->stdResult->{'todayNewUsers'};
        }
        if (property_exists($this->stdResult, 'todayLaunches')) {
            $this->todayLaunches = $this->stdResult->{'todayLaunches'};
        }
        if (property_exists($this->stdResult, 'yesterdayActivityUsers')) {
            $this->yesterdayActivityUsers = $this->stdResult->{'yesterdayActivityUsers'};
        }
        if (property_exists($this->stdResult, 'yesterdayNewUsers')) {
            $this->yesterdayNewUsers = $this->stdResult->{'yesterdayNewUsers'};
        }
        if (property_exists($this->stdResult, 'yesterdayLaunches')) {
            $this->yesterdayLaunches = $this->stdResult->{'yesterdayLaunches'};
        }
        if (property_exists($this->stdResult, 'yesterdayUniqNewUsers')) {
            $this->yesterdayUniqNewUsers = $this->stdResult->{'yesterdayUniqNewUsers'};
        }
        if (property_exists($this->stdResult, 'yesterdayUniqActiveUsers')) {
            $this->yesterdayUniqActiveUsers = $this->stdResult->{'yesterdayUniqActiveUsers'};
        }
        if (property_exists($this->stdResult, 'totalUsers')) {
            $this->totalUsers = $this->stdResult->{'totalUsers'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('todayActivityUsers')) {
            $this->todayActivityUsers = $arrayResult['todayActivityUsers'];
        }
        if ($arrayResult->offsetExists('todayNewUsers')) {
            $this->todayNewUsers = $arrayResult['todayNewUsers'];
        }
        if ($arrayResult->offsetExists('todayLaunches')) {
            $this->todayLaunches = $arrayResult['todayLaunches'];
        }
        if ($arrayResult->offsetExists('yesterdayActivityUsers')) {
            $this->yesterdayActivityUsers = $arrayResult['yesterdayActivityUsers'];
        }
        if ($arrayResult->offsetExists('yesterdayNewUsers')) {
            $this->yesterdayNewUsers = $arrayResult['yesterdayNewUsers'];
        }
        if ($arrayResult->offsetExists('yesterdayLaunches')) {
            $this->yesterdayLaunches = $arrayResult['yesterdayLaunches'];
        }
        if ($arrayResult->offsetExists('yesterdayUniqNewUsers')) {
            $this->yesterdayUniqNewUsers = $arrayResult['yesterdayUniqNewUsers'];
        }
        if ($arrayResult->offsetExists('yesterdayUniqActiveUsers')) {
            $this->yesterdayUniqActiveUsers = $arrayResult['yesterdayUniqActiveUsers'];
        }
        if ($arrayResult->offsetExists('totalUsers')) {
            $this->totalUsers = $arrayResult['totalUsers'];
        }
    }
}
