<?php

class UmengUminiSharePageIndicatorDTO extends SDKDomain
{
    private $reflowRatio;

    private $path;

    private $reflow;

    private $newUser;

    private $count;

    private $user;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 分享回流比
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
     * @return 页面url
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * 设置页面url
     *
     * @param string $path
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return 分享回流
     */
    public function getReflow()
    {
        return $this->reflow;
    }

    /**
     * 设置分享回流
     *
     * @param Long $reflow
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setReflow($reflow)
    {
        $this->reflow = $reflow;
    }

    /**
     * @return 分享新增
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
     * @return 分享次数
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
     * @return 分享人数
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
        if (property_exists($this->stdResult, 'reflowRatio')) {
            $this->reflowRatio = $this->stdResult->{'reflowRatio'};
        }
        if (property_exists($this->stdResult, 'path')) {
            $this->path = $this->stdResult->{'path'};
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
        if ($arrayResult->offsetExists('reflowRatio')) {
            $this->reflowRatio = $arrayResult['reflowRatio'];
        }
        if ($arrayResult->offsetExists('path')) {
            $this->path = $arrayResult['path'];
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
