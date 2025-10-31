<?php

class ByteArray
{
    private $bytesValue;

    public function setBytesValue($bytesValue)
    {
        $this->bytesValue = $bytesValue;
    }

    public function getBytesValue()
    {
        return $this->bytesValue;
    }

    /**
     * @deprecated Use getBytesValue() instead
     */
    public function getByteValue()
    {
        return $this->bytesValue;
    }
}
