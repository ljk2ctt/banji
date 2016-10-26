<?php
function getencrypt($pwd, $encrypt_key) {//加密
    if (empty($pwd) or empty($encrypt_key)) {
        return false;
    }
    return md5(md5($pwd) . $encrypt_key);
}
function date2($time, $f = 'Y-m-d H:i:s') {
    if (empty($time))
        return '';
    return date($f, $time);
}
/**
 * 验证多字段不同时为空
 */
function checkmultrequireone($args) {
    foreach ($args as $arg) {
        if (!empty($arg)) {
            return;
        }
    }
    return false;
}
/**
 * 删除空格
 * @param type $str
 * @return type
 */

function trimall($str) {
    $qian = array(" ", "　", "\t", "\n", "\r");
    $hou = array("", "", "", "", "");
    return str_replace($qian, $hou, $str);
}

function zero2null($num) {
    if (empty($num)) {
        return '';
    }
    return $num;
}



function curl_get_contents($url) {
    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 5);
    $result = curl_exec($curlHandle);
    curl_close($curlHandle);
    return $result;

}



function curl_post_contents($url, $param, $post_file = false) {
    $oCurl = curl_init();
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
        return false;
    }
}

function xml_to_array($xml) {
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if (preg_match_all($reg, $xml, $matches)) {
        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $subxml = $matches[2][$i];
            $key = $matches[1][$i];
            if (preg_match($reg, $subxml)) {
                $arr[$key] = xml_to_array($subxml);
            } else {
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}

/**
 * 交换数组键/值 重复组成数组
 */
function array_myflip($array) {
    $new_array = array();
    foreach ($array as $k => $v) {
        $new_array[$v][] = $k;
    }
    return $new_array;
}


function str_len($str, $len) {
    $str_len = strlen($str);
    return $str_len <= $len;
}

/**
 * 检测是否微信浏览器
 * @return boolean
 */

function checkwxbrowser() {
    if (strpos(I('server.HTTP_USER_AGENT'), 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}
function lunar($time=NOW_TIME){    
    $Lunar  = new \Lib\Lunar();   
    $Y=date('Y',$time);
    $m=date('m',$time);
    $d=date('d',$time);
    $lunars=$Lunar->convertSolarToLunar($Y,$m,$d);
    return $lunars[0].$lunars[1].$lunars[2].$lunars[3];
}

/**
 * 验证电话号码格式
 */
function checkTelFormat($tel)
{
    if(false!==checkPhoneFormat($tel))
    {
        return true;   
    }
    //验证是不是座机格式 验证'-'后必须是8位
    if(false===strpos($tel,'-'))
    {
        list($quhao,$dianhua)=array('',$tel);
    }
    else
    {
        list($quhao,$dianhua)=  explode('-', $tel);
    }
    $quhao_len=  strlen($quhao);
    for($i=0;$i<$quhao_len;++$i)
    {
        if(!in_array($quhao{$i},array('1','2','3','4','5','6','7','8','9','0')))
        {
            return false;
        }
    }
    $dianhua_len=  strlen($dianhua);
    if(8!=$dianhua_len)
    {
        return false;
    }
    for($i=0;$i<$dianhua_len;++$i)
    {
        if(!in_array($dianhua{$i},array('1','2','3','4','5','6','7','8','9','0')))
        {
            return false;
        }
    }
    
    return true;
}

/**
 * 验证手机
 */
function checkPhoneFormat($phone)
{
    if(strlen($phone)!=11)
    {
        return false;
    }
    if($phone{0}!='1')
    {
        return false;
    }
    for($i=0;$i<11;++$i)
    {
        if(!in_array($phone{$i},array('1','2','3','4','5','6','7','8','9','0')))
        {
            return false;
        }
    }
    return true;
}
function send_mobile_message($code, $mobile) {

    return tuobao($code, $mobile);

}



function tuobao($code, $mobile) {



    $code = trimall($code);

    $Account = 'cf_tuobaowang';

    $Password = '730610';

    $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";

    $message = '您的验证码是：' . $code . '。请不要把验证码泄露给其他人。';



    $post_data = "account=$Account&password=$Password&mobile=" . $mobile . "&content=" . rawurlencode($message);

    //密码可以使用明文密码或使用32位MD5加密

    $get = Post($post_data, $target);

    $result = xml_to_array($get);

    if ($result['SubmitResult']['code'] != 2) {



        $result2['phone'] = $mobile;

        $result2['code'] = $result['SubmitResult']['code'];

        $result2['message'] = $result['SubmitResult']['msg'];

        return $result2;

    }

    return true;

}
/**
 * 根据值删除元素 匹配的第一个元素
 * @param array $array
 * @param string $string
 * @return 返回删除元素的键值 未查找到返回false
 * @author ljk
 */
function array_unset(&$array, $string) {
    $key = array_search($string, $array);
    if ($key !== false) {
        array_splice($array, $key, 1);
    }
    return $key;
}
function Post($curlPost, $url) {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_HEADER, false);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_NOBODY, true);

    curl_setopt($curl, CURLOPT_POST, true);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);

    $return_str = curl_exec($curl);

    curl_close($curl);

    return $return_str;

}