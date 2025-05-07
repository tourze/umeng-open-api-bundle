<?php

class DateUtil
{
    public static function getDateFormatInServer()
    {
        return 'yyyyMMddHHmmssSSSZ';
    }

    public static function parseToString($dateTime)
    {
        if (null == $dateTime) {
            return null;
        }

        return date(DateUtil::getDateFormat(), $dateTime);
    }

    public static function getDateFormat()
    {
        return 'YmdHisu';
    }
}
