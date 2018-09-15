<?php
/**
 *	[【西瓜】积分商城清理无效帖子] (C)2015-2099 Powered by 西瓜先生.
 *	Version: 1.20150815
 *	Date: 2015-8-15 16:25
 *	Warning: Don't delete this comment
 *
 *	cronname:delete_not_exists_intmall
 *	week:-1
 *	day:-1
 *	hour:-1
 *	minute:48
 *	desc:积分商城清理无效帖子
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

include_once DISCUZ_ROOT . 'source/plugin/xigua_integralmall/init.php';

$res = DB::fetch_all('SELECT t.tid AS idt FROM '. DB::table('forum_thread') . ' AS t, '. DB::table('xigua_intmall') .' AS i WHERE t.special=127 AND (t.displayorder<0 OR t.closed=1) AND i.tid=t.tid');
foreach ($res as $v) {
    delete_intmall($v['idt']);
}

$res = DB::fetch_all('SELECT tid FROM '. DB::table('xigua_intmall'));
foreach ($res as $v) {
    $tid= intval($v['tid']);
    if(!DB::result_first('SELECT tid FROM '.DB::table('forum_thread'). ' WHERE tid='.$tid.'  LIMIT 1')){
        delete_intmall($tid);
    }
}
