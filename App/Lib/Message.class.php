<?phpnamespace Lib;/** * Message class * * 发送信息并且推送微信 */class Message{    private $error;    public $weixin_info='';    private $template=array(        //班级通知        'OPENTM204533457'=>array(            'wx_tmp_id'=>'qANdR8I1MmXcNPwjk0_mdO3iUmIa8wcgDvZnxynU6KA',            'vars'=>array(                'first',                'keyword1',                'keyword2',                'keyword3',                'keyword4',                'remark',                ),            ),        //作业通知        'TM00376'=>array(            'wx_tmp_id'=>'8T5Sr1KtM6iGsCy-A5jxVrIY2AjVxslRZMzjCQzLIGk',            'vars'=>array(                'first',                'name',                'subject',                'content',                'remark',                ),            ),        //账户变动提醒        'OPENTM207664902'=>array(            'wx_tmp_id'=>'2O0QqAneS0DyawVJZJyAZsNH-ifD3Yv7GfKzDaLjBsE',            'vars'=>array(                'first',                'keyword1',                'keyword2',                'keyword3',                'remark',                ),            ),        //支出申请        'OPENTM401320346'=>array(            'wx_tmp_id'=>'1Sw2QoUGAEbd9djn8WrpdYDPIgPYPe4hO5SgHhlwI8k',            'vars'=>array(                'first',                'keyword1',                'keyword2',                'keyword3',                'remark',                ),                        ),        //审核通知        'OPENTM400501478'=>array(            'wx_tmp_id'=>'XpHJWniltBbbk86iAvmcVJx67aR1S72gpkqQkq2KFP0',            'vars'=>array(                'first',                'keyword1',                'keyword2',                'keyword3',                'remark',                ),                        ),        );            public function send($temp_id,$args,$openid,$url='')    {                $config=  require __DIR__.'/../Common/Conf/config.php';        $weixin_info=$config['WEIXIN_CONIFG'];                $option     = array(            'token' => WEIXIN_TOKEN, //填写你设定的key            'encodingaeskey' => $weixin_info['encodingaeskey'], //填写加密用的EncodingAESKey            'appid' => $weixin_info['appid'], //填写高级调用功能的app id            'appsecret' => $weixin_info['appsecret'], //填写高级调用功能的密钥        );                $weObj  =   new Wechat($option);        $temp_data['touser']    = $openid;        $temp_data['template_id']=  $this->template[$temp_id]['wx_tmp_id'];        $temp_data['url']       =$url;        $temp_data['topcolor']  ='#FF0000';         foreach($this->template[$temp_id]['vars'] as $var)        {               $temp_data['data'][$var]['value']=$args[$var];        }        if(false===$weObj->sendTemplateMessage($temp_data))        {            $this->error=$weObj->getError();            return false;        }    }    public function getError()    {        return $this->error;    }    }