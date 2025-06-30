<?php

class UmengUappChannelInfo extends SDKDomain
{
    private $launch;

    private $duration;

    private $date;

    private $totalUserRate;

    private $activeUser;

    private $newUser;

    private $totalUser;

    private $channel;

    private $id;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 启动数（昨日及以前可查询）
     */
    public function getLaunch()
    {
        return $this->launch;
    }

    /**
     * 设置启动数（昨日及以前可查询）
     *
     * @param int $launch
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setLaunch($launch)
    {
        $this->launch = $launch;
    }

    /**
     * @return mixed 使用时长（昨日及以前可查询）
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * 设置使用时长（昨日及以前可查询）
     *
     * @param string $duration
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return string 日期
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * 设置日期
     *
     * @param string $date
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return float 当前渠道总用户数在总用户数中的比例
     */
    public function getTotalUserRate()
    {
        return $this->totalUserRate;
    }

    /**
     * 设置当前渠道总用户数在总用户数中的比例
     *
     * @param float $totalUserRate
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalUserRate($totalUserRate)
    {
        $this->totalUserRate = $totalUserRate;
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
     * @param int $activeUser
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setActiveUser($activeUser)
    {
        $this->activeUser = $activeUser;
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
     * @param int $newUser
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setNewUser($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * @return mixed 总用户数
     */
    public function getTotalUser()
    {
        return $this->totalUser;
    }

    /**
     * 设置总用户数
     *
     * @param int $totalUser
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalUser($totalUser)
    {
        $this->totalUser = $totalUser;
    }

    /**
     * @return string 渠道名称
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * 设置渠道名称
     *
     * @param string $channel
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return string 渠道ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 设置渠道ID
     *
     * @param string $id
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'launch')) {
            $this->launch = $this->stdResult->{'launch'};
        }
        if (property_exists($this->stdResult, 'duration')) {
            $this->duration = $this->stdResult->{'duration'};
        }
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
        if (property_exists($this->stdResult, 'channel')) {
            $this->channel = $this->stdResult->{'channel'};
        }
        if (property_exists($this->stdResult, 'id')) {
            $this->id = $this->stdResult->{'id'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('launch')) {
            $this->launch = $arrayResult['launch'];
        }
        if ($arrayResult->offsetExists('duration')) {
            $this->duration = $arrayResult['duration'];
        }
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
        if ($arrayResult->offsetExists('channel')) {
            $this->channel = $arrayResult['channel'];
        }
        if ($arrayResult->offsetExists('id')) {
            $this->id = $arrayResult['id'];
        }
    }
}
