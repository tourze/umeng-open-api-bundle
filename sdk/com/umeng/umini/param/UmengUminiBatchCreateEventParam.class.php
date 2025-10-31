<?php

class UmengUminiBatchCreateEventParam
{
    private $sdkStdResult = [];

    /**
     * @return mixed 数据源id（AppKey）
     */
    public function getDataSourceId()
    {
        return $this->sdkStdResult['dataSourceId'];
    }

    /**
     * 设置数据源id（AppKey）
     *
     * @param string $dataSourceId
     *                             参数示例：<pre></pre>
     * 此参数必填     */
    public function setDataSourceId($dataSourceId)
    {
        $this->sdkStdResult['dataSourceId'] = $dataSourceId;
    }

    /**
     * @return array 事件列表
     */
    public function getEventList()
    {
        return $this->sdkStdResult['eventList'];
    }

    /**
     * 设置事件列表
     *
     * @param UmengUminiEventDTO[] $eventList
     *                                        参数示例：<pre></pre>
     * 此参数必填     */
    public function setEventList(array $eventList)
    {
        $this->sdkStdResult['eventList'] = $eventList;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
