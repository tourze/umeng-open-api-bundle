<?php

class ExampleFamilyGetResult
{
    private $result;

    private $stdResult;

    private $arrayResult;

    /**
     * @return ExampleFamily|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * 设置
     *
     * @param ExampleFamily $result
     *                              此参数必填
     */
    public function setResult(ExampleFamily $result)
    {
        $this->result = $result;
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('result')) {
            $resultResult = $arrayResult['result'];
            $this->result = new ExampleFamily();
            $this->result->setStdResult($resultResult);
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'result')) {
            $resultResult = $this->stdResult->{'result'};
            $this->result = new ExampleFamily();
            $this->result->setStdResult($resultResult);
        }
    }
}
