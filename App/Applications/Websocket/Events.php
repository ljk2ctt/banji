<?php

/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

//namespace Applications\Websocket;
use \GatewayWorker\Lib\Gateway;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events {

    const API_TOKEN = 'kanubanji';
    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     * 
     * 链接session  
     *          token 当前链接的token
     *          connect_mode 当前链接方式  weixin 电脑 app 等  用于踢下线使用
     *          now_interface 当前正在访问的接口  当前留在哪个页面
     * 
     * 
     * 
     */
    public static function onConnect($client_id) {        
//        Gateway::sendToClient($client_id ,  json_encode($client_id));
    }
    
    /**
     * 
     * @param type $client_id
     * @param type $message
     * return msgtype reply  回复请求通知   change 更新接口通知   willoffline  即将断线通知
     */
    public static function onMessage($client_id, $message) {
        // 向所有人发送 
        $message = json_decode($message, true);
        $return['msgtype']='reply';
        //回复请求的消息
        if (isset($message['interface']) && isset($message['data'])) {
            $interface = $message['interface'];
            $return['interface']=$interface;
            $data = $message['data'];
            //链接方式 默认微信里的链接
            $connect_mode=isset($data['connect_mode'])?$data['connect_mode']:'weixin';
            if($interface!='ulogin' && $interface!='upload' && $interface!='getopenid')
            {
                //自动传入绑定token
                $session=Gateway::getSession($client_id);
                if(isset($session['token']))
                {
                    $data['token']=  $session['token'];
                }                
                if(!isset($data['sign']))
                {
                    //一些接口如果没穿签名 帮助签名
                    $data['sign']=self::getSign($data);
                }
            }
            if(false===$api_return=  self::cpost($interface,$data))
            {
                $return['data']=  self::error('curl error');
                Gateway::sendToClient($client_id, json_encode($return));
            }
            $api_return = json_decode($api_return, true);
            $return['data']=$api_return;
            Gateway::sendToClient($client_id, json_encode($return));
        }
        //来至服务器的需要广播的信息
        elseif(isset($message['interfaces']) && isset($message['tokens']))
        {   
            $tokens=$message['tokens'];
            if(!empty($tokens) && !empty($message['interfaces']))
            {
                $change_return['msgtype']='change';
                $change_return['interfaces']=$message['interfaces'];
                foreach($tokens as $token)
                {
                    $other_client_ids=Gateway::getClientIdByUid($token);
                    if(!empty($other_client_ids))
                    {
                        foreach($other_client_ids as $other_client_id)
                        {
                            if(Gateway::isOnline($other_client_id))
                            {
                                Gateway::sendToClient($other_client_id, json_encode($change_return));
                            }
                        }
                    }
                }
            }
            //关闭当前连接
            Gateway::closeClient($client_id);
        }
        //来至服务器的循环发送模板消息的信息
        elseif(isset($message['send_temp_message']))
        {
            $send_temp_message=$message['send_temp_message'];
            if(!empty($send_temp_message))
            {
                $WxMessage=new \Lib\Message();
                foreach($send_temp_message as $send_data)
                {
                    list($send, $args, $openid, $url)=$send_data;
                    if(false===$WxMessage->send($send, $args, $openid, $url))
                    {
                        echo $WxMessage->getError()."\n";
                        var_dump($send_data);
                    }
                }
            }
            //关闭当前连接
            Gateway::closeClient($client_id);
        }
        //来自服务器需要踢人下线的信息
        elseif(isset($message['willoffline']))
        {
            $token=$message['willoffline']['token'];
            $connect_mode=$message['willoffline']['connect_mode'];
            $websocket_key  =   $message['willoffline']['websocket_key'];
            //key为键值 链接方式为值
            \Lib\Cache::put($token.$connect_mode, $websocket_key);
            $client_ids=Gateway::getClientIdByUid($token);
            if(!empty($client_ids))
            {
                foreach($client_ids as $one_client_id)
                {
                    if($one_client_id!=$client_id)
                    {
                        $one_session= Gateway::getSession($one_client_id);
                        if(isset($one_session['connect_mode']) && $one_session['connect_mode']==$connect_mode && Gateway::isOnline($one_client_id))
                        {
                            //下线通知
                            $offline_return['msgtype']='willoffline';
                            Gateway::sendToClient($one_client_id, json_encode($offline_return));
                            Gateway::closeClient($one_client_id);
                        }
                    }
                }
            }
        }
        //客户端建立链接绑定链接 token
        elseif(isset($message['bind']))
        {
            $token=$message['bind']['token'];
            $websocket_key=$message['bind']['websocket_key'];
            if(isset($message['bind']['connect_mode']))
            {
                $connect_mode=$message['bind']['connect_mode'];
            }
            else{
                $connect_mode='weixin';
            }
            //key为键值 链接方式为值
            $cache_websocket_key=\Lib\Cache::get($token.$connect_mode);
            if(false===$cache_websocket_key || $cache_websocket_key!=$websocket_key)
            {
                //没查找到缓存 关闭链接
                $offline_return['msgtype']='willoffline';
                Gateway::sendToClient($client_id, json_encode($offline_return));
                Gateway::closeClient($client_id);
                return;
            }
            //是有效的token 建立链接 否则不处理 其他踢下线
            //token 作为uid绑定
            Gateway::bindUid($client_id,$token);
            $session['token']=$token;
            $session['connect_mode']=$connect_mode;
            Gateway::setSession($client_id, $session);
            
        }
        else
        {
            Gateway::sendToClient($client_id, 'unvalid data');
        }
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id) {
//        Gateway::sendToALL(json_encode($client_id .'断了'));
    }

    private static function cpost($url, $param, $post_file = '') {
        //:todo修改到配置中
        $url=$GLOBALS['CFG']['WEB_DOMAIN'].'api.php?'.$url;
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            echo date('Y-m-d H:i:s').'curl error\n';
            echo $sContent;
            return false;
        }
    }

    private static function getSign($data) {
        ksort($data);
        $buff='';
        foreach ($data as $k => $v) {
//            $v = urlencode($v);
            $buff .= $k . "=" . $v . "&";
        }
        return md5($buff . self::API_TOKEN);
    }
    private static function success($msg)
    {
        $data['msg'] = $msg;
        $data['status'] = 1;
        return json_encode($data);
    }
    private static function error($msg)
    {
        $data['msg'] = $msg;
        $data['status'] = 0;
        return json_encode($data);
    }

}
