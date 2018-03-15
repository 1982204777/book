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

/**
 * 对发送post请求方法进行封装
 * @param $postUrl
 * @param $data
 * @return array
 */
function post($postUrl, $data)
{
    //初始化curl
    $ch = curl_init();
    //抓取指定网页
    curl_setopt($ch, CURLOPT_URL,$postUrl);
    //设置header
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //post提交方式
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //运行curl
    $res= curl_exec($ch);
    curl_close($ch);

    return $res;
}
