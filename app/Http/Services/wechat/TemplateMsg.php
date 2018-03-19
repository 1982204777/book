<?php

namespace App\Http\Services\wechat;


use App\Http\Models\OauthMemberBind;
use App\Http\Models\order\PayOrder;
use App\Http\Services\BaseService;

class TemplateMsg extends BaseService
{
    public static function payNotice($pay_order_id)
    {
        $pay_order = PayOrder::find($pay_order_id);
        if (!$pay_order) {
            return false;
        }

        RequestService::setApp();
        $openid = self::getOpenid($pay_order->member_id);
        if (!$openid) {
            return false;
        }
        $template_id = env('WECHAT_PAY_TEMPLATE_ID');
        $url = url('m/user/order');
        $data = [
            "first" => [
                "value" => "您的订单已支付成功",
                "color" => "#173177"
            ],
            "keyword1" =>[
                "value" => $pay_order->order_sn,
                "color" => "#173177"
            ],
            "keyword2" =>[
                "value" => date("Y-m-d H:i",strtotime( $pay_order->pay_time)),
                "color" => "#173177"
            ],
            "keyword3" =>[
                "value" => $pay_order->pay_price,
                "color" => "#173177"
            ],
            "remark" => [
                "value" => "点击查看详情",
                "color" => "#173177"
            ]
        ];

        return self::send($openid, $template_id, $url, $data);
    }

    private static function getOpenid($member_id)
    {
        $oauth_member_bind_list = OauthMemberBind::where('member_id', $member_id)
                ->get()
                ->toArray();
        foreach ($oauth_member_bind_list as $item) {
            if (self::getPublicByOpenid($item['openid'])) {
                return $item['openid'];
            }
        }

        return false;
    }

    /*
     *判断用户是否关注了公众号
     */
    private static function getPublicByOpenid($open_id)
    {
        $access_token = RequestService::getAccessToken();
        $res = RequestService::send("user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN");
        if (!$res || isset($res['errcode'])) {
            return false;
        }
        if ($res['subscribe']) {
            return true;
        }

        return false;
    }

    private static function send($openid, $template_id, $url, $data)
    {
        $send_data = [
            'touser' => $openid,
            'template_id' => $template_id,
            'url' => $url,
            'data' => $data
        ];
        $access_token = RequestService::getAccessToken();
        RequestService::send("message/template/send?access_token={$access_token}", json_encode($send_data), 'POST');
    }
}