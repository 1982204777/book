<?php

namespace App\Http\Services;


use App\Http\Models\AppAccessLog;

class AppLogService
{
    public static function addAppAccessLog($uid = 0)
    {
        $get_params = request()->get('.');
        $post_params = request()->post('.');
        $get_params = $get_params ? $get_params : [];
        $post_params = $get_params ? $post_params : [];
        $target_url = request()->getRequestUri();
        $referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '';
        $ua = request()->userAgent();

        $app_access_log = new AppAccessLog();

        $app_access_log->uid = $uid;
        $app_access_log->referer_url = $referer;
        $app_access_log->target_url = $target_url;
        $app_access_log->query_params = json_encode(array_merge($get_params, $post_params));
        $app_access_log->ua = $ua;
        $app_access_log->ip = UtilService::getIP();

        return $app_access_log->save();
    }
}