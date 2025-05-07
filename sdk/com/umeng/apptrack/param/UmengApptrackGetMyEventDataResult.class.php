<?php

class UmengApptrackGetMyEventDataResult
{
    private $data;

    private $stdResult;

    private $arrayResult;

    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置
     *
     * @param array include @see UmengApptrackAppEvent[] $data
     * 此参数必填     */
    public function setData(UmengApptrackAppEvent $data)
    {
        $this->data = $data;
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
                $UmengApptrackAppEventResult = new UmengApptrackAppEvent();
                $UmengApptrackAppEventResult->setArrayResult($arrayobject);
                $this->data[$i] = $UmengApptrackAppEventResult;
            }
        }
    }

    public function setArrayResult(ArrayObject $arrayResult)
    {
        $this->arrayResult = $arrayResult;
        if ($arrayResult->offsetExists('data')) {
            $dataResult = $arrayResult['data'];
            $this->data = new UmengApptrackAppEvent();
            $this->data->setStdResult($dataResult);
        }
    }
}
