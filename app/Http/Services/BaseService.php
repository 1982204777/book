<?php

namespace App\Http\Services;


class BaseService
{
    protected static $err_msg = null;

    protected static $err_code = null;

    public static function err($msg = '', $code = '')
    {
        self::$err_msg = $msg;
        self::$err_code = $code;
    }

    public static function getLastErrorMsg()
    {
        return self::$err_msg;
    }

    public static function getLastErrorCode()
    {
        return self::$err_code;
    }
}