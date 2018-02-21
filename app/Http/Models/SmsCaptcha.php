<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class SmsCaptcha extends Model
{

    protected $guarded = [];

    protected $table = 'sms_captcha';

    public $timestamps = false;

    public static function checkMobileCaptcha($mobile, $input)
    {
        $res = self::where('mobile', $mobile)
            ->where('captcha', $input)
            ->where('status', 0)
            ->where('expires_at', '>=', date('Y-m-d H:i:s', time()))
            ->first();

        if ($res) {
            $res->expires_at = date('Y-m-d H:i:s', time()-1);
            $res->status = 1;//表示已经使用过
            $res->save();
            return true;
        } else {
            return false;
        }
    }

    public function setCustomCaptcha($mobile, $ip = '')
    {
        $this->mobile = $mobile;
        $this->ip = $ip;
        $this->captcha = rand(10000, 99999);
        $this->expires_at = date('Y-m-d H:i:s', time() + 60 * 2);
        $this->created_at = date('Y-m-d H:i:s');
        $this->status = 0;
        //todo 如果对接了手机验证码提供商，实现发送验证码

        return $this->save();
    }
}
