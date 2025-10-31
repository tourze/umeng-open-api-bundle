<?php

class UmengApptrackBackReportDataParam
{
    private $sdkStdResult = [];

    /**
     * @return string 报表数据信息
     */
    public function getReportList()
    {
        return $this->sdkStdResult['reportList'];
    }

    /**
     * 设置报表数据信息
     *
     * @param UmengApptrackReport[] $reportList
     *                                          参数示例：<pre></pre>
     * 此参数必填     */
    public function setReportList(array $reportList)
    {
        $this->sdkStdResult['reportList'] = $reportList;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
