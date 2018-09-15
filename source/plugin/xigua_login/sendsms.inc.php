<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);

include_once libfile('function/cache');
include_once libfile('function/member');
@include_once DISCUZ_ROOT.'./source/plugin/mobile/qrcode.class.php';
include_once DISCUZ_ROOT. 'source/plugin/wechat/wechat.lib.class.php';
include_once DISCUZ_ROOT.'source/plugin/xigua_login/function.php';
$config = $_G['cache']['plugin']['xigua_login'];

$isMob='#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[\d]{1}\d{8}$|^18[\d]{9}$#';
if(submitcheck('mobile') ){
    if(!preg_match($isMob, $_GET['mobile'])){
        domessage(lang('plugin/xigua_login','mobileerror'));
    }
    include_once DISCUZ_ROOT.'source/plugin/xigua_login/lib/smssdk/sms_send.php';
    $cookiekey = 'loginsms_'.$_GET['mobile'];
    dsetcookie($cookiekey, mt_rand(100000, 999999), 3600);
    $ret = login_send_sms($_GET['mobile'], getcookie($cookiekey));
    if($ret){
        domessage($ret);
    }else{
        dsetcookie('bmobile', $_GET['mobile'],86400);
        domessage(lang('plugin/xigua_login','sendsuccess'), 'success');
    }
}
function domessage($msg, $type = 'error', $url = '', $extjs = ''){
    include template('common/header_ajax');
    echo $type.'|' .str_replace('|', '', $msg) .'|'.$url .'|'.$extjs;
    include template('common/footer_ajax');
    dexit();
}