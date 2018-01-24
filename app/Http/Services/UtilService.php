<?php

namespace App\Http\Services;


class UtilService
{
    public static function getIP()
    {
        if (!empty($_SERVER['HTTP_X_FORWARD_FOR'])) {
            return $_SERVER['HTTP_X_FORWARD_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}