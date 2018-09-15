<?php
/**
 * Created by PhpStorm.
 * User: yzg
 * Date: 2016/11/15
 * Time: 18:49
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

if(submitcheck('permsubmit')){
    $r = C::t('#xigua_x#xigua_x_log')->clear_log();
    if($r){
        cpmsg(lang('plugin/xigua_x', 'clear_succeed'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=send&page=".$_GET['page'], 'succeed');
    }
}

showformheader("plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=send&page=".$_GET['page']);
showtableheader(lang('plugin/xigua_x','dorder'));
showtablerow('class="header"',array(),array(
    lang('plugin/xigua_x','OPENID'),
    lang('plugin/xigua_x','jieshou'),
    lang('plugin/xigua_x','content'),
    'Url',
    lang('plugin/xigua_x','type'),
    lang('plugin/xigua_x','stat'),
    lang('plugin/xigua_x','time'),
));
$page = max(1, intval(getgpc('page')));
$lpp   = 10;
$start_limit = ($page - 1) * $lpp;
$res = C::t('#xigua_x#xigua_x_log')->fetch_all_bypage($start_limit, $lpp);
$icount = C::t('#xigua_x#xigua_x_log')->fetch_count_bypage();

foreach ($res as $v) {
    if($v['uid']){
        $uids[$v['uid']] = $v['uid'];
    }
}
if($uids){
    $users = DB::fetch_all('SELECT uid,username FROM %t WHERE uid IN (%n)', array('common_member', $uids), 'uid');
}

$templatelist = C::t('#xigua_x#xigua_x')->fetch_list_by_page();

foreach ($res as $re) {

    $content = json_decode($re['content'], true);
    foreach ($content as $index => $item) {
        $content[$index]['value'] = diconv($item['value'], 'UTF-8');
    }
    $show = '<table>';
    foreach (explode("\n", $templatelist[$re['template_id']]['content']) as $index => $item) {
        list($first, $secnd) = explode(lang('plugin/xigua_x', 'dot'), $item);
        if (!$secnd) {
            $secnd = $first;
            $first = '';
        }
        $secnd = str_replace(array('{{', '.DATA}}'), '', $secnd);
        $first = str_replace(array('{{', '.DATA}}'), '', $first);
        $color = $content[$secnd]['color'] ? "color:".$content[$secnd]['color'] :'';
        $show.= "<tr class='nopadding noborder'>".($first?"<td>$first</td>":'')."<td style='$color' ".($first?"":'colspan=2')."><div style='max-width:300px'>{$content[$secnd]['value']}</div></td></tr>";
    }
    $show .= '</table>';

    $content['url']['value'] = str_replace('&mobile=2', '', $content['url']['value']);
    showtablerow('', array(), array(
        $re['openid'],
        $users[$re['uid']] ?$users[$re['uid']]['username']: $re['uid'],
        $show,
        "<div style='max-width:250px'><a target='_blank' href='{$content['url']['value']}'>{$content['url']['value']}</a></div>",
        $templatelist[$re['template_id']]['title'],
        "<div style='width:180px'>{$re['errmsg']}</div>",
        date('m-d H:i:s', $re['crts']),
    ));
}
$multipage = multi($icount, $lpp, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=send&lpp=$lpp", 0, 20);
showsubmit('permsubmit', lang('plugin/xigua_x','qingli'), '', '' ,$multipage);
showtablefooter();
showformfooter();
?>
<style> table tr.nopadding td{padding:0 3px!important;height:20px} </style>
