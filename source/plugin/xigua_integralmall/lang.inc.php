<?php
/**
 * Created by PhpStorm.
 * User: yzg
 * Date: 2016/9/30
 * Time: 9:49
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$plugin = 'xigua_integralmall';

loadcache('pluginlanguage_script');

if(submitcheck('dosubmit')){
    if(checkmobile()){
        cpmsg('no zuo no die!', "action=plugins&operation=config&do=$pluginid&identifier=xigua_integralmall&pmod=lang", 'succeed');
    }


    $cache = DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_template'");
    $data = unserialize($cache);
    $data[$plugin] = $_GET['configary1'];
    C::t('common_syscache')->update('pluginlanguage_template', $data);
    unset($data);

    $cache = DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_script'");
    $data = unserialize($cache);
    $data[$plugin] = $_GET['configary1'];
    C::t('common_syscache')->update('pluginlanguage_script', $data);


    cpmsg(lang('plugin/xigua_integralmall', 'succeed'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_integralmall&pmod=lang", 'succeed');
}

showformheader("plugins&operation=config&do=$pluginid&identifier=xigua_integralmall&pmod=lang");
showtableheader();


foreach ($_G['cache']['pluginlanguage_script'][$plugin] as $arr => $item) {
    showsetting($arr, 'configary1['.$arr.']', $item, 'text', 0, 0 );
}

showsubmit('dosubmit');
showtablefooter();
showformfooter();
