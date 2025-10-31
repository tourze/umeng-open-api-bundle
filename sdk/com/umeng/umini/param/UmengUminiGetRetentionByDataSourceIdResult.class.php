<?php

class UmengUminiGetRetentionByDataSourceIdResult
{
    private $data;

    private $code;

    private $success;

    private $msg;

    private $stdResult;

    /**
     * @return UmengUminiGetRetentionByData 返回留存数据
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置返回留存数据
     *
     * @param UmengUminiGetRetentionByDataSourceIdListDTO $data
     * 此参数必填     */
    public function setData(UmengUminiGetRetentionByDataSourceIdListDTO $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed 状态码
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 设置状态码
     *
     * @param Long $code
     * 此参数必填     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed 状态
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * 设置状态
     *
     * @param bool $success
     * 此参数必填     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return mixed 返回消息
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * 设置返回消息
     *
     * @param string $msg
     * 此参数必填     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengUminiGetRetentionByDataSourceIdListDTO();
            $this->data->setStdResult($dataResult);
        }
        if ($arrayResult->offsetExists('code')) {
            $this->code = $arrayResult['code'];
        }
        if ($arrayResult->offsetExists('success')) {
            $this->success = $arrayResult['success'];
        }
        if ($arrayResult->offsetExists('msg')) {
            $this->msg = $arrayResult['msg'];
        }
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'data')) {
            $dataResult = $this->stdResult->data;
            $this->data = new UmengUminiGetRetentionByDataSourceIdListDTO();
            $this->data->setStdResult($dataResult);
        }
        if (property_exists($this->stdResult, 'code')) {
            $this->code = $this->stdResult->code;
        }
        if (property_exists($this->stdResult, 'success')) {
            $this->success = $this->stdResult->success;
        }
        if (property_exists($this->stdResult, 'msg')) {
            $this->msg = $this->stdResult->msg;
        }
    }
}
