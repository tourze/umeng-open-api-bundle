<?php

class UmengApptrackGetPayAnalysis extends SDKDomain
{
    private $payId;

    private $payItem;

    private $orderId;

    private $amount;

    private $activateDs;

    private $eventDs;

    private $clickDs;

    private $stdResult;

    private $arrayResult;

    /**
     * @return 付费(拍下)ID
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * 设置付费(拍下)ID
     *
     * @param string $payId
     *                      参数示例：<pre></pre>
     * 此参数必填     */
    public function setPayId($payId)
    {
        $this->payId = $payId;
    }

    /**
     * @return 付费(拍下)商品
     */
    public function getPayItem()
    {
        return $this->payItem;
    }

    /**
     * 设置付费(拍下)商品
     *
     * @param string $payItem
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setPayItem($payItem)
    {
        $this->payItem = $payItem;
    }

    /**
     * @return 订单号
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * 设置订单号
     *
     * @param string $orderId
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return 付费(拍下)金额
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * 设置付费(拍下)金额
     *
     * @param BigDecimal $amount
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return 激活日期
     */
    public function getActivateDs()
    {
        return $this->activateDs;
    }

    /**
     * 设置激活日期
     *
     * @param string $activateDs
     *                           参数示例：<pre></pre>
     * 此参数必填     */
    public function setActivateDs($activateDs)
    {
        $this->activateDs = $activateDs;
    }

    /**
     * @return 事件日期
     */
    public function getEventDs()
    {
        return $this->eventDs;
    }

    /**
     * 设置事件日期
     *
     * @param string $eventDs
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventDs($eventDs)
    {
        $this->eventDs = $eventDs;
    }

    /**
     * @return 点击日期
     */
    public function getClickDs()
    {
        return $this->clickDs;
    }

    /**
     * 设置点击日期
     *
     * @param string $clickDs
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setClickDs($clickDs)
    {
        $this->clickDs = $clickDs;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'payId')) {
            $this->payId = $this->stdResult->{'payId'};
        }
        if (property_exists($this->stdResult, 'payItem')) {
            $this->payItem = $this->stdResult->{'payItem'};
        }
        if (property_exists($this->stdResult, 'orderId')) {
            $this->orderId = $this->stdResult->{'orderId'};
        }
        if (property_exists($this->stdResult, 'amount')) {
            $this->amount = $this->stdResult->{'amount'};
        }
        if (property_exists($this->stdResult, 'activateDs')) {
            $this->activateDs = $this->stdResult->{'activateDs'};
        }
        if (property_exists($this->stdResult, 'eventDs')) {
            $this->eventDs = $this->stdResult->{'eventDs'};
        }
        if (property_exists($this->stdResult, 'clickDs')) {
            $this->clickDs = $this->stdResult->{'clickDs'};
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('payId')) {
            $this->payId = $arrayResult['payId'];
        }
        if ($arrayResult->offsetExists('payItem')) {
            $this->payItem = $arrayResult['payItem'];
        }
        if ($arrayResult->offsetExists('orderId')) {
            $this->orderId = $arrayResult['orderId'];
        }
        if ($arrayResult->offsetExists('amount')) {
            $this->amount = $arrayResult['amount'];
        }
        if ($arrayResult->offsetExists('activateDs')) {
            $this->activateDs = $arrayResult['activateDs'];
        }
        if ($arrayResult->offsetExists('eventDs')) {
            $this->eventDs = $arrayResult['eventDs'];
        }
        if ($arrayResult->offsetExists('clickDs')) {
            $this->clickDs = $arrayResult['clickDs'];
        }
    }
}
