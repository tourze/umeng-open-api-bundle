<?php

class UmengUappEventParamListParam
{
    private $sdkStdResult = [];

    /**
     * @return 查询起始日期
     */
    public function getStartDate()
    {
        $tempResult = $this->sdkStdResult['startDate'];

        return $tempResult;
    }

    /**
     * 设置查询起始日期
     *
     * @param string $startDate
     *                          参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setStartDate($startDate)
    {
        $this->sdkStdResult['startDate'] = $startDate;
    }

    /**
     * @return 查询截止日期
     */
    public function getEndDate()
    {
        $tempResult = $this->sdkStdResult['endDate'];

        return $tempResult;
    }

    /**
     * 设置查询截止日期
     *
     * @param string $endDate
     *                        参数示例：<pre>2018-01-01</pre>
     * 此参数必填     */
    public function setEndDate($endDate)
    {
        $this->sdkStdResult['endDate'] = $endDate;
    }

    /**
     * @return 事件ID（通过umeng.uapp.event.list接口查询得到的ID）
     */
    public function getEventId()
    {
        $tempResult = $this->sdkStdResult['eventId'];

        return $tempResult;
    }

    /**
     * 设置事件ID（通过umeng.uapp.event.list接口查询得到的ID）
     *
     * @param string $eventId
     *                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventId($eventId)
    {
        $this->sdkStdResult['eventId'] = $eventId;
    }

    /**
     * @return 应用ID
     */
    public function getAppkey()
    {
        $tempResult = $this->sdkStdResult['appkey'];

        return $tempResult;
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

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
