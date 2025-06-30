<?php

class UmengUappEventListResult
{
    private $eventInfo;

    private $page;

    private $totalPage;

    private $stdResult;

    private $arrayResult;

    public function getEventInfo()
    {
        return $this->eventInfo;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappEventInfo[] $eventInfo
     * 此参数必填     */
    public function setEventInfo(UmengUappEventInfo $eventInfo)
    {
        $this->eventInfo = $eventInfo;
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
        if (property_exists($this->stdResult, 'eventInfo')) {
            $eventInfoResult = $this->stdResult->{'eventInfo'};
            $object = json_decode(json_encode($eventInfoResult), true);
            $this->eventInfo = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappEventInfoResult = new UmengUappEventInfo();
                $UmengUappEventInfoResult->setArrayResult($arrayobject);
                $this->eventInfo[$i] = $UmengUappEventInfoResult;
            }
        }
        if (property_exists($this->stdResult, 'page')) {
            $this->page = $this->stdResult->{'page'};
        }
        if (property_exists($this->stdResult, 'totalPage')) {
            $this->totalPage = $this->stdResult->{'totalPage'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('eventInfo')) {
            $eventInfoResult = $arrayResult['eventInfo'];
            $this->eventInfo = new UmengUappEventInfo();
            $this->eventInfo->setStdResult($eventInfoResult);
        }
        if ($arrayResult->offsetExists('page')) {
            $this->page = $arrayResult['page'];
        }
        if ($arrayResult->offsetExists('totalPage')) {
            $this->totalPage = $arrayResult['totalPage'];
        }
    }
}
