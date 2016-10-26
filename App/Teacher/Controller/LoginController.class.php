<?phpnamespace Teacher\Controller;use Think\Controller;class LoginController extends Controller {    public function index() {        layout(false);        if (IS_POST) {            //验证码            $verify = new \Think\Verify();            if (!$verify->check(I("verify"))) {                $this->error('验证码错误', U("index"));            }            $act = "ulogin";            $data = I();            $data['connect_mode'] = 'computer';            $return = $this->getdata($act, $data);            if ($return["status"] == 0) {                $this->error($return["msg"]);            } else {                session("minfo", $return["msg"]['minfo']);                $tinfo = $return["msg"]['minfo']["tinfo"];                if (!empty($tinfo)) {                    session("token", $return["msg"]['minfo']["token"]);                    session("websocket_key", $return["msg"]['websocket_key']);                    $this->redirect('Index/index');                } else {                    $this->error("登录错误");                }            }        }        $this->display();    }    public function verify() {        $Verify = new \Think\Verify(C('VERIFY_CONFIG'));        $Verify->codeSet = '02345689';        $Verify->entry();    }    public function logout() {        session('token', null);        session('minfo', null);        $this->redirect('Login/index');    }    public function savepwd() {        $data = I();        if ($data["pwd"] != $data["rpwd"]) {            $this->error("两次密码输入不一样！");        }        $member = M("member")->where(array("token" => session("token")))->find();        if (empty($member["pwd"])) {            $phone_pwd = substr($member["phone"], -6, 6);            if ($phone_pwd != $data["opwd"]) {                $this->error("密码输入错误！");            } else {                $new_pwd = getencrypt($data["pwd"], $member["phone"]);                $s["pwd"] = $new_pwd;                $member = M("member")->where(array("id" => $member["id"]))->save($s);                $this->success("修改成功");            }        } else {            $encryptpwd = getencrypt($data["opwd"], $member["phone"]);            if ($encryptpwd != $member["pwd"]) {                $this->error("密码输入错误！");            } else {                $new_pwd = getencrypt($data["pwd"], $member["phone"]);                $s["pwd"] = $new_pwd;                $member = M("member")->where(array("id" => $member["id"]))->save($s);                $this->success("修改成功");            }        }    }    private function getSign($data) {        ksort($data);        foreach ($data as $k => $v) {//            $v = urlencode($v);            $buff .= $k . "=" . $v . "&";        }        return md5($buff . API_TOKEN);    }    protected function getdata($url, $param, $is_sign = true) {        if ($is_sign) {            $param['sign'] = $this->getSign($param);        }        $json = $this->cpost($url, $param);        $return = json_decode($json, true);        if (!$return) {            $this->error($json);        }        return $return;    }    private function cpost($url, $param, $post_file = '') {        $url = C('WEB_DOMAIN') . 'api.php?' . $url;        $oCurl = curl_init();        if (stripos($url, "https://") !== FALSE) {            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1        }        if (is_string($param) || $post_file) {            $strPOST = $param;        } else {            $aPOST = array();            foreach ($param as $key => $val) {                $aPOST[] = $key . "=" . urlencode($val);            }            $strPOST = join("&", $aPOST);        }        curl_setopt($oCurl, CURLOPT_URL, $url);        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);        curl_setopt($oCurl, CURLOPT_POST, true);        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);        $sContent = curl_exec($oCurl);        $aStatus = curl_getinfo($oCurl);        curl_close($oCurl);        if (intval($aStatus["http_code"]) == 200) {            return $sContent;        } else {            return $sContent;        }    }}