<?php

class UmengApptrackGetClickActiveDataResult
{
    private $clickPv;

    private $clickUv;

    private $activateUv;

    private $activateRate;

    private $totalActivateUv;

    private $activateDevice;

    private $stdResult;

    /**
     * @return mixed 点击pv
     */
    public function getClickPv()
    {
        return $this->clickPv;
    }

    /**
     * 设置点击pv
     *
     * @param Long $clickPv
     * 此参数必填     */
    public function setClickPv($clickPv)
    {
        $this->clickPv = $clickPv;
    }

    /**
     * @return mixed 点击uv
     */
    public function getClickUv()
    {
        return $this->clickUv;
    }

    /**
     * 设置点击uv
     *
     * @param Long $clickUv
     * 此参数必填     */
    public function setClickUv($clickUv)
    {
        $this->clickUv = $clickUv;
    }

    /**
     * @return mixed 激活真人数
     */
    public function getActivateUv()
    {
        return $this->activateUv;
    }

    /**
     * 设置激活真人数
     *
     * @param Long $activateUv
     * 此参数必填     */
    public function setActivateUv($activateUv)
    {
        $this->activateUv = $activateUv;
    }

    /**
     * @return float 点击激活比率
     */
    public function getActivateRate()
    {
        return $this->activateRate;
    }

    /**
     * 设置点击激活比率
     *
     * @param BigDecimal $activateRate
     * 此参数必填     */
    public function setActivateRate($activateRate)
    {
        $this->activateRate = $activateRate;
    }

    /**
     * @return mixed 总激活
     */
    public function getTotalActivateUv()
    {
        return $this->totalActivateUv;
    }

    /**
     * 设置总激活
     *
     * @param Long $totalActivateUv
     * 此参数必填     */
    public function setTotalActivateUv($totalActivateUv)
    {
        $this->totalActivateUv = $totalActivateUv;
    }

    /**
     * @return mixed 点击激活
     */
    public function getActivateDevice()
    {
        return $this->activateDevice;
    }

    /**
     * 设置点击激活
     *
     * @param Long $activateDevice
     * 此参数必填     */
    public function setActivateDevice($activateDevice)
    {
        $this->activateDevice = $activateDevice;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'clickPv')) {
            $this->clickPv = $this->stdResult->clickPv;
        }
        if (property_exists($this->stdResult, 'clickUv')) {
            $this->clickUv = $this->stdResult->clickUv;
        }
        if (property_exists($this->stdResult, 'activateUv')) {
            $this->activateUv = $this->stdResult->activateUv;
        }
        if (property_exists($this->stdResult, 'activateRate')) {
            $this->activateRate = $this->stdResult->activateRate;
        }
        if (property_exists($this->stdResult, 'totalActivateUv')) {
            $this->totalActivateUv = $this->stdResult->totalActivateUv;
        }
        if (property_exists($this->stdResult, 'activateDevice')) {
            $this->activateDevice = $this->stdResult->activateDevice;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('clickPv')) {
            $this->clickPv = $arrayResult['clickPv'];
        }
        if ($arrayResult->offsetExists('clickUv')) {
            $this->clickUv = $arrayResult['clickUv'];
        }
        if ($arrayResult->offsetExists('activateUv')) {
            $this->activateUv = $arrayResult['activateUv'];
        }
        if ($arrayResult->offsetExists('activateRate')) {
            $this->activateRate = $arrayResult['activateRate'];
        }
        if ($arrayResult->offsetExists('totalActivateUv')) {
            $this->totalActivateUv = $arrayResult['totalActivateUv'];
        }
        if ($arrayResult->offsetExists('activateDevice')) {
            $this->activateDevice = $arrayResult['activateDevice'];
        }
    }
}
