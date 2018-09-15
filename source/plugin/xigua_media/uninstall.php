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

$pluginid = 'xigua_media';

require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';
WeChatHook::delAPIHook($pluginid);

$sql = <<<SQL

SQL;

//runquery($sql);
@unlink(DISCUZ_ROOT . './source/plugin/xigua_media/discuz_plugin_xigua_media.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_media/discuz_plugin_xigua_media_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_media/discuz_plugin_xigua_media_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_media/discuz_plugin_xigua_media_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/xigua_media/discuz_plugin_xigua_media_TC_UTF8.xml');
$finish = TRUE;
@unlink(DISCUZ_ROOT . 'source/plugin/xigua_media/uninstall.php');