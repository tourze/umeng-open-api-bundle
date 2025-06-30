<?php

class UmengApptrackAppRecPlan extends SDKDomain
{
    private $planId;

    private $planName;

    private $startDay;

    private $endDay;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 计划Id
     */
    public function getPlanId()
    {
        return $this->planId;
    }

    /**
     * 设置计划Id
     *
     * @param int $planId
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setPlanId($planId)
    {
        $this->planId = $planId;
    }

    /**
     * @return string 计划名称
     */
    public function getPlanName()
    {
        return $this->planName;
    }

    /**
     * 设置计划名称
     *
     * @param string $planName
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setPlanName($planName)
    {
        $this->planName = $planName;
    }

    /**
     * @return string 计划开始日期
     */
    public function getStartDay()
    {
        return $this->startDay;
    }

    /**
     * 设置计划开始日期
     *
     * @param string $startDay
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setStartDay($startDay)
    {
        $this->startDay = $startDay;
    }

    /**
     * @return string 计划结束日期
     */
    public function getEndDay()
    {
        return $this->endDay;
    }

    /**
     * 设置计划结束日期
     *
     * @param string $endDay
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setEndDay($endDay)
    {
        $this->endDay = $endDay;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'planId')) {
            $this->planId = $this->stdResult->{'planId'};
        }
        if (property_exists($this->stdResult, 'planName')) {
            $this->planName = $this->stdResult->{'planName'};
        }
        if (property_exists($this->stdResult, 'startDay')) {
            $this->startDay = $this->stdResult->{'startDay'};
        }
        if (property_exists($this->stdResult, 'endDay')) {
            $this->endDay = $this->stdResult->{'endDay'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('planId')) {
            $this->planId = $arrayResult['planId'];
        }
        if ($arrayResult->offsetExists('planName')) {
            $this->planName = $arrayResult['planName'];
        }
        if ($arrayResult->offsetExists('startDay')) {
            $this->startDay = $arrayResult['startDay'];
        }
        if ($arrayResult->offsetExists('endDay')) {
            $this->endDay = $arrayResult['endDay'];
        }
    }
}
