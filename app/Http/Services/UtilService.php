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

    public static function isWechat(){
        $ug= isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
        if( stripos($ug,'micromessenger') !== false ){
            return true;
        }
        return false;
    }
}