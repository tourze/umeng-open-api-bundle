<?php

class UmengUminiAppListDTO extends SDKDomain
{
    private $totalCount;

    private $currentPage;

    private $data;

    private $stdResult;

    /**
     * @return mixed 总条数
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
     * @return app信息
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置app信息
     *
     * @param UmengUminiAppInfoDTO[] $data
     *                                     参数示例：<pre></pre>
     * 此参数必填     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'totalCount')) {
            $this->totalCount = $this->stdResult->totalCount;
        }
        if (property_exists($this->stdResult, 'currentPage')) {
            $this->currentPage = $this->stdResult->currentPage;
        }
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->data;
            $object = json_decode(json_encode($dataResult), true);
            $this->data = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUminiAppInfoDTOResult = new UmengUminiAppInfoDTO();
                $UmengUminiAppInfoDTOResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengUminiAppInfoDTOResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('totalCount')) {
            $this->totalCount = $arrayResult['totalCount'];
        }
        if ($arrayResult->offsetExists('currentPage')) {
            $this->currentPage = $arrayResult['currentPage'];
        }
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengUminiAppInfoDTO();
            $this->data->setStdResult($dataResult);
        }
    }
}
