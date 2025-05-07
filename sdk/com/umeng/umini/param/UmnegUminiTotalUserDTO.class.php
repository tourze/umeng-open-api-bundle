<?php

class UmnegUminiTotalUserDTO extends SDKDomain
{
    private $dateTime;

    private $totalUser;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 时间
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
     * @return 累计用户数
     */
    public function getTotalUser()
    {
        return $this->totalUser;
    }

    /**
     * 设置累计用户数
     *
     * @param Long $totalUser
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalUser($totalUser)
    {
        $this->totalUser = $totalUser;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'dateTime')) {
            $this->dateTime = $this->stdResult->{'dateTime'};
        }
        if (property_exists($this->stdResult, 'totalUser')) {
            $this->totalUser = $this->stdResult->{'totalUser'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('dateTime')) {
            $this->dateTime = $arrayResult['dateTime'];
        }
        if ($arrayResult->offsetExists('totalUser')) {
            $this->totalUser = $arrayResult['totalUser'];
        }
    }
}
