<?php
/**
  * wechat php test
  */
require './Medoo.php';


//define your token
define("TOKEN", "wangyouquan");

$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
    public $medoo = '';
    public function __construct()
    {
        $medoo = new Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => 'book',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ]);
        $this->medoo = $medoo;
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
    //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$xml_data = file_get_contents("php://input");
      	//extract post data
		if (!empty($xml_data)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
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
                        $kw = trim($xml_obj->Content);
                        $res = $this->search($kw);
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
                    echo $this->richTpl($from_username, $to_username, $res['data']);
                    break;
                default:
                    echo $this->textTpl($from_username, $to_username, $res['data']);
            }
        } else {
        	echo "success";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
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

    private function search($kw)
    {
        $medoo = $this->medoo;
        $res = $medoo->select("books", "*", [
            "OR" => [
                "name[~]" => $kw,
                "tags[~]" => $kw
            ]
        ]);

        if ($res) {
            $data = $this->getRichXml($res);
            $type = 'rich';
        } else {
            $data = $this->defaultTip();
            $type = 'text';
        }

        return ['type' => $type, "data" => $data];
    }

    public function parseEvent( $dataObj ){
        $resType = "text";
        $resData = $this->defaultTip();
        $event = $dataObj->Event;
        $event_key = $dataObj->EventKey;
        switch($event){
            case "subscribe":
                $resData = $this->subscribeTips();

                if ($event_key) {
                    $qrcode_key = str_replace('qrscene_', '', $event_key);
                    $this->medoo->update('market_qrcode', [
                        'total_scan_count[+]' => 1,
                    ], [
                        'id' => $qrcode_key
                    ]);

                    $this->medoo->insert('qrcode_scan_history', [
                        'openid' => strval($dataObj->FromUserName),
                        'qrcode_id' => $qrcode_key,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                break;
            case "CLICK"://自定义菜单点击类型是CLICK的，可以回复指定内容
                $eventKey = trim($dataObj->EventKey);
                switch($eventKey){
                }
                break;
            default:
                $qrcode_key = str_replace('qrscene_', '', $event_key);
                $this->medoo->update('market_qrcode', [
                    'total_scan_count[+]' => 1,
                ], [
                    'id' => $qrcode_key
                ]);
                $resData = $this->subscribeTips();;
        }
        return [ 'type'=>$resType,'data'=>$resData ];
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
            $tmp_description = mb_substr(strip_tags($item['summary']), 0, 20, 'utf-8');
            $tmp_pic_url = 'http://' . $_SERVER['HTTP_HOST'] . '/storage/' . $item['main_img'];
            $tmp_url = 'http://' . $_SERVER['HTTP_HOST'] . '/m/product/info?id=' . $item['id'];
            $article_content .= "
<item>
<Title><![CDATA[{$item['name']}]]></Title>
<Description><![CDATA[{$tmp_description}]]></Description>
<PicUrl><![CDATA[{$tmp_pic_url}]]></PicUrl>
<Url><![CDATA[{$tmp_url}]]></Url>
</item>";
        }

        $article_body = "<ArticleCount>%s</ArticleCount>
<Articles>
%s
</Articles>";

        return sprintf($article_body, $article_count, $article_content);
    }
}


