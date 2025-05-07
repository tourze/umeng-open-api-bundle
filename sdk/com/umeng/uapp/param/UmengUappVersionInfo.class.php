<?php

class UmengUappVersionInfo extends SDKDomain
{
    private $date;

    private $totalUserRate;

    private $activeUser;

    private $newUser;

    private $totalUser;

    private $version;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 统计日期
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
     * @return 当前版本总用户数在总用户数中的比例
     */
    public function getTotalUserRate()
    {
        return $this->totalUserRate;
    }

    /**
     * 设置当前版本总用户数在总用户数中的比例
     *
     * @param float $totalUserRate
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalUserRate($totalUserRate)
    {
        $this->totalUserRate = $totalUserRate;
    }

    /**
     * @return 活跃用户
     */
    public function getActiveUser()
    {
        return $this->activeUser;
    }

    /**
     * 设置活跃用户
     *
     * @param int $activeUser
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setActiveUser($activeUser)
    {
        $this->activeUser = $activeUser;
    }

    /**
     * @return 新增用户
     */
    public function getNewUser()
    {
        return $this->newUser;
    }

    /**
     * 设置新增用户
     *
     * @param int $newUser
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setNewUser($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * @return 当前版本总用户数
     */
    public function getTotalUser()
    {
        return $this->totalUser;
    }

    /**
     * 设置当前版本总用户数
     *
     * @param int $totalUser
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalUser($totalUser)
    {
        $this->totalUser = $totalUser;
    }

    /**
     * @return 版本号
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 设置版本号
     *
     * @param string $version
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'date')) {
            $this->date = $this->stdResult->{'date'};
        }
        if (property_exists($this->stdResult, 'totalUserRate')) {
            $this->totalUserRate = $this->stdResult->{'totalUserRate'};
        }
        if (property_exists($this->stdResult, 'activeUser')) {
            $this->activeUser = $this->stdResult->{'activeUser'};
        }
        if (property_exists($this->stdResult, 'newUser')) {
            $this->newUser = $this->stdResult->{'newUser'};
        }
        if (property_exists($this->stdResult, 'totalUser')) {
            $this->totalUser = $this->stdResult->{'totalUser'};
        }
        if (property_exists($this->stdResult, 'version')) {
            $this->version = $this->stdResult->{'version'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('date')) {
            $this->date = $arrayResult['date'];
        }
        if ($arrayResult->offsetExists('totalUserRate')) {
            $this->totalUserRate = $arrayResult['totalUserRate'];
        }
        if ($arrayResult->offsetExists('activeUser')) {
            $this->activeUser = $arrayResult['activeUser'];
        }
        if ($arrayResult->offsetExists('newUser')) {
            $this->newUser = $arrayResult['newUser'];
        }
        if ($arrayResult->offsetExists('totalUser')) {
            $this->totalUser = $arrayResult['totalUser'];
        }
        if ($arrayResult->offsetExists('version')) {
            $this->version = $arrayResult['version'];
        }
    }
}
