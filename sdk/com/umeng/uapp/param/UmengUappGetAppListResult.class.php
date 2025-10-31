<?php

class UmengUappGetAppListResult
{
    private $appInfos;

    private $totalPage;

    private $page;

    private $stdResult;

    public function getAppInfos()
    {
        return $this->appInfos;
    }

    /**
     * 设置
     *
     * @param UmengUappAppInfoData[] $appInfos
     * 此参数必填     */
    public function setAppInfos(array $appInfos)
    {
        $this->appInfos = $appInfos;
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

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'appInfos')) {
            $appInfosResult = $this->stdResult->appInfos;
            $object = json_decode(json_encode($appInfosResult), true);
            $this->appInfos = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappAppInfoDataResult = new UmengUappAppInfoData();
                $UmengUappAppInfoDataResult->setArrayResult($arrayobject);
                $this->appInfos[$i] = $UmengUappAppInfoDataResult;
            }
        }
        if (property_exists($this->stdResult, 'totalPage')) {
            $this->totalPage = $this->stdResult->totalPage;
        }
        if (property_exists($this->stdResult, 'page')) {
            $this->page = $this->stdResult->page;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($this->arrayResult->offsetExists('appInfos')) {
            $appInfosResult = $arrayResult['appInfos'];
            $this->appInfos = new UmengUappAppInfoData();
            $this->appInfos->setStdResult($appInfosResult);
        }
        if ($this->arrayResult->offsetExists('totalPage')) {
            $this->totalPage = $arrayResult['totalPage'];
        }
        if ($this->arrayResult->offsetExists('page')) {
            $this->page = $arrayResult['page'];
        }
    }
}
