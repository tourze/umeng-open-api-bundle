<?php

class ExampleFamilyPostResult
{
    private $result;

    private $resultDesc;

    private $stdResult;

    /**
     * @return ExampleFamily|null 返回的接听信息
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * 设置返回的接听信息
     *
     * @param ExampleFamily $result
     *                              此参数必填
     */
    public function setResult(ExampleFamily $result)
    {
        $this->result = $result;
    }

    /**
     * @return string|null 返回结果描述
     */
    public function getResultDesc()
    {
        return $this->resultDesc;
    }

    /**
     * 设置返回结果描述
     *
     * @param string $resultDesc
     *                           此参数必填
     */
    public function setResultDesc($resultDesc)
    {
        $this->resultDesc = $resultDesc;
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('result')) {
            $resultResult = $arrayResult['result'];
            $this->result = new ExampleFamily();
            $this->result->setStdResult($resultResult);
        }
        if ($arrayResult->offsetExists('resultDesc')) {
            $this->resultDesc = $arrayResult['resultDesc'];
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'result')) {
            $resultResult = $this->stdResult->result;
            $this->result = new ExampleFamily();
            $this->result->setStdResult($resultResult);
        }
        if (property_exists($this->stdResult, 'resultDesc')) {
            $this->resultDesc = $this->stdResult->resultDesc;
        }
    }
}
