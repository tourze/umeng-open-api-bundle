<?php

class SerializerProvider
{
    private static $serializerStore = [];

    private static $deSerializerStore = [];

    private static $isInited = false;

    public static function getSerializer($key)
    {
        if (!SerializerProvider::$isInited) {
            SerializerProvider::initial();
        }
        $result = SerializerProvider::$serializerStore[$key];

        return $result;
    }

    private static function initial()
    {
        SerializerProvider::$serializerStore[DataProtocol::param2] = new Param2RequestSerializer();
        SerializerProvider::$deSerializerStore[DataProtocol::json2] = new Json2Deserializer();
        SerializerProvider::$deSerializerStore[DataProtocol::param2] = new Json2Deserializer();
        $isInited = true;
    }

    public static function getDeSerializer($key)
    {
        if (!SerializerProvider::$isInited) {
            SerializerProvider::initial();
        }
        $result = SerializerProvider::$deSerializerStore[$key];

        return $result;
    }
}
