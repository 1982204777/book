<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "wangyouquan");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
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

            if($xml_obj->Content == "商城账号") {
                $res = '用户名：admin，密码：123456';
            } else {
                $res = $this->defaultTip();
            }
                echo $this->textTpl($from_username, $to_username, $res);

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
                        $res = $this->search( $kw );
                    }
                    break;
                case "event":
//                $res = $this->parseEvent( $xml_obj );
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
        $query = \App\Http\Models\Book::query();
        $res = $query->where('name', 'like', '%' . $kw . '%')
            ->orWhere('tags', 'like', '%' . $kw . '%')
            ->orderBy('id', 'desc')
            ->limit(3)
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
    private function richTpl($from_username, $to_username, $content)
    {
        $rich_tpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
%s
</xml>
EOT;
        return sprintf($rich_tpl, $to_username, $from_username, time(), $content);

    }

    private function getRichXml($list)
    {
        $article_count = count($list);
        $article_content = '';
        foreach ($list as $item) {
            $tmp_description = mb_substr(strip_tags($item->summary), 0, 20, 'utf-8');
            $tmp_pic_url = request()->getHttpHost() . '/storage/' . $item->main_img;
            $tmp_url = request()->getHttpHost() . '/admin/book/' . $item->id;
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
}

?>
