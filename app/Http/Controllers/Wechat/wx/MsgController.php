<?php

namespace App\Http\Controllers\Wechat\wx;

use App\Http\Controllers\Controller;
use App\Http\Models\Book;
use App\Http\Models\MarketQrCode;
use App\Http\Models\QrCodeScanHistory;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MsgController
{
    public $token = 'wangyouquan';
    public function index()
    {
        if( !$this->checkSignature() ){
            $this->record_log( "校验错误" );
            //可以直接回复空串，微信服务器不会对此作任何处理，并且不会发起重试
            return 'error signature ~~';
        }

        if( array_key_exists('echostr',$_GET) && $_GET['echostr']){//用于微信第一次认证的
            return $_GET['echostr'];
        }
        // 获取post的xml数据
        // 因为很多都设置了register_globals禁止， 不能使用$_GLOBALS['HTTP_RAW_POST_DATA']
        $xml_data = file_get_contents("php://input");
        if (!$xml_data) {
            return 'error xml~~~';
        }
        $this->record_log($xml_data);
        $xml_obj = simplexml_load_string($xml_data, 'SimpleXMLElement', LIBXML_NOCDATA);
        $from_username = $xml_obj->FromUserName;
        $to_username = $xml_obj->ToUserName;
        $msg_type = $xml_obj->MsgType;//信息类型

        $res = [
            'type' => 'text',
            'data' => $this->defaultTip()
        ];
        switch ( $msg_type ){
            case "text":
                if($xml_obj->Content == "商城账号") {
                    $res = [ 'type'=>'text','data'=> '用户名：admin，密码：123456' ];
                } else {
                    $kw = trim( $xml_obj->Content );
                    $res = $this->search( $kw );
                }
                break;
            case "event":
                $res = $this->parseEvent( $xml_obj );
                break;
            default:
                break;
        }


        switch($res['type']) {
            case "rich":
                return $this->richTpl($from_username, $to_username, $res['data']);
                break;
            default:
                return $this->textTpl($from_username, $to_username, $res['data']);
        }
    }


    public function checkSignature(){
        $signature = trim(request()->get("signature",""));
        $timestamp = trim(request()->get("timestamp",""));
        $nonce = trim(request()->get("nonce",""));
        $tmpArr = array('wangyouquan', $timestamp, $nonce );
        sort($tmpArr,SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if ( $tmpStr ==  $signature ) {
            return true;
        } else{
            return false;
        }
    }

    /**
     * 默认回复语
     */
    private function defaultTip()
    {
        $data = <<<EOT
没找到你要的东西：(\n
EOT;
        return $data;
    }

    /**
     * 关注默认提示
     */
    private function subscribeTips(){
        $resData = <<<EOT
感谢您关注随缘的公众号
输入关键字,可以搜索商品哦,
[商城账号]获取商城账号
EOT;

        return $resData;
    }

    private function returnTips(){
        $resData = <<<EOT
HI,好久不见
输入关键字,可以搜索商品哦,
[商城账号]获取商城账号
EOT;

        return $resData;
    }

    private function search($kw)
    {
        $query = Book::query();
        $res = $query->where('name', 'like', '%' . $kw . '%')
            ->orWhere('tags', 'like', '%' . $kw . '%')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();
        if ($res->isNotEmpty()) {
            $data = $this->getRichXml($res);
            $type = 'rich';
        } else {
            $data = $this->defaultTip();
            $type = 'text';
        }

        return ['type' => $type, "data" => $data];
    }

    public function parseEvent($dataObj)
    {
        $resType = "text";
        $resData = $this->defaultTip();
        $event = $dataObj->Event;
        $event_key = $dataObj->EventKey;
        switch($event){
            case "subscribe":
                $resData = $this->subscribeTips();

                if ($event_key) {
                    $qrcode_key = str_replace('qrscene_', '', $event_key);
                    $qrcode = MarketQrCode::find($qrcode_key);
                    $qrcode->total_scan_count += 1;
                    $qrcode->save();

                    $qrcode_scan_histoty = new QrCodeScanHistory();
                    $qrcode_scan_histoty->openid = strval($dataObj->FromUserName);
                    $qrcode_scan_histoty->qrcode_id = $qrcode_key;
                    $qrcode_scan_histoty->created_at = date('Y-m-d H:i:s');
                    $qrcode_scan_histoty->save();
                }
                break;
            case "CLICK"://自定义菜单点击类型是CLICK的，可以回复指定内容
                $eventKey = trim($dataObj->EventKey);
                switch($eventKey){
                }
                break;
            default:
                $qrcode_key = str_replace('qrscene_', '', $event_key);
                $qrcode = MarketQrCode::find($qrcode_key);
                $qrcode->total_scan_count += 1;
                $qrcode->save();
                $resData = $this->returnTips();;
        }
        return [ 'type'=>$resType,'data'=>$resData ];
    }

    private function textTpl($from_username, $to_username, $content)
    {
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>0</FuncFlag>
        </xml>";

        return sprintf($textTpl, $from_username, $to_username, time(), "text", $content);
    }
    /*
     *富文本
     */
    private function richTpl( $from_username ,$to_username,$data){
        $tpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
%s
</xml>
EOT;
        return sprintf($tpl, $from_username, $to_username, time(), $data);
    }

    private function getRichXml($list)
    {
        $article_count = count($list);
        $article_content = '';
        foreach ($list as $item) {
            $tmp_description = mb_substr(strip_tags($item->summary), 0, 20, 'utf-8');
            $tmp_pic_url = request()->getHttpHost() . '/storage/' . $item->main_img;
            $tmp_url = request()->getHttpHost() . '/m/product/info?id=' . $item->id;
            $article_content .= "
            <item>
<Title><![CDATA[{$item->name}]]></Title>
<Description><![CDATA[{$tmp_description}]]></Description>
<PicUrl><![CDATA[{$tmp_pic_url}]]></PicUrl>
<Url><![CDATA[{$tmp_url}]]></Url>
</item>";
        }
        $article_body = "
        <ArticleCount>%s</ArticleCount>
<Articles>
%s
</Articles>";

        return sprintf($article_body, $article_count, $article_content);
    }


    public function record_log($msg)
    {
        $request_uri = request()->getRequestUri();
        $post_data = request()->post();
        $log = [
            "[url:{$request_uri}][post:" . http_build_query($post_data) . "][msg:$msg]",
            1,
            'application',
            microtime(true)
        ];
        $log_obj = new Logger('wechat-msg');
        $log_obj->pushHandler(new StreamHandler(storage_path('logs/wechat/wechat_msg_' . date('Y-m-d') . '.log')), Logger::INFO);
        $log_obj->info('wechat-msg', $log);
    }

}
