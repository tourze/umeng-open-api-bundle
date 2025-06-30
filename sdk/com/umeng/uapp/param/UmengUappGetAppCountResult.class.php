<?php

class UmengUappGetAppCountResult
{
    private $count;

    private $stdResult;

    private $arrayResult;

    /**
     * @return int 应用数量
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * 设置应用数量
     *
     * @param int $count
     * 此参数必填     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'count')) {
            $this->count = $this->stdResult->{'count'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('count')) {
            $this->count = $arrayResult['count'];
        }
    }
}
