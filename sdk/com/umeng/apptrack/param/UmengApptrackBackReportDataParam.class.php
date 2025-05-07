<?php

class UmengApptrackBackReportDataParam
{
    private $sdkStdResult = [];

    /**
     * @return 报表数据信息
     */
    public function getReportList()
    {
        $tempResult = $this->sdkStdResult['reportList'];

        return $tempResult;
    }

    /**
     * 设置报表数据信息
     *
     * @param array include @see UmengApptrackReport[] $reportList
     * 参数示例：<pre></pre>
     * 此参数必填     */
    public function setReportList(UmengApptrackReport $reportList)
    {
        $this->sdkStdResult['reportList'] = $reportList;
    }

    public function getSdkStdResult()
    {
        return $this->sdkStdResult;
    }
}
