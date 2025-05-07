<?php

class UmengUappEventGetDataResult
{
    private $eventData;

    private $stdResult;

    private $arrayResult;

    public function getEventData()
    {
        return $this->eventData;
    }

    /**
     * 设置
     *
     * @param array include @see UmengUappDateCountInfo[] $eventData
     * 此参数必填     */
    public function setEventData(UmengUappDateCountInfo $eventData)
    {
        $this->eventData = $eventData;
    }

    public function setStdResult($stdResult)
    {
        $this->stdResult = $stdResult;
        if (property_exists($this->stdResult, 'eventData')) {
            $eventDataResult = $this->stdResult->{'eventData'};
            $object = json_decode(json_encode($eventDataResult), true);
            $this->eventData = [];
            for ($i = 0; $i < count($object); ++$i) {
                $arrayobject = new ArrayObject($object[$i]);
                $UmengUappDateCountInfoResult = new UmengUappDateCountInfo();
                $UmengUappDateCountInfoResult->setArrayResult($arrayobject);
                $this->eventData[$i] = $UmengUappDateCountInfoResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('eventData')) {
            $eventDataResult = $arrayResult['eventData'];
            $this->eventData = new UmengUappDateCountInfo();
            $this->eventData->setStdResult($eventDataResult);
        }
    }
}
