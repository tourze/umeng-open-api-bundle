<?php

class UmengApptrackBackReportDataResult
{
    private $result;

    private $stdResult;

    public function getResult()
    {
        return $this->result;
    }

    /**
     * 设置
     *
     * @param bool $result
     * 此参数必填     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'result')) {
            $this->result = $this->stdResult->result;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('result')) {
            $this->result = $arrayResult['result'];
        }
    }
}
