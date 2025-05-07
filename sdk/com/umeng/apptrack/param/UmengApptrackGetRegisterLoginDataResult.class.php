<?php

class UmengApptrackGetRegisterLoginDataResult
{
    private $register;

    private $login;

    private $roleDevice;

    private $orderDevice;

    private $orderAmount;

    private $payDevice;

    private $amount;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 注册数量
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * 设置注册数量
     *
     * @param Long $register
     * 此参数必填     */
    public function setRegister($register)
    {
        $this->register = $register;
    }

    /**
     * @return 登录数量
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * 设置登录数量
     *
     * @param Long $login
     * 此参数必填     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return 创建角色数量
     */
    public function getRoleDevice()
    {
        return $this->roleDevice;
    }

    /**
     * 设置创建角色数量
     *
     * @param Long $roleDevice
     * 此参数必填     */
    public function setRoleDevice($roleDevice)
    {
        $this->roleDevice = $roleDevice;
    }

    /**
     * @return 拍下订单设备数量
     */
    public function getOrderDevice()
    {
        return $this->orderDevice;
    }

    /**
     * 设置拍下订单设备数量
     *
     * @param Long $orderDevice
     * 此参数必填     */
    public function setOrderDevice($orderDevice)
    {
        $this->orderDevice = $orderDevice;
    }

    /**
     * @return 拍下订单金额
     */
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * 设置拍下订单金额
     *
     * @param BigDecimal $orderAmount
     * 此参数必填     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;
    }

    /**
     * @return 付费设备数
     */
    public function getPayDevice()
    {
        return $this->payDevice;
    }

    /**
     * 设置付费设备数
     *
     * @param Long $payDevice
     * 此参数必填     */
    public function setPayDevice($payDevice)
    {
        $this->payDevice = $payDevice;
    }

    /**
     * @return 付费金额
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * 设置付费金额
     *
     * @param BigDecimal $amount
     * 此参数必填     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'register')) {
            $this->register = $this->stdResult->{'register'};
        }
        if (property_exists($this->stdResult, 'login')) {
            $this->login = $this->stdResult->{'login'};
        }
        if (property_exists($this->stdResult, 'roleDevice')) {
            $this->roleDevice = $this->stdResult->{'roleDevice'};
        }
        if (property_exists($this->stdResult, 'orderDevice')) {
            $this->orderDevice = $this->stdResult->{'orderDevice'};
        }
        if (property_exists($this->stdResult, 'orderAmount')) {
            $this->orderAmount = $this->stdResult->{'orderAmount'};
        }
        if (property_exists($this->stdResult, 'payDevice')) {
            $this->payDevice = $this->stdResult->{'payDevice'};
        }
        if (property_exists($this->stdResult, 'amount')) {
            $this->amount = $this->stdResult->{'amount'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('register')) {
            $this->register = $arrayResult['register'];
        }
        if ($arrayResult->offsetExists('login')) {
            $this->login = $arrayResult['login'];
        }
        if ($arrayResult->offsetExists('roleDevice')) {
            $this->roleDevice = $arrayResult['roleDevice'];
        }
        if ($arrayResult->offsetExists('orderDevice')) {
            $this->orderDevice = $arrayResult['orderDevice'];
        }
        if ($arrayResult->offsetExists('orderAmount')) {
            $this->orderAmount = $arrayResult['orderAmount'];
        }
        if ($arrayResult->offsetExists('payDevice')) {
            $this->payDevice = $arrayResult['payDevice'];
        }
        if ($arrayResult->offsetExists('amount')) {
            $this->amount = $arrayResult['amount'];
        }
    }
}
