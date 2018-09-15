<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16/016
 * Time: 0:51
 */

//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$config = $_G['cache']['plugin']['xigua_x'];
$timespace = intval($config['timespace']) * 1000;

$formhsah = formhash();

if ($_GET['formhash'] == $formhsah) {

    global $_G;

    $cachename = 'xigua_x_lasttime';

    if (!$_G['cache']['plugin']) {
        loadcache('plugin');
    }
    $config = $_G['cache']['plugin']['xigua_x'];

    include_once DISCUZ_ROOT . './source/plugin/xigua_x/cron/cron_send.php';
    if ($sendsuccess == 1) {
        exit('' . '300');
    } else {
        exit('' . $timespace);
    }
} else {
    exit('stop');
}