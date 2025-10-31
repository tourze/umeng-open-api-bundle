<?php

class UmengApptrackReport extends SDKDomain
{
    private $orderId;

    private $advertiserId;

    private $adPlanId;

    private $adPlanName;

    private $adGroupId;

    private $adGroupName;

    private $adCreativeId;

    private $adCreativeName;

    private $pid;

    private $pidName;

    private $mediaId;

    private $mediaName;

    private $landingUrl;

    private $showPv;

    private $clickPv;

    private $bidCost;

    private $conversionUv;

    private $ds;

    private $retentionCount;

    private $version;

    private $stdResult;

    /**
     * @return mixed 本次投放订单号
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 设置本次投放订单号
     *
     * @param string $orderId
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed 广告主id
     */
    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    /**
     * 设置广告主id
     *
     * @param Long $advertiserId
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }

    /**
     * @return mixed 推广计划id
     */
    public function getAdPlanId()
    {
        return $this->adPlanId;
    }

    /**
     * 设置推广计划id
     *
     * @param Long $adPlanId
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdPlanId($adPlanId)
    {
        $this->adPlanId = $adPlanId;
    }

    /**
     * @return string 推广计划名称
     */
    public function getAdPlanName()
    {
        return $this->adPlanName;
    }

    /**
     * 设置推广计划名称
     *
     * @param string $adPlanName
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdPlanName($adPlanName)
    {
        $this->adPlanName = $adPlanName;
    }

    /**
     * @return mixed 推广组id
     */
    public function getAdGroupId()
    {
        return $this->adGroupId;
    }

    /**
     * 设置推广组id
     *
     * @param Long $adGroupId
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdGroupId($adGroupId)
    {
        $this->adGroupId = $adGroupId;
    }

    /**
     * @return string 推广组名称
     */
    public function getAdGroupName()
    {
        return $this->adGroupName;
    }

    /**
     * 设置推广组名称
     *
     * @param string $adGroupName
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdGroupName($adGroupName)
    {
        $this->adGroupName = $adGroupName;
    }

    /**
     * @return mixed 推广创意id
     */
    public function getAdCreativeId()
    {
        return $this->adCreativeId;
    }

    /**
     * 设置推广创意id
     *
     * @param Long $adCreativeId
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdCreativeId($adCreativeId)
    {
        $this->adCreativeId = $adCreativeId;
    }

    /**
     * @return string 推广创意名称
     */
    public function getAdCreativeName()
    {
        return $this->adCreativeName;
    }

    /**
     * 设置推广创意名称
     *
     * @param string $adCreativeName
     *                               参数示例：<pre></pre>
     * 此参数必填     */
    public function setAdCreativeName($adCreativeName)
    {
        $this->adCreativeName = $adCreativeName;
    }

    /**
     * @return mixed 推广位id
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * 设置推广位id
     *
     * @param Long $pid
     *                  参数示例：<pre></pre>
     * 此参数必填     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return string 推广位名称
     */
    public function getPidName()
    {
        return $this->pidName;
    }

    /**
     * 设置推广位名称
     *
     * @param string $pidName
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setPidName($pidName)
    {
        $this->pidName = $pidName;
    }

    /**
     * @return mixed 媒体id
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * 设置媒体id
     *
     * @param Long $mediaId
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * @return string 媒体名称
     */
    public function getMediaName()
    {
        return $this->mediaName;
    }

    /**
     * 设置媒体名称
     *
     * @param string $mediaName
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setMediaName($mediaName)
    {
        $this->mediaName = $mediaName;
    }

    /**
     * @return mixed 落地页链接
     */
    public function getLandingUrl()
    {
        return $this->landingUrl;
    }

    /**
     * 设置落地页链接
     *
     * @param string $landingUrl
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setLandingUrl($landingUrl)
    {
        $this->landingUrl = $landingUrl;
    }

    /**
     * @return mixed 展现pv
     */
    public function getShowPv()
    {
        return $this->showPv;
    }

    /**
     * 设置展现pv
     *
     * @param Long $showPv
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setShowPv($showPv)
    {
        $this->showPv = $showPv;
    }

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
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setClickPv($clickPv)
    {
        $this->clickPv = $clickPv;
    }

    /**
     * @return mixed 竞价消耗
     */
    public function getBidCost()
    {
        return $this->bidCost;
    }

    /**
     * 设置竞价消耗
     *
     * @param float $bidCost
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setBidCost($bidCost)
    {
        $this->bidCost = $bidCost;
    }

    /**
     * @return mixed 转化数
     */
    public function getConversionUv()
    {
        return $this->conversionUv;
    }

    /**
     * 设置转化数
     *
     * @param Long $conversionUv
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setConversionUv($conversionUv)
    {
        $this->conversionUv = $conversionUv;
    }

    /**
     * @return string 数据日期
     */
    public function getDs()
    {
        return $this->ds;
    }

    /**
     * 设置数据日期
     *
     * @param string $ds
     *                   参数示例：<pre></pre>
     * 此参数必填     */
    public function setDs($ds)
    {
        $this->ds = $ds;
    }

    /**
     * @return mixed 次日留存数
     */
    public function getRetentionCount()
    {
        return $this->retentionCount;
    }

    /**
     * 设置次日留存数
     *
     * @param Long $retentionCount
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setRetentionCount($retentionCount)
    {
        $this->retentionCount = $retentionCount;
    }

    /**
     * @return string 数据版本号
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 设置数据版本号
     *
     * @param int $version
     *                     参数示例：<pre>默认0，重跑时需+1</pre>
     * 此参数必填     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'orderId')) {
            $this->orderId = $this->stdResult->orderId;
        }
        if (property_exists($this->stdResult, 'advertiserId')) {
            $this->advertiserId = $this->stdResult->advertiserId;
        }
        if (property_exists($this->stdResult, 'adPlanId')) {
            $this->adPlanId = $this->stdResult->adPlanId;
        }
        if (property_exists($this->stdResult, 'adPlanName')) {
            $this->adPlanName = $this->stdResult->adPlanName;
        }
        if (property_exists($this->stdResult, 'adGroupId')) {
            $this->adGroupId = $this->stdResult->adGroupId;
        }
        if (property_exists($this->stdResult, 'adGroupName')) {
            $this->adGroupName = $this->stdResult->adGroupName;
        }
        if (property_exists($this->stdResult, 'adCreativeId')) {
            $this->adCreativeId = $this->stdResult->adCreativeId;
        }
        if (property_exists($this->stdResult, 'adCreativeName')) {
            $this->adCreativeName = $this->stdResult->adCreativeName;
        }
        if (property_exists($this->stdResult, 'pid')) {
            $this->pid = $this->stdResult->pid;
        }
        if (property_exists($this->stdResult, 'pidName')) {
            $this->pidName = $this->stdResult->pidName;
        }
        if (property_exists($this->stdResult, 'mediaId')) {
            $this->mediaId = $this->stdResult->mediaId;
        }
        if (property_exists($this->stdResult, 'mediaName')) {
            $this->mediaName = $this->stdResult->mediaName;
        }
        if (property_exists($this->stdResult, 'landingUrl')) {
            $this->landingUrl = $this->stdResult->landingUrl;
        }
        if (property_exists($this->stdResult, 'showPv')) {
            $this->showPv = $this->stdResult->showPv;
        }
        if (property_exists($this->stdResult, 'clickPv')) {
            $this->clickPv = $this->stdResult->clickPv;
        }
        if (property_exists($this->stdResult, 'bidCost')) {
            $this->bidCost = $this->stdResult->bidCost;
        }
        if (property_exists($this->stdResult, 'conversionUv')) {
            $this->conversionUv = $this->stdResult->conversionUv;
        }
        if (property_exists($this->stdResult, 'ds')) {
            $this->ds = $this->stdResult->ds;
        }
        if (property_exists($this->stdResult, 'retentionCount')) {
            $this->retentionCount = $this->stdResult->retentionCount;
        }
        if (property_exists($this->stdResult, 'version')) {
            $this->version = $this->stdResult->version;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('orderId')) {
            $this->orderId = $arrayResult['orderId'];
        }
        if ($arrayResult->offsetExists('advertiserId')) {
            $this->advertiserId = $arrayResult['advertiserId'];
        }
        if ($arrayResult->offsetExists('adPlanId')) {
            $this->adPlanId = $arrayResult['adPlanId'];
        }
        if ($arrayResult->offsetExists('adPlanName')) {
            $this->adPlanName = $arrayResult['adPlanName'];
        }
        if ($arrayResult->offsetExists('adGroupId')) {
            $this->adGroupId = $arrayResult['adGroupId'];
        }
        if ($arrayResult->offsetExists('adGroupName')) {
            $this->adGroupName = $arrayResult['adGroupName'];
        }
        if ($arrayResult->offsetExists('adCreativeId')) {
            $this->adCreativeId = $arrayResult['adCreativeId'];
        }
        if ($arrayResult->offsetExists('adCreativeName')) {
            $this->adCreativeName = $arrayResult['adCreativeName'];
        }
        if ($arrayResult->offsetExists('pid')) {
            $this->pid = $arrayResult['pid'];
        }
        if ($arrayResult->offsetExists('pidName')) {
            $this->pidName = $arrayResult['pidName'];
        }
        if ($arrayResult->offsetExists('mediaId')) {
            $this->mediaId = $arrayResult['mediaId'];
        }
        if ($arrayResult->offsetExists('mediaName')) {
            $this->mediaName = $arrayResult['mediaName'];
        }
        if ($arrayResult->offsetExists('landingUrl')) {
            $this->landingUrl = $arrayResult['landingUrl'];
        }
        if ($arrayResult->offsetExists('showPv')) {
            $this->showPv = $arrayResult['showPv'];
        }
        if ($arrayResult->offsetExists('clickPv')) {
            $this->clickPv = $arrayResult['clickPv'];
        }
        if ($arrayResult->offsetExists('bidCost')) {
            $this->bidCost = $arrayResult['bidCost'];
        }
        if ($arrayResult->offsetExists('conversionUv')) {
            $this->conversionUv = $arrayResult['conversionUv'];
        }
        if ($arrayResult->offsetExists('ds')) {
            $this->ds = $arrayResult['ds'];
        }
        if ($arrayResult->offsetExists('retentionCount')) {
            $this->retentionCount = $arrayResult['retentionCount'];
        }
        if ($arrayResult->offsetExists('version')) {
            $this->version = $arrayResult['version'];
        }
    }
}
