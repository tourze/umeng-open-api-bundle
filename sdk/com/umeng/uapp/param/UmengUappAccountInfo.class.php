<?php

class UmengUappAccountInfo extends SDKDomain
{
    private $date;

    private $newUser;

    private $newAccount;

    private $hourNewUser;

    private $hourNewAccount;

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
     *                     参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return 新增账号
     */
    public function getNewAccount()
    {
        return $this->newAccount;
    }

    /**
     * 设置新增账号
     *
     * @param int $newAccount
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setNewAccount($newAccount)
    {
        $this->newAccount = $newAccount;
    }

    /**
     * @return 小时新增用户（按小时查询时）
     */
    public function getHourNewUser()
    {
        return $this->hourNewUser;
    }

    /**
     * 设置小时新增用户（按小时查询时）
     *
     * @param array include @see Integer[] $hourNewUser
     * 参数示例：<pre>[11,65,49,4,4,8,25,29,31,29,32,29,38,63,39,33,34,41,40,53,12,77,86,50]</pre>
     * 此参数必填     */
    public function setHourNewUser($hourNewUser)
    {
        $this->hourNewUser = $hourNewUser;
    }

    /**
     * @return 小时新增账号（按小时查询时）
     */
    public function getHourNewAccount()
    {
        return $this->hourNewAccount;
    }

    /**
     * 设置小时新增账号（按小时查询时）
     *
     * @param array include @see Integer[] $hourNewAccount
     * 参数示例：<pre>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]</pre>
     * 此参数必填     */
    public function setHourNewAccount($hourNewAccount)
    {
        $this->hourNewAccount = $hourNewAccount;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'date')) {
            $this->date = $this->stdResult->{'date'};
        }
        if (property_exists($this->stdResult, 'newUser')) {
            $this->newUser = $this->stdResult->{'newUser'};
        }
        if (property_exists($this->stdResult, 'newAccount')) {
            $this->newAccount = $this->stdResult->{'newAccount'};
        }
        if (property_exists($this->stdResult, 'hourNewUser')) {
            $this->hourNewUser = $this->stdResult->{'hourNewUser'};
        }
        if (property_exists($this->stdResult, 'hourNewAccount')) {
            $this->hourNewAccount = $this->stdResult->{'hourNewAccount'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('date')) {
            $this->date = $arrayResult['date'];
        }
        if ($arrayResult->offsetExists('newUser')) {
            $this->newUser = $arrayResult['newUser'];
        }
        if ($arrayResult->offsetExists('newAccount')) {
            $this->newAccount = $arrayResult['newAccount'];
        }
        if ($arrayResult->offsetExists('hourNewUser')) {
            $this->hourNewUser = $arrayResult['hourNewUser'];
        }
        if ($arrayResult->offsetExists('hourNewAccount')) {
            $this->hourNewAccount = $arrayResult['hourNewAccount'];
        }
    }
}
