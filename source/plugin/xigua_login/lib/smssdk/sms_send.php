<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);

function login_send_sms($mobile, $code){
    global $config;
    $res = '';
    if (!$config['newsdk']) {
        include_once "TopSdk.php";
        $c = new TopClient();
        $c->appkey = $config['smsAppKey'];
        $c->secretKey = $config['smssecretKey'];
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName(diconv($config['smsFreeSignName'], CHARSET, 'utf-8'));
        $req->setSmsParam("{code:'" . $code . "'}");
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode($config['smsTemplateCode']);
        $resp = $c->execute($req);
        $ret = (array)$resp;

        if ($ret['code']) {
            $res = diconv($ret['sub_msg'], 'utf-8', CHARSET) . diconv($ret['msg'], 'utf-8', CHARSET);
        } elseif ($ret['result']['err_code'] == 0) {
            $res = '';
        }
        return $res;
    } else {
        include_once DISCUZ_ROOT . 'source/plugin/xigua_login/lib/alisms/api_demo/SmsDemo.php';
        $demo = new SmsDemo(
            $config['smsAppKey'],
            $config['smssecretKey']
        );
        try {
            $response = $demo->sendSms(
                diconv($config['smsFreeSignName'], CHARSET, 'utf-8'),
                $config['smsTemplateCode'],
                $mobile,
                array("code" =>$code)
            );
            $response = (array)$response;
            if ($response['Code'] != 'OK') {
                $res = diconv($response['Message'], 'utf-8', CHARSET) . $response['Code'];
            } else {
                $res = '';
            }
        } catch (Exception $e) {
            $res = var_export($e->getMessage(), true);
        }
        return $res;
    }

}