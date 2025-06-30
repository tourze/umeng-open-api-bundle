<?php

class UmengUminiShareIndicatorDTO extends SDKDomain
{
    private $dateTime;

    private $reflowRatio;

    private $reflow;

    private $newUser;

    private $count;

    private $user;

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
     * @return mixed 回流比
     */
    public function getReflowRatio()
    {
        return $this->reflowRatio;
    }

    /**
     * 设置回流比
     *
     * @param string $reflowRatio
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setReflowRatio($reflowRatio)
    {
        $this->reflowRatio = $reflowRatio;
    }

    /**
     * @return mixed 分享回流量
     */
    public function getReflow()
    {
        return $this->reflow;
    }

    /**
     * 设置分享回流量
     *
     * @param Long $reflow
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setReflow($reflow)
    {
        $this->reflow = $reflow;
    }

    /**
     * @return mixed 分享新增
     */
    public function getNewUser()
    {
        return $this->newUser;
    }

    /**
     * 设置分享新增
     *
     * @param Long $newUser
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setNewUser($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * @return int 分享次数
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * 设置分享次数
     *
     * @param Long $count
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed 分享人数
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * 设置分享人数
     *
     * @param Long $user
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'dateTime')) {
            $this->dateTime = $this->stdResult->{'dateTime'};
        }
        if (property_exists($this->stdResult, 'reflowRatio')) {
            $this->reflowRatio = $this->stdResult->{'reflowRatio'};
        }
        if (property_exists($this->stdResult, 'reflow')) {
            $this->reflow = $this->stdResult->{'reflow'};
        }
        if (property_exists($this->stdResult, 'newUser')) {
            $this->newUser = $this->stdResult->{'newUser'};
        }
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->{'count'};
        }
        if (property_exists($this->stdResult, 'user')) {
            $this->user = $this->stdResult->{'user'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('dateTime')) {
            $this->dateTime = $arrayResult['dateTime'];
        }
        if ($arrayResult->offsetExists('reflowRatio')) {
            $this->reflowRatio = $arrayResult['reflowRatio'];
        }
        if ($arrayResult->offsetExists('reflow')) {
            $this->reflow = $arrayResult['reflow'];
        }
        if ($arrayResult->offsetExists('newUser')) {
            $this->newUser = $arrayResult['newUser'];
        }
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
        if ($arrayResult->offsetExists('user')) {
            $this->user = $arrayResult['user'];
        }
    }
}
