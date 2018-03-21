<?php

namespace App\Http\Services\wechat;


use App\Http\Models\Member;
use App\Http\Models\OauthMemberBind;
use App\Http\Models\order\PayOrder;
use App\Http\Models\order\PayOrderItem;
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

    /**
     * 微信绑定通知提醒
     */
    public static function bindNotice($member_id)
    {
        $member_info  = Member::find($member_id);
        if (!$member_info) {
            return false;
        }

        RequestService::setApp();
        $open_id = self::getOpenId($member_id);
        if(!$open_id){
            return false;
        }

        $template_id = env('WECHAT_BIND_TEMPLATE_ID');
        $url = url('m/home');
        $data = [
            "first" => [
                "value" => "您好，您已注册并成功绑定微信",
                "color" => "#173177"
            ],
            "keyword1" => [
                "value" => $member_info->mobile,
                "color" => "#173177"
            ],
            "keyword2" => [
                "value" => date("Y-m-d H:i", strtotime($member_info->created_at)),
                "color" => "#173177"
            ],
            "remark" => [
                "value" => "感谢您支持" . config('common.wechat_title'),
                "color" => "#173177"
            ]
        ];

        return self::send($open_id, $template_id, $url,$data);
    }

    /**
     * 发货通知提醒
     */
    public static function expressNotice($pay_order_id)
    {
        $pay_order_info = PayOrder::find($pay_order_id);
        if( !$pay_order_info ){
            return self::err( "订单不存在~~" );
        }

        $pay_order_items = PayOrderItem::where('pay_order_id', $pay_order_id)
                ->with('book')
                ->get()
                ->toArray();
        if (!$pay_order_items) {
            return self::err( "订单不存在~~" );
        }

        RequestService::setApp();

        $open_id = self::getOpenId($pay_order_info->member_id);
        if (!$open_id){
            return self::err( "openid 没找到~~" );
        }

        $template_id = env('WECHAT_EXPRESS_TEMPLATE_ID');
        $pay_money = $pay_order_info->pay_price;
        $book_items = [];
        foreach ($pay_order_items as $_pay_order_item_info) {
            $book_items[] = $_pay_order_item_info['book']['name'];
        }
        $url = url('m/user/order');

        $data = [
            "first" => [
                "value" => "您的订单已经标记发货，请留意查收",
                "color" => "#173177"
            ],
            "keyword1" =>[
                "value" => $pay_money,
                "color" => "#173177"
            ],
            "keyword2" =>[
                "value" => implode(",",$book_items),
                "color" => "#173177"
            ],
            "keyword3" =>[
                "value" => $pay_order_info->order_sn,
                "color" => "#173177"
            ],
            "remark" => [
                "value" => "快递信息：" . $pay_order_info['express_info'],
                "color" => "#173177"
            ]
        ];

        return self::send($open_id, $template_id, $url, $data);
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