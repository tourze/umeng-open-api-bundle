<?php

class UmengUminiVisitPageListDTO extends SDKDomain
{
    private $currentPage;

    private $data;

    private $totalCount;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 当前页码
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * 设置当前页码
     *
     * @param int $currentPage
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUminiVisitPageDTO[] $data
     * 参数示例：<pre></pre>
     * 此参数必填     */
    public function setData(UmengUminiVisitPageDTO $data)
    {
        $this->data = $data;
    }

    /**
     * @return 总条数
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * 设置总条数
     *
     * @param int $totalCount
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'currentPage')) {
            $this->currentPage = $this->stdResult->{'currentPage'};
        }
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->{'data'};
            $object = json_decode(json_encode($dataResult), true);
            $this->data = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUminiVisitPageDTOResult = new UmengUminiVisitPageDTO();
                $UmengUminiVisitPageDTOResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengUminiVisitPageDTOResult;
            }
        }
        if (property_exists($this->stdResult, 'totalCount')) {
            $this->totalCount = $this->stdResult->{'totalCount'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('currentPage')) {
            $this->currentPage = $arrayResult['currentPage'];
        }
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengUminiVisitPageDTO();
            $this->data->setStdResult($dataResult);
        }
        if ($arrayResult->offsetExists('totalCount')) {
            $this->totalCount = $arrayResult['totalCount'];
        }
    }
}
