<?php

class UmengUminiGetRetentionByDataSourceIdListDTO extends SDKDomain
{
    private $totalCount;

    private $currentPage;

    private $data;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 当前页码
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * 设置当前页码
     *
     * @param int $totalCount
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return 总条数
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * 设置总条数
     *
     * @param int $currentPage
     *                         参数示例：<pre></pre>
     * 此参数必填     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return 结果列表
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置结果列表
     *
     * @param array include @see UmengUminiGetRetentionByDataSourceIdDTO[] $data
     * 参数示例：<pre></pre>
     * 此参数必填     */
    public function setData(UmengUminiGetRetentionByDataSourceIdDTO $data)
    {
        $this->data = $data;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'totalCount')) {
            $this->totalCount = $this->stdResult->{'totalCount'};
        }
        if (property_exists($this->stdResult, 'currentPage')) {
            $this->currentPage = $this->stdResult->{'currentPage'};
        }
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->{'data'};
            $object = json_decode(json_encode($dataResult), true);
            $this->data = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUminiGetRetentionByDataSourceIdDTOResult = new UmengUminiGetRetentionByDataSourceIdDTO();
                $UmengUminiGetRetentionByDataSourceIdDTOResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengUminiGetRetentionByDataSourceIdDTOResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('totalCount')) {
            $this->totalCount = $arrayResult['totalCount'];
        }
        if ($arrayResult->offsetExists('currentPage')) {
            $this->currentPage = $arrayResult['currentPage'];
        }
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengUminiGetRetentionByDataSourceIdDTO();
            $this->data->setStdResult($dataResult);
        }
    }
}
