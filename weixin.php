<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "xuexigu");
$wechatObj = new wechatCallbackapiTest();
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
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>"; 
        $event = $postObj->Event;
        if($event==subscribe){
          $textTpl = "<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[news]]></MsgType>
              <ArticleCount>2</ArticleCount>
              <Articles>
              <item>
              <Title><![CDATA[欢迎关注学习谷微信]]></Title> 
              <Description><![CDATA[学习谷教育株式会社四大校区]]></Description>
              <PicUrl><![CDATA[http://120.24.7.144/weixin/test.JPEG]]></PicUrl>
              <Url><![CDATA[http://www.xuexigu.cn]]></Url>
              </item>
              <item>
              <Title><![CDATA[欢迎关注学习谷微信]]></Title> 
              <Description><![CDATA[学习谷教育株式会社四大校区]]></Description>
              <PicUrl><![CDATA[http://120.24.7.144/weixin/test.JPEG]]></PicUrl>
              <Url><![CDATA[http://www.xuexigu.cn]]></Url>
              </item>
              </Articles>
              </xml>"; 




          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
                  echo $resultStr;
        }
        



				if(!empty( $keyword ))
                {
              		$msgType = "text";
                    
                    switch ($keyword) {
                        case '1':
                           $contentStr = "日语基础课程";
                            break;
                         case '2':
                           $contentStr = "劳务派遣";
                            break;
                         case '图文':
                           $textTpl = "<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[news]]></MsgType>
              <ArticleCount>2</ArticleCount>
              <Articles>
              <item>
              <Title><![CDATA[欢迎关注学习谷微信]]></Title> 
              <Description><![CDATA[学习谷教育株式会社四大校区]]></Description>
              <PicUrl><![CDATA[http://120.24.7.144/weixin/test.JPEG]]></PicUrl>
              <Url><![CDATA[http://www.xuexigu.cn]]></Url>
              </item>
              <item>
              <Title><![CDATA[欢迎关注学习谷微信]]></Title> 
              <Description><![CDATA[学习谷教育株式会社四大校区]]></Description>
              <PicUrl><![CDATA[http://120.24.7.144/weixin/test.JPEG]]></PicUrl>
              <Url><![CDATA[http://www.xuexigu.cn]]></Url>
              </item>
              </Articles>
              </xml>"; 




          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
                  echo $resultStr;


                            break;
                        
                          case '首页':
                           $contentStr = "【学校简介】【日语课程】【vip企培】
                           ";
                            break;
                           
                        default:
                             $contentStr = "日语基础课程回复1，劳务派遣回复2";
                            break;
                    }
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
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
}

?>