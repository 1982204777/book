<?php

namespace App\Http\Services\trpay;


use App\Http\Models\order\PayOrder;
use Illuminate\Support\Facades\DB;

class PayApiService
{
    private $params = [];

    public function setParameter($parameter, $parameterValue)
    {
        $this->params[$parameter] = $parameterValue;
    }

    public function getSignParams()
    {
        $this->params['sign'] = $this->getSign($this->params);

        return $this->params;
    }

    private function getSign($params)
    {
        foreach ($params as $key => $param) {
            $parameters[$key] = $param;
        }
        ksort($parameters);
        $String = $this->formatBizQueryParaMap($parameters, false);
        $String = $String."&appSceret=". env('TRPAY_APP_SECRET');
        $String = md5($String);
        $result = strtoupper($String);

        return $result;
    }

    /**
     *  作用：格式化参数，签名过程需要使用
     */
    private function formatBizQueryParaMap($paraMap, $urlencode){
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v){
            if($urlencode){
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0){
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }

    public function checkSign($sign)
    {
        $tmpData = $this->params;
        $wxpay_sign = $this->getSign($tmpData);//本地签名

        if ($wxpay_sign == $sign) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     *  作用：设置jsapi的参数
     */
    public function getPublicParameters(){
        $timeStamp = time();
        $public_parameters["timeStamp"] = $timeStamp;
        $public_parameters["method"] = "trpay.trade.create.wap";
        $public_parameters["app_key"] = env('TRPAY_APP_KEY');
        $public_parameters["version"] = "1.0";
        $public_parameters["sign"] = $this->getSign($public_parameters);

        return $public_parameters;
    }
}