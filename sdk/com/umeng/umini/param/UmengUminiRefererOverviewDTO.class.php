<?php

class UmengUminiRefererOverviewDTO extends SDKDomain
{
    private $currentPage;

    private $totalCount;

    private $data;

    private $stdResult;

    private $arrayResult;

    /**
     * @return mixed 当前页
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * 设置当前页
     *
     * @param int $currentPage
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return mixed 总记录数
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * 设置总记录数
     *
     * @param int $totalCount
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUminiRefererIndicatorDTO[] $data
     * 参数示例：<pre></pre>
     * 此参数必填     */
    public function setData(UmengUminiRefererIndicatorDTO $data)
    {
        $this->data = $data;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'currentPage')) {
            $this->currentPage = $this->stdResult->{'currentPage'};
        }
        if (property_exists($this->stdResult, 'totalCount')) {
            $this->totalCount = $this->stdResult->{'totalCount'};
        }
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->{'data'};
            $object = json_decode(json_encode($dataResult), true);
            $this->data = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUminiRefererIndicatorDTOResult = new UmengUminiRefererIndicatorDTO();
                $UmengUminiRefererIndicatorDTOResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengUminiRefererIndicatorDTOResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('currentPage')) {
            $this->currentPage = $arrayResult['currentPage'];
        }
        if ($arrayResult->offsetExists('totalCount')) {
            $this->totalCount = $arrayResult['totalCount'];
        }
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengUminiRefererIndicatorDTO();
            $this->data->setStdResult($dataResult);
        }
    }
}
