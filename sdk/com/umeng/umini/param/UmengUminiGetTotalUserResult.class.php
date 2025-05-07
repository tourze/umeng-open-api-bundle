<?php

class UmengUminiGetTotalUserResult
{
    private $data;

    private $code;

    private $msg;

    private $success;

    private $stdResult;

    private $arrayResult;

    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置
     *
     * @param array include @see UmnegUminiTotalUserDTO[] $data
     * 此参数必填     */
    public function setData(UmnegUminiTotalUserDTO $data)
    {
        $this->data = $data;
    }

    /**
     * @return 状态码
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
     * @return 消息
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * 设置消息
     *
     * @param string $msg
     * 此参数必填     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return 执行状态
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * 设置执行状态
     *
     * @param bool $success
     * 此参数必填     */
    public function setSuccess($success)
    {
        $this->success = $success;
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
                $UmnegUminiTotalUserDTOResult = new UmnegUminiTotalUserDTO();
                $UmnegUminiTotalUserDTOResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmnegUminiTotalUserDTOResult;
            }
        }
        if (property_exists($this->stdResult, 'code')) {
            $this->code = $this->stdResult->{'code'};
        }
        if (property_exists($this->stdResult, 'msg')) {
            $this->msg = $this->stdResult->{'msg'};
        }
        if (property_exists($this->stdResult, 'success')) {
            $this->success = $this->stdResult->{'success'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmnegUminiTotalUserDTO();
            $this->data->setStdResult($dataResult);
        }
        if ($arrayResult->offsetExists('code')) {
            $this->code = $arrayResult['code'];
        }
        if ($arrayResult->offsetExists('msg')) {
            $this->msg = $arrayResult['msg'];
        }
        if ($arrayResult->offsetExists('success')) {
            $this->success = $arrayResult['success'];
        }
    }
}
