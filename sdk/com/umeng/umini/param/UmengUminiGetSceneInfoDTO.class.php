<?php

class UmengUminiGetSceneInfoDTO extends SDKDomain
{
    private $code;

    private $name;

    private $url;

    private $createDateTime;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 推广活动值/渠道值
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 设置推广活动值/渠道值
     *
     * @param string $code
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return 推广活动/渠道中文名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 设置推广活动/渠道中文名称
     *
     * @param string $name
     *                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return 推广活动连接
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 设置推广活动连接
     *
     * @param string $url
     *                    参数示例：<pre></pre>
     * 此参数必填     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return 推广活动创建时间
     */
    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }

    /**
     * 设置推广活动创建时间
     *
     * @param string $createDateTime
     *                               参数示例：<pre></pre>
     * 此参数必填     */
    public function setCreateDateTime($createDateTime)
    {
        $this->createDateTime = $createDateTime;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'code')) {
            $this->code = $this->stdResult->{'code'};
        }
        if (property_exists($this->stdResult, 'name')) {
            $this->name = $this->stdResult->{'name'};
        }
        if (property_exists($this->stdResult, 'url')) {
            $this->url = $this->stdResult->{'url'};
        }
        if (property_exists($this->stdResult, 'createDateTime')) {
            $this->createDateTime = $this->stdResult->{'createDateTime'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('code')) {
            $this->code = $arrayResult['code'];
        }
        if ($arrayResult->offsetExists('name')) {
            $this->name = $arrayResult['name'];
        }
        if ($arrayResult->offsetExists('url')) {
            $this->url = $arrayResult['url'];
        }
        if ($arrayResult->offsetExists('createDateTime')) {
            $this->createDateTime = $arrayResult['createDateTime'];
        }
    }
}
