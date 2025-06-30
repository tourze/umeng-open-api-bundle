<?php

class UmengUappActiveAccountInfo extends SDKDomain
{
    private $date;

    private $activeUser;

    private $activeAccount;

    private $stdResult;

    private $arrayResult;

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
     *                     参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return mixed 活跃账号
     */
    public function getActiveAccount()
    {
        return $this->activeAccount;
    }

    /**
     * 设置活跃账号
     *
     * @param int $activeAccount
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setActiveAccount($activeAccount)
    {
        $this->activeAccount = $activeAccount;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'date')) {
            $this->date = $this->stdResult->{'date'};
        }
        if (property_exists($this->stdResult, 'activeUser')) {
            $this->activeUser = $this->stdResult->{'activeUser'};
        }
        if (property_exists($this->stdResult, 'activeAccount')) {
            $this->activeAccount = $this->stdResult->{'activeAccount'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('date')) {
            $this->date = $arrayResult['date'];
        }
        if ($arrayResult->offsetExists('activeUser')) {
            $this->activeUser = $arrayResult['activeUser'];
        }
        if ($arrayResult->offsetExists('activeAccount')) {
            $this->activeAccount = $arrayResult['activeAccount'];
        }
    }
}
