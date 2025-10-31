<?php

class UmengUappRetentionInfo extends SDKDomain
{
    private $date;

    private $totalInstallUser;

    private $retentionRate;

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
     * @return mixed 当日安装用户数
     */
    public function getTotalInstallUser()
    {
        return $this->totalInstallUser;
    }

    /**
     * 设置当日安装用户数
     *
     * @param int $totalInstallUser
     *                              参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalInstallUser($totalInstallUser)
    {
        $this->totalInstallUser = $totalInstallUser;
    }

    /**
     * @return float 相对之后几日的留存用户数，安装日期到今日之间7天（每天），14天后，30天后留存用户占比（不包含今日）
     */
    public function getRetentionRate()
    {
        return $this->retentionRate;
    }

    /**
     * 设置相对之后几日的留存用户数，安装日期到今日之间7天（每天），14天后，30天后留存用户占比（不包含今日）
     *
     * @param float[] $retentionRate
     *                               参数示例：<pre></pre>
     * 此参数必填     */
    public function setRetentionRate($retentionRate)
    {
        $this->retentionRate = $retentionRate;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'date')) {
            $this->date = $this->stdResult->date;
        }
        if (property_exists($this->stdResult, 'totalInstallUser')) {
            $this->totalInstallUser = $this->stdResult->totalInstallUser;
        }
        if (property_exists($this->stdResult, 'retentionRate')) {
            $this->retentionRate = $this->stdResult->retentionRate;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('date')) {
            $this->date = $arrayResult['date'];
        }
        if ($arrayResult->offsetExists('totalInstallUser')) {
            $this->totalInstallUser = $arrayResult['totalInstallUser'];
        }
        if ($arrayResult->offsetExists('retentionRate')) {
            $this->retentionRate = $arrayResult['retentionRate'];
        }
    }
}
