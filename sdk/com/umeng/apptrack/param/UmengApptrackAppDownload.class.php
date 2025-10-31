<?php

class UmengApptrackAppDownload extends SDKDomain
{
    private $unitId;

    private $mName;

    private $planName;

    private $chanName;

    private $type;

    private $deviceId;

    private $clickDate;

    private $activeDate;

    private $stdResult;

    /**
     * @return mixed 监测单元id
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * 设置监测单元id
     *
     * @param Long $unitId
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    }

    /**
     * @return string 监测单元名称
     */
    public function getMName()
    {
        return $this->mName;
    }

    /**
     * 设置监测单元名称
     *
     * @param string $mName
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setMName($mName)
    {
        $this->mName = $mName;
    }

    /**
     * @return string 推广计划名称
     */
    public function getPlanName()
    {
        return $this->planName;
    }

    /**
     * 设置推广计划名称
     *
     * @param string $planName
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setPlanName($planName)
    {
        $this->planName = $planName;
    }

    /**
     * @return string 渠道名称
     */
    public function getChanName()
    {
        return $this->chanName;
    }

    /**
     * 设置渠道名称
     *
     * @param string $chanName
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setChanName($chanName)
    {
        $this->chanName = $chanName;
    }

    /**
     * @return string 激活类型：
     *                iOS：IDFA、CAID、IDFV等
     *                Android：IMEI、OAID、ANDROID_ID等
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * 设置激活类型：
     * iOS：IDFA、CAID、IDFV等
     * Android：IMEI、OAID、ANDROID_ID等
     *
     * @param string $type
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string 激活设备id，其中IDFA、IMEI基于原值做md5加密，其他为原值
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * 设置激活设备id，其中IDFA、IMEI基于原值做md5加密，其他为原值
     *
     * @param string $deviceId
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @return string 点击日期：20200116
     */
    public function getClickDate()
    {
        return $this->clickDate;
    }

    /**
     * 设置点击日期：20200116
     *
     * @param string $clickDate
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setClickDate($clickDate)
    {
        $this->clickDate = $clickDate;
    }

    /**
     * @return string 激活日期：20200116
     */
    public function getActiveDate()
    {
        return $this->activeDate;
    }

    /**
     * 设置激活日期：20200116
     *
     * @param string $activeDate
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setActiveDate($activeDate)
    {
        $this->activeDate = $activeDate;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'unitId')) {
            $this->unitId = $this->stdResult->unitId;
        }
        if (property_exists($this->stdResult, 'mName')) {
            $this->mName = $this->stdResult->mName;
        }
        if (property_exists($this->stdResult, 'planName')) {
            $this->planName = $this->stdResult->planName;
        }
        if (property_exists($this->stdResult, 'chanName')) {
            $this->chanName = $this->stdResult->chanName;
        }
        if (property_exists($this->stdResult, 'type')) {
            $this->type = $this->stdResult->type;
        }
        if (property_exists($this->stdResult, 'deviceId')) {
            $this->deviceId = $this->stdResult->deviceId;
        }
        if (property_exists($this->stdResult, 'clickDate')) {
            $this->clickDate = $this->stdResult->clickDate;
        }
        if (property_exists($this->stdResult, 'activeDate')) {
            $this->activeDate = $this->stdResult->activeDate;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('unitId')) {
            $this->unitId = $arrayResult['unitId'];
        }
        if ($arrayResult->offsetExists('mName')) {
            $this->mName = $arrayResult['mName'];
        }
        if ($arrayResult->offsetExists('planName')) {
            $this->planName = $arrayResult['planName'];
        }
        if ($arrayResult->offsetExists('chanName')) {
            $this->chanName = $arrayResult['chanName'];
        }
        if ($arrayResult->offsetExists('type')) {
            $this->type = $arrayResult['type'];
        }
        if ($arrayResult->offsetExists('deviceId')) {
            $this->deviceId = $arrayResult['deviceId'];
        }
        if ($arrayResult->offsetExists('clickDate')) {
            $this->clickDate = $arrayResult['clickDate'];
        }
        if ($arrayResult->offsetExists('activeDate')) {
            $this->activeDate = $arrayResult['activeDate'];
        }
    }
}
