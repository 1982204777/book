<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class SmsCaptcha extends Model
{

    protected $guarded = [];

    public function setCustomCaptcha($mobile, $ip = '')
    {
        $this->mobile = $mobile;
        $this->ip = $ip;
        $this->captcha = rand(10000, 99999);
        $this->expired_at = date('Y-m-d H:i:s', time() + 60 * 10);
        $this->created_at = date('Y-m-d H:i:s');
        $this->status = 0;
        //todo 如果对接了手机验证码提供商，实现发送验证码

        return $this->save();
    }
}
