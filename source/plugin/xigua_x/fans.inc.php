<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/17
 * Time: 19:05
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}



global $_G;
if(!$_G['cache']['plugin']){
    loadcache('plugin');
}
$config = $_G['cache']['plugin']['xigua_x'];
include_once DISCUZ_ROOT. './source/plugin/xigua_x/xWechat.lib.class.php';
$client = new xWeChat($config['appid'], $config['appsecret']);

if(submitcheck('init_fans', 1) &&FORMHASH == $_GET['formhash']) {
    $openids = array();
    $data = $client->get_all_fans();

    if ($data['data']['openid']) {
        $openids = array_merge($openids, $data['data']['openid']);
    }

    while ($data['next_openid']) {
        $data = $client->get_all_fans($data['next_openid']);
        if ($data['data']['openid']) {
            $openids = array_merge($openids, $data['data']['openid']);
        }
    }

    foreach ($openids as $index => $openid) {
        C::t('#xigua_x#xigua_x_fans')->insert(array('openid' => $openid), false, false, 1);
    }
    cpmsg(lang('plugin/xigua_x', 'success'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans", 'succeed', array());
}
if(submitcheck('clear_fans', 1) &&FORMHASH == $_GET['formhash']) {
    C::t('#xigua_x#xigua_x_fans')->delete_all();
    cpmsg(lang('plugin/xigua_x', 'success'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans", 'succeed', array());
}

if(submitcheck('reset_fans', 1) &&FORMHASH == $_GET['formhash']) {
    C::t('#xigua_x#xigua_x_fans')->reset_fans();
    cpmsg(lang('plugin/xigua_x', 'success'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans", 'succeed', array());
}

if(submitcheck('searchtxt')){
    $searchtxt = $_GET['searchtxt'];
}


$page = max(1, intval(getgpc('page')));
$lpp   = 100;
$start_limit = ($page - 1) * $lpp;

$list  = C::t('#xigua_x#xigua_x_fans')->fetch_list_by_page($start_limit, $lpp, $searchtxt);

$openids = array();
foreach ($list as $row) {
    if(!$row['wechat_info']){
        $openids[] = $row['openid'];
    }
}
if($openids){
    $res = $client->get_batch_fansinfo($openids);
}

foreach ($res as $i => $item) {
    $seri = serialize($item);
    C::t('#xigua_x#xigua_x_fans')->update($item['openid'], array('wechat_info'=> $seri, 'subscribe_ts' => $item['subscribe_time']));
    $list[$item['openid']]['wechat_info'] = $seri;
}


$count = C::t('#xigua_x#xigua_x_fans')->fetch_count($searchtxt);
$multipage = multi($count, $lpp, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans");



showtableheader(lang('plugin/xigua_x','ini_fans'));
showsetting(lang('plugin/xigua_x','ini_fans'), '', '',
    "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans&init_fans=1&formhash=".FORMHASH."\">".lang('plugin/xigua_x', lang('plugin/xigua_x','get'))."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans&clear_fans=1&formhash=".FORMHASH."\">".lang('plugin/xigua_x', lang('plugin/xigua_x','clear'))."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans&reset_fans=1&formhash=".FORMHASH."\">".lang('plugin/xigua_x', lang('plugin/xigua_x','reset'))."</a><br />"
);
showtablefooter();

showformheader("plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans");

echo '<div><input type="text" id="searchtxt" name="searchtxt" value="'.$searchtxt.'" class="txt" /> <input type="submit" class="btn" value="'.cplang('search').'" /></div>';

showtableheader(lang('plugin/xigua_x', 'list'));
$td = array('class="td25"');
showtablerow('class="header"', $td, array(
    lang('plugin/xigua_x','openid'),
    lang('plugin/xigua_x','info'),
    lang('plugin/xigua_x','sex'),
    lang('plugin/xigua_x','addr'),
    lang('plugin/xigua_x','subscribe_time'),
    lang('plugin/xigua_x','total_times'),
    lang('plugin/xigua_x','last_send'),
));

foreach ($list as $row) {

    $we = unserialize($row['wechat_info']);
    $show = "<img style='width:25px;height:25px;' src=\"{$we['headimgurl']}\" />{$we['nickname']}";
    $color = '0000-00-00 00:00:00'!=$row['last_send'] ? 'style="color:red"' : '';

    showtablerow('', $td, array(
        $row['openid'],
        $show,
        lang('plugin/xigua_x', 'sex'.$we['sex']),
        $we['country'].' '.$we['province'].' ' .$we['city'],
        dgmdate($we['subscribe_time'], 'Y-m-d H:i:s'),
        $row['total_times'],
        "<span $color>{$row['last_send']}</span>",
    ));
}

showsubmit('dosubmit', 'submit', '', $multipage);
showtablefooter();
showformfooter();

