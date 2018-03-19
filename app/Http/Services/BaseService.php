<?php

namespace App\Http\Services;


class BaseService
{
    protected static $err_msg = null;

    protected static $err_code = null;

    public static function err($msg = '', $code = -1)
    {
        if ($msg) {
            self::$err_msg = $msg;
        } else {
            self::$err_msg = '操作失败';
        }
        self::$err_code = $code;

        return false;
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