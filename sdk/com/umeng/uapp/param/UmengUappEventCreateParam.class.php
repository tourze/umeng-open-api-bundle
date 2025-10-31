<?php

class UmengUappEventCreateParam
{
    private $sdkStdResult = [];

    /**
     * @return string 应用ID
     */
    public function getAppkey()
    {
        return $this->sdkStdResult['appkey'];
    }

    /**
     * 设置应用ID
     *
     * @param string $appkey
     *                       参数示例：<pre></pre>
     * 此参数必填     */
    public function setAppkey($appkey)
    {
        $this->sdkStdResult['appkey'] = $appkey;
    }

    /**
     * @return int 自定义事件名（英文和数字，不允许特殊符号?/.\<>）
     */
    public function getEventName()
    {
        return $this->sdkStdResult['eventName'];
    }

    /**
     * 设置自定义事件名（英文和数字，不允许特殊符号?/.\<>）
     *
     * @param string $eventName
     *                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventName($eventName)
    {
        $this->sdkStdResult['eventName'] = $eventName;
    }

    /**
     * @return int 自定义事件显示名（中文，英文和数字，不允许特殊符号?/.\<>）
     */
    public function getEventDisplayName()
    {
        return $this->sdkStdResult['eventDisplayName'];
    }

    /**
     * 设置自定义事件显示名（中文，英文和数字，不允许特殊符号?/.\<>）
     *
     * @param string $eventDisplayName
     *                                 参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventDisplayName($eventDisplayName)
    {
        $this->sdkStdResult['eventDisplayName'] = $eventDisplayName;
    }

    /**
     * @return true 计算事件（数值型），用于统计数值型变量的累计值、均值及分布。false  计数事件（字符串型），用于统计字符串型变量的消息数及触发设备数。
     */
    public function getEventType()
    {
        return $this->sdkStdResult['eventType'];
    }

    /**
     * 设置true  计算事件（数值型），用于统计数值型变量的累计值、均值及分布。false  计数事件（字符串型），用于统计字符串型变量的消息数及触发设备数。
     *
     * @param bool $eventType
     *                        参数示例：<pre>false</pre>
     *                        此参数为可选参数
     *                        默认值：<pre>false</pre>
     */
    public function setEventType($eventType)
    {
        $this->sdkStdResult['eventType'] = $eventType;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
