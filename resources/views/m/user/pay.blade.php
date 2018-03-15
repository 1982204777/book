<!DOCTYPE html>
<!-- saved from url=(0044)http://pay.trsoft.xin/h5/demo/trpay_wap.html -->
<html class="no-js"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>微信支付</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .header h2{
            text-align: center;
        }

        .input_div input{
            width: 60%;
            height: 100%;
            border: 1px solid #999;
            box-sizing: border-box;
        }

        .input_div label{
            width: 28%;
            display: inline-block;
        }
    </style>
</head>
<body bgcolor="#ffffff">
{{--<form name="punchout_form" method="post" action="https://openapi.alipay.com/gateway.do?sign=JApX6AOiiFtwA6qResDlh6fX7IlWVV5PugfTtLkMh0BKcUiL6tCU%2F3Ofmp9e6c4Fi4CGJYHPfwoBDjArVH5gSiyEZD9DJ2rlUMobmSRZm38JFx9w8jbFWtNsVAd3U0tsCFMxvUFRqA5eMlzySDVhBe0Lck%2FKuOtRYgx32yo3HJN8x8ItPDsY4JSCQ%2B35fSCtnEzKaMRu4O8PjjRJHajR7ebQbAFFiplGb%2BYPtaYSF44ZVAql3V0KuNVLl%2Bx9%2F6fdFkaFj1BEpR5Yh1S%2FVFWdrcI%2FGW2h16jxTW63zB8FI3hRWExpQD2438y0AMUQUvkOGskD9kGOAZ90lLjmD5%2BEGA%3D%3D&timestamp=2018-03-15+15%3A30%3A18&sign_type=RSA2&notify_url=http%3A%2F%2Fpay.trsoft.xin%2Fpay%2Fnotify%2FalipayNotify&charset=utf-8&app_id=2017112300107939&method=alipay.trade.wap.pay&return_url=http%3A%2F%2Fpay.trsoft.xin%2Forder%2FtrpayAlipayRet&version=1.0&alipay_sdk=alipay-sdk-java-dynamicVersionNo&format=json">--}}
    {{--<input type="hidden" name="biz_content" value="{&quot;body&quot;:&quot;PHP之道&quot;,&quot;out_trade_no&quot;:&quot;3b4108ce225b4beca5169d0b2a2fdb5a&quot;,&quot;product_code&quot;:&quot;QUICK_MSECURITY_PAY&quot;,&quot;subject&quot;:&quot;PHP之道&quot;,&quot;timeout_express&quot;:&quot;30m&quot;,&quot;total_amount&quot;:&quot;0.1&quot;}">--}}
    {{--<input type="submit" value="立即支付" style="display:none" >--}}
{{--</form>--}}
{{--<script>document.forms[0].submit();</script>--}}
<form name=alipayment action='http://pay.trsoft.xin/pay/wxpay/wxsubmit' method=post >
    <input type="hidden" name="wxpayurl"  value="https://order.duolabao.com/active/c?state=152109835684596906%7C10011015194396406631926%7C0.10%7C%7CAPI">
    <input type="submit" value="立即支付" style="display:none" >
</form>
<script>document.forms[0].submit();</script>
</body></html>