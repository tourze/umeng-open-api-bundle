<?php

class UmengUminiCustomerSourceDTO extends SDKDomain
{
    private $id;

    private $name;

    private $url;

    private $onceDuration;

    private $activeUser;

    private $newUser;

    private $launch;

    private $visitTimes;

    private $createDateTime;

    private $stdResult;

    /**
     * @return id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 设置id
     *
     * @param string $id
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string 名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置名称
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return URL(仅推广活动可用)
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 设置URL(仅推广活动可用)
     *
     * @param string $url
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return string 创建时间(仅推广活动可用)
     */
    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }

    /**
     * 设置创建时间(仅推广活动可用)
     *
     * @param string $createDateTime
     *                               参数示例：<pre></pre>
     * 此参数必填     */
    public function setCreateDateTime($createDateTime)
    {
        $this->createDateTime = $createDateTime;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'id')) {
            $this->id = $this->stdResult->id;
        }
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->name;
        }
        if (property_exists($this->stdResult, 'url')) {
            $this->url = $this->stdResult->url;
        }
        if (property_exists($this->stdResult, 'onceDuration')) {
            $this->onceDuration = $this->stdResult->onceDuration;
        }
        if (property_exists($this->stdResult, 'activeUser')) {
            $this->activeUser = $this->stdResult->activeUser;
        }
        if (property_exists($this->stdResult, 'newUser')) {
            $this->newUser = $this->stdResult->newUser;
        }
        if (property_exists($this->stdResult, 'launch')) {
            $this->launch = $this->stdResult->launch;
        }
        if (property_exists($this->stdResult, 'visitTimes')) {
            $this->visitTimes = $this->stdResult->visitTimes;
        }
        if (property_exists($this->stdResult, 'createDateTime')) {
            $this->createDateTime = $this->stdResult->createDateTime;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('id')) {
            $this->id = $arrayResult['id'];
        }
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('url')) {
            $this->url = $arrayResult['url'];
        }
        if ($arrayResult->offsetExists('onceDuration')) {
            $this->onceDuration = $arrayResult['onceDuration'];
        }
        if ($arrayResult->offsetExists('activeUser')) {
            $this->activeUser = $arrayResult['activeUser'];
        }
        if ($arrayResult->offsetExists('newUser')) {
            $this->newUser = $arrayResult['newUser'];
        }
        if ($arrayResult->offsetExists('launch')) {
            $this->launch = $arrayResult['launch'];
        }
        if ($arrayResult->offsetExists('visitTimes')) {
            $this->visitTimes = $arrayResult['visitTimes'];
        }
        if ($arrayResult->offsetExists('createDateTime')) {
            $this->createDateTime = $arrayResult['createDateTime'];
        }
    }
}
