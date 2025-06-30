<?php

class UmengApptrackGetOrderAnalysisDataResult
{
    private $data;

    private $total;

    private $stdResult;

    private $arrayResult;

    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置
     *
     * @param array include @see UmengApptrackGetPayAnalysis[] $data
     * 此参数必填     */
    public function setData(UmengApptrackGetPayAnalysis $data)
    {
        $this->data = $data;
    }

    /**
     * @return int 总数
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * 设置总数
     *
     * @param int $total
     * 此参数必填     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->{'data'};
            $object = json_decode(json_encode($dataResult), true);
            $this->data = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengApptrackGetPayAnalysisResult = new UmengApptrackGetPayAnalysis();
                $UmengApptrackGetPayAnalysisResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengApptrackGetPayAnalysisResult;
            }
        }
        if (property_exists($this->stdResult, 'total')) {
            $this->total = $this->stdResult->{'total'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengApptrackGetPayAnalysis();
            $this->data->setStdResult($dataResult);
        }
        if ($arrayResult->offsetExists('total')) {
            $this->total = $arrayResult['total'];
        }
    }
}
