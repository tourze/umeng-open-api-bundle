<?php

class UmengApptrackAppMonitors extends SDKDomain
{
    private $mid;

    private $mName;

    private $chanName;

    private $downloadUrl;

    private $shortUrl;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 单元id
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * 设置单元id
     *
     * @param Long $mid
     *                  参数示例：<pre></pre>
     * 此参数必填     */
    public function setMid($mid)
    {
        $this->mid = $mid;
    }

    /**
     * @return string 单元名称
     */
    public function getMName()
    {
        return $this->mName;
    }

    /**
     * 设置单元名称
     *
     * @param string $mName
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setMName($mName)
    {
        $this->mName = $mName;
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
     * @return mixed 下载地址
     */
    public function getDownloadUrl()
    {
        return $this->downloadUrl;
    }

    /**
     * 设置下载地址
     *
     * @param string $downloadUrl
     *                            参数示例：<pre></pre>
     * 此参数必填     */
    public function setDownloadUrl($downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;
    }

    /**
     * @return mixed 短链地址
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * 设置短链地址
     *
     * @param string $shortUrl
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'mid')) {
            $this->mid = $this->stdResult->{'mid'};
        }
        if (property_exists($this->stdResult, 'mName')) {
            $this->mName = $this->stdResult->{'mName'};
        }
        if (property_exists($this->stdResult, 'chanName')) {
            $this->chanName = $this->stdResult->{'chanName'};
        }
        if (property_exists($this->stdResult, 'downloadUrl')) {
            $this->downloadUrl = $this->stdResult->{'downloadUrl'};
        }
        if (property_exists($this->stdResult, 'shortUrl')) {
            $this->shortUrl = $this->stdResult->{'shortUrl'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('mid')) {
            $this->mid = $arrayResult['mid'];
        }
        if ($arrayResult->offsetExists('mName')) {
            $this->mName = $arrayResult['mName'];
        }
        if ($arrayResult->offsetExists('chanName')) {
            $this->chanName = $arrayResult['chanName'];
        }
        if ($arrayResult->offsetExists('downloadUrl')) {
            $this->downloadUrl = $arrayResult['downloadUrl'];
        }
        if ($arrayResult->offsetExists('shortUrl')) {
            $this->shortUrl = $arrayResult['shortUrl'];
        }
    }
}
