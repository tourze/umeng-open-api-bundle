<?php

class UmengUappGetChannelDataResult
{
    private $channelInfos;

    private $page;

    private $totalPage;

    private $stdResult;

    public function getChannelInfos()
    {
        return $this->channelInfos;
    }

    /**
     * 设置
     *
     * @param UmengUappChannelInfo[] $channelInfos
     * 此参数必填     */
    public function setChannelInfos(array $channelInfos)
    {
        $this->channelInfos = $channelInfos;
    }

    /**
     * @return int 页数
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * 设置页数
     *
     * @param int $page
     * 此参数必填     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int 总页数
     */
    public function getTotalPage()
    {
        return $this->totalPage;
    }

    /**
     * 设置总页数
     *
     * @param int $totalPage
     * 此参数必填     */
    public function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'channelInfos')) {
            $channelInfosResult = $this->stdResult->channelInfos;
            $object = json_decode(json_encode($channelInfosResult), true);
            $this->channelInfos = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappChannelInfoResult = new UmengUappChannelInfo();
                $UmengUappChannelInfoResult->setArrayResult($arrayobject);
                $this->channelInfos[$i] = $UmengUappChannelInfoResult;
            }
        }
        if (property_exists($this->stdResult, 'page')) {
            $this->page = $this->stdResult->page;
        }
        if (property_exists($this->stdResult, 'totalPage')) {
            $this->totalPage = $this->stdResult->totalPage;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('channelInfos')) {
            $channelInfosResult = $arrayResult['channelInfos'];
            $this->channelInfos = new UmengUappChannelInfo();
            $this->channelInfos->setStdResult($channelInfosResult);
        }
        if ($arrayResult->offsetExists('page')) {
            $this->page = $arrayResult['page'];
        }
        if ($arrayResult->offsetExists('totalPage')) {
            $this->totalPage = $arrayResult['totalPage'];
        }
    }
}
