<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$pluginid = 'xigua_integralmall';


$sql = <<<EOT
DROP TABLE IF EXISTS pre_xigua_intmall_code;
DROP TABLE IF EXISTS pre_xigua_intmall;
DROP TABLE IF EXISTS pre_xigua_intmall_log;
DROP TABLE IF EXISTS pre_xigua_intmall_receiver;
EOT;

runquery($sql);

$finish = TRUE;

$ar = array(
    'discuz_plugin_xigua_integralmall.xml',
    'discuz_plugin_xigua_integralmall_SC_GBK.xml',
    'discuz_plugin_xigua_integralmall_SC_UTF8.xml',
    'discuz_plugin_xigua_integralmall_TC_BIG5.xml',
    'discuz_plugin_xigua_integralmall_TC_UTF8.xml',
    'uninstall.php',
    'install.php',
    'api.class.php',
);
foreach ($ar as $v) {
    $path = DISCUZ_ROOT . './source/plugin/xigua_integralmall/'.$v;
    file_put_contents($path, '');
    @unlink($path);
}

if(is_file(DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php')){
    @include_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';
    WeChatHook::delAPIHook($pluginid);
}