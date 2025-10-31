<?php

class UmengUappDailyDataInfo extends SDKDomain
{
    private $date;

    private $activityUsers;

    private $totalUsers;

    private $launches;

    private $newUsers;

    private $payUsers;

    private $stdResult;

    /**
     * @return string 统计日期
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * 设置统计日期
     *
     * @param string $date
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed 活跃用户数
     */
    public function getActivityUsers()
    {
        return $this->activityUsers;
    }

    /**
     * 设置活跃用户数
     *
     * @param int $activityUsers
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setActivityUsers($activityUsers)
    {
        $this->activityUsers = $activityUsers;
    }

    /**
     * @return mixed 总用户数
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

    /**
     * @return mixed 启动数
     */
    public function getLaunches()
    {
        return $this->launches;
    }

    /**
     * 设置启动数
     *
     * @param int $launches
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setLaunches($launches)
    {
        $this->launches = $launches;
    }

    /**
     * @return mixed 新增用户数
     */
    public function getNewUsers()
    {
        return $this->newUsers;
    }

    /**
     * 设置新增用户数
     *
     * @param int $newUsers
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setNewUsers($newUsers)
    {
        $this->newUsers = $newUsers;
    }

    /**
     * @return mixed 游戏付费用户数（仅游戏sdk）
     */
    public function getPayUsers()
    {
        return $this->payUsers;
    }

    /**
     * 设置游戏付费用户数（仅游戏sdk）
     *
     * @param int $payUsers
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setPayUsers($payUsers)
    {
        $this->payUsers = $payUsers;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'date')) {
            $this->date = $this->stdResult->date;
        }
        if (property_exists($this->stdResult, 'activityUsers')) {
            $this->activityUsers = $this->stdResult->activityUsers;
        }
        if (property_exists($this->stdResult, 'totalUsers')) {
            $this->totalUsers = $this->stdResult->totalUsers;
        }
        if (property_exists($this->stdResult, 'launches')) {
            $this->launches = $this->stdResult->launches;
        }
        if (property_exists($this->stdResult, 'newUsers')) {
            $this->newUsers = $this->stdResult->newUsers;
        }
        if (property_exists($this->stdResult, 'payUsers')) {
            $this->payUsers = $this->stdResult->payUsers;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('date')) {
            $this->date = $arrayResult['date'];
        }
        if ($arrayResult->offsetExists('activityUsers')) {
            $this->activityUsers = $arrayResult['activityUsers'];
        }
        if ($arrayResult->offsetExists('totalUsers')) {
            $this->totalUsers = $arrayResult['totalUsers'];
        }
        if ($arrayResult->offsetExists('launches')) {
            $this->launches = $arrayResult['launches'];
        }
        if ($arrayResult->offsetExists('newUsers')) {
            $this->newUsers = $arrayResult['newUsers'];
        }
        if ($arrayResult->offsetExists('payUsers')) {
            $this->payUsers = $arrayResult['payUsers'];
        }
    }
}
