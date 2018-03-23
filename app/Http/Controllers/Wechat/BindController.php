<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Models\Member;
use App\Http\Models\OauthMemberBind;
use App\Http\Models\SmsCaptcha;
use App\Http\Services\captcha\ValidateCode;
use App\Http\Services\ConstantMapService;
use App\Http\Services\QueueListService;
use App\Http\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BindController extends BaseController
{
    private $img_captcha_cookie_name = 'img_captcha';

    public function index()
    {
        return view('m/bind');
    }

    public function bind(Request $request)
    {
        $input = $request->input();
        $mobile = array_get($input, 'mobile', '');
        $img_captcha = array_get($input, 'img_captcha', '');
        $mobile_captcha = array_get($input, 'mobile_captcha', '');
        if (!$mobile || !preg_match('/^1[0-9]{10}$/', $mobile)) {
            return ajaxReturn('请输入符合规范的手机号码~~~');
        }
        //检验图片验证码输入是否正确
        if ($msg = $this->checkImgCaptcha($img_captcha)) {
            return ajaxReturn($msg);
        }
        if (!$mobile_captcha) {
            return ajaxReturn('请输入手机验证码~~~');
        }
        if (!SmsCaptcha::checkMobileCaptcha($mobile, $mobile_captcha)) {
            return ajaxReturn('请输入正确的手机验证码~~~');
        }

        $member = Member::where('mobile', $mobile)
                ->where('status', 1)
                ->first();
        if (!$member) {
            if (Member::where('mobile', $mobile)->first()) {
                //账号被禁止
                return ajaxReturn('您的账号已被禁止，请联系客服解决~~~', -1);
            }
//            注册会员
            $member_model = new Member();
            $member_model->nickname = $mobile;
            $member_model->mobile = $mobile;
            $member_model->avatar = config('common.default_avatar');
            $member_model->salt = getSalt();
            $member_model->reg_ip = UtilService::getIP();
            $member_model->status = 1;
            $member_model->save();

            $member = $member_model;
        }

        $openid = $this->getCookie($this->auth_cookie_current_openid);

        if ($openid) {
            $bind_info = OauthMemberBind::where('member_id', $member->id)
                    ->where('openid', $openid)
                    ->where('type', ConstantMapService::$client_type_wechat)
                    ->first();

            if(!$bind_info){
                $model_bind = new OauthMemberBind();
                $model_bind->member_id = $member->id;
                $model_bind->type = ConstantMapService::$client_type_wechat;
                $model_bind->client_type = "weixin";
                $model_bind->openid = $openid;
                $model_bind->unionid = '';
                $model_bind->extra = '';
                $model_bind->save();
                //绑定之后要做的事情
                QueueListService::addQueue( "bind", [
                    'member_id' => $model_bind->member_id,
                    'type' => 1,
                    'openid' => $model_bind->openid
                ]);
                //队列发送模板消息
                $this->dispatch(new \App\Jobs\SendMessage());
            }
        }

        if (UtilService::isWechat() && $member->nickname == $member->mobile) {
            return ajaxReturn('绑定成功~~~', 2);
        }
        //设置登录态
        $this->setLoginStatus($member);
        return ajaxReturn("绑定成功~~~", 1);
    }

    public function getCaptcha(Request $request)
    {
        $mobile = $request->input('mobile', '');
        $img_captcha = $request->input('img_captcha', '');
        if (!$mobile || !preg_match('/^1[0-9]{10}$/', $mobile)) {
            Cookie::queue(Cookie::forget($this->img_captcha_cookie_name));
            return ajaxReturn("请输入符合规范的手机号码~~~");
        }

        //检验图片验证码输入是否正确
        if ($msg = $this->checkImgCaptcha($img_captcha)) {
            return ajaxReturn($msg);
        }

        //发送手机验证码，能发验证码，能验证

        $model_sms = new SmsCaptcha();
        $model_sms->setCustomCaptcha($mobile, UtilService::getIP());
        if ($model_sms) {
            return response([
                'msg' => "发送成功~~，手机验证码是" . $model_sms->captcha . '，过期时间两分钟~',
                'code' => 0
            ]);
        }

        return ajaxReturn('发送失败~~~', -1);
    }

    /**
     * 生成图片验证码
     * @return mixed
     */
    public function setImgCaptcha()
    {
        $font_path = base_path() . '/public/fonts/captcha.ttf';
        $captcha_handle = new ValidateCode($font_path);
        $captcha_handle->doimg();
        $cookie = cookie($this->img_captcha_cookie_name, $captcha_handle->getCode(), 1440);

        return response('success')->cookie($cookie);
    }


    /**
     * 检验图片验证码
     * @param $img_captcha
     * @return string
     */
    public function checkImgCaptcha($img_captcha)
    {
        $captcha_code = Cookie::get($this->img_captcha_cookie_name);
        if (!$captcha_code) {
            $msg = '请重新获取图片验证码~~~';
            return $msg;
        }
        if (strtolower($img_captcha) != $captcha_code) {
            Cookie::queue(Cookie::forget($this->img_captcha_cookie_name));
            $msg = "请输入正确图形校验码\r\n你输入的图形验证码是{$img_captcha},正确的是{$captcha_code}~~~";
            return $msg;
        }

        return false;
    }

}
