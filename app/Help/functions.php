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