<?php

class UmengUappEventCreateResult
{
    private $status;

    private $msg;

    private $stdResult;

    /**
     * @return mixed 响应码
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 设置响应码
     *
     * @param int $status
     * 此参数必填     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string 响应信息
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * 设置响应信息
     *
     * @param string $msg
     * 此参数必填     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'status')) {
            $this->status = $this->stdResult->status;
        }
        if (property_exists($this->stdResult, 'msg')) {
            $this->msg = $this->stdResult->msg;
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('status')) {
            $this->status = $arrayResult['status'];
        }
        if ($arrayResult->offsetExists('msg')) {
            $this->msg = $arrayResult['msg'];
        }
    }
}
