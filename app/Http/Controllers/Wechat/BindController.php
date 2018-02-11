<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\SmsCaptcha;
use App\Http\Services\captcha\ValidateCode;
use App\Http\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BindController
{
    private $captcha_cookie_name = 'validate_code';

    public function bind()
    {
        return view('m/bind');
    }

    public function getCaptcha(Request $request)
    {
        $mobile = $request->input('mobile', '');
        $img_captcha = $request->input( 'img_captcha', '');
        if(!$mobile || !preg_match('/^1[0-9]{10}$/', $mobile)){
            dd('nooo');
            \cookie($this->captcha_cookie_name, '', -100);
            return ajaxReturn("请输入符合要求的手机号码~~~");
        }

        $captcha_code = \cookie($this->captcha_cookie_name);
        if(strtolower($img_captcha) != $captcha_code){
            \cookie($this->captcha_cookie_name, '', -100);
            return ajaxReturn("请输入正确图形校验码\r\n你输入的图形验证码是{$img_captcha},正确的是{$captcha_code}~~~");
        }

        //发送手机验证码，能发验证码，能验证

        $model_sms = new SmsCaptcha();
        $model_sms->setCustomCaptcha( $mobile ,UtilService::getIP() );
        \cookie( $this->captcha_cookie_name, '', -100);
        if ($model_sms) {
            return ajaxReturn("发送成功~~，手机验证码是" . $model_sms->captcha);
        }

        return ajaxReturn('发送失败~~~', -1);
    }

    public function setImgCaptcha()
    {
        $font_path = base_path() . '/public/fonts/captcha.ttf';
        $captcha_handle = new ValidateCode($font_path);
        $captcha_handle->doimg();
        Cookie::queue($this->captcha_cookie_name, $captcha_handle, 0);
    }

}