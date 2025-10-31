<?php

class UmengApptrackGetPlanListResult
{
    private $data;

    private $total;

    private $stdResult;

    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置
     *
     * @param UmengApptrackAppRecPlan[] $data
     * 此参数必填     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed 总记录数
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * 设置总记录数
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
            $dataResult = $this->stdResult->data;
            $object = json_decode(json_encode($dataResult), true);
            $this->data = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengApptrackAppRecPlanResult = new UmengApptrackAppRecPlan();
                $UmengApptrackAppRecPlanResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengApptrackAppRecPlanResult;
            }
        }
        if (property_exists($this->stdResult, 'total')) {
            $this->total = $this->stdResult->total;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengApptrackAppRecPlan();
            $this->data->setStdResult($dataResult);
        }
        if ($arrayResult->offsetExists('total')) {
            $this->total = $arrayResult['total'];
        }
    }
}
