<?php
function normalReturn($message, $url)
{
    return "<script>alert('{$message}');window.location.href='{$url}'</script>";
}

function ajaxReturn($message, $code = 0)
{
    $arr = [
        'msg' => $message,
        'code' => $code
    ];

    return $arr;
}

function getSalt($length = 16)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()_+';
    $salt = '';
    for ($i = 0; $i < $length; $i++) {
        $salt .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $salt;
}

function makeImgUrl($img_key)
{
    return '/storage/' . $img_key;
}