<?php

class ParentResult
{
    private $stdResult;

    private $responseStatus;

    public function getStdResult()
    {
        return $this->stdResult;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
    }
}
