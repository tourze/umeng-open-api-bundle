<?php

class UmengUminiGetShareUserListResult
{
    private $data;

    private $msg;

    private $code;

    private $success;

    private $stdResult;

    /**
     * @return UmengUminiGetShareUserListResult 数据返回结果
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置数据返回结果
     *
     * @param UmengUminiShareUserListDTO $data
     * 此参数必填     */
    public function setData(UmengUminiShareUserListDTO $data)
    {
        $this->data = $data;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * 设置
     *
     * @param string $msg
     * 此参数必填     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * 设置
     *
     * @param Long $code
     * 此参数必填     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * 设置
     *
     * @param bool $success
     * 此参数必填     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengUminiShareUserListDTO();
            $this->data->setStdResult($dataResult);
        }
        if ($arrayResult->offsetExists('msg')) {
            $this->msg = $arrayResult['msg'];
        }
        if ($arrayResult->offsetExists('code')) {
            $this->code = $arrayResult['code'];
        }
        if ($arrayResult->offsetExists('success')) {
            $this->success = $arrayResult['success'];
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->data;
            $this->data = new UmengUminiShareUserListDTO();
            $this->data->setStdResult($dataResult);
        }
        if (property_exists($this->stdResult, 'msg')) {
            $this->msg = $this->stdResult->msg;
        }
        if (property_exists($this->stdResult, 'code')) {
            $this->code = $this->stdResult->code;
        }
        if (property_exists($this->stdResult, 'success')) {
            $this->success = $this->stdResult->success;
        }
    }
}
