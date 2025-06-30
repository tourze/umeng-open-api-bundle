<?php

class UmengUminiShareUserDTO extends SDKDomain
{
    private $reflowRatio;

    private $avatarUrl;

    private $reflow;

    private $nickName;

    private $newUser;

    private $count;

    private $userId;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 分享回流比
     */
    public function getReflowRatio()
    {
        return $this->reflowRatio;
    }

    /**
     * 设置分享回流比
     *
     * @param float $reflowRatio
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setReflowRatio($reflowRatio)
    {
        $this->reflowRatio = $reflowRatio;
    }

    /**
     * @return mixed 头像URL
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * 设置头像URL
     *
     * @param string $avatarUrl
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * @return mixed 用户回流量
     */
    public function getReflow()
    {
        return $this->reflow;
    }

    /**
     * 设置用户回流量
     *
     * @param Long $reflow
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setReflow($reflow)
    {
        $this->reflow = $reflow;
    }

    /**
     * @return mixed 用户名
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * 设置用户名
     *
     * @param string $nickName
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
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
     * @return mixed 分享回流量
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * 设置分享回流量
     *
     * @param Long $count
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return string 用户ID
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 设置用户ID
     *
     * @param string $userId
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'reflowRatio')) {
            $this->reflowRatio = $this->stdResult->{'reflowRatio'};
        }
        if (property_exists($this->stdResult, 'avatarUrl')) {
            $this->avatarUrl = $this->stdResult->{'avatarUrl'};
        }
        if (property_exists($this->stdResult, 'reflow')) {
            $this->reflow = $this->stdResult->{'reflow'};
        }
        if (property_exists($this->stdResult, 'nickName')) {
            $this->nickName = $this->stdResult->{'nickName'};
        }
        if (property_exists($this->stdResult, 'newUser')) {
            $this->newUser = $this->stdResult->{'newUser'};
        }
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->{'count'};
        }
        if (property_exists($this->stdResult, 'userId')) {
            $this->userId = $this->stdResult->{'userId'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('reflowRatio')) {
            $this->reflowRatio = $arrayResult['reflowRatio'];
        }
        if ($arrayResult->offsetExists('avatarUrl')) {
            $this->avatarUrl = $arrayResult['avatarUrl'];
        }
        if ($arrayResult->offsetExists('reflow')) {
            $this->reflow = $arrayResult['reflow'];
        }
        if ($arrayResult->offsetExists('nickName')) {
            $this->nickName = $arrayResult['nickName'];
        }
        if ($arrayResult->offsetExists('newUser')) {
            $this->newUser = $arrayResult['newUser'];
        }
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
        if ($arrayResult->offsetExists('userId')) {
            $this->userId = $arrayResult['userId'];
        }
    }
}
