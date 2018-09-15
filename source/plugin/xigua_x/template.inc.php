<?php
/**
 * Created by PhpStorm.
 * User: yzg
 * Date: 2016/11/13
 * Time: 00:43
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
global $_G;
if(!$_G['cache']['plugin']){
    loadcache('plugin');
}
$config = $_G['cache']['plugin']['xigua_x'];

if(submitcheck('test', 1) &&FORMHASH == $_GET['formhash']){
    include_once 'xWechat.lib.class.php';
    $client = new xWeChat($config['appid'], $config['appsecret']);

    $template_list = array();
    if($ary = $client->getAllPrivateTemplate()){
        foreach ($ary['template_list'] as $index => $item) {
            foreach ($item as $k => $v) {
                $item[$k] = diconv($v, 'UTF-8', CHARSET);
            }
            $template_list[] = $item;
        }
        if(C::t('#xigua_x#xigua_x')->take_replace($template_list)){
            cpmsg(lang('plugin/xigua_x', 'succeed'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=template", 'succeed', array());
        }
    }else{
        $err = diconv($client->error(), 'UTF-8');
        $err = $err ? $err : lang('plugin/xigua_x', 'none');
        cpmsg(lang('plugin/xigua_x', 'error').$err, "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=template", 'succeed', array());
    }
}

if(submitcheck('dosubmit')){

    foreach ($_GET['row'] as $index => $item) {
        $item['split'] = serialize($item['split']);
        C::t('#xigua_x#xigua_x')->update($index, $item);
    }

    if($_GET['delete']){
        C::t('#xigua_x#xigua_x')->multi_delete($_GET['delete']);
    }

    cpmsg(lang('plugin/xigua_x', 'success'), "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=template&rand=".time(), 'succeed', array());
}

$list = C::t('#xigua_x#xigua_x')->fetch_list_by_page();


showtips(lang('plugin/xigua_x', 'tip'));
showformheader("plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=template");
showtableheader(lang('plugin/xigua_x', 'list'));
$td = array('class="td25"');
showtablerow('class="header"', $td, array(
    lang('plugin/xigua_x','del'),
    lang('plugin/xigua_x','tplid'),
    lang('plugin/xigua_x','title'),
    lang('plugin/xigua_x','type1'),
    lang('plugin/xigua_x','tplco'),
    lang('plugin/xigua_x','sendinfo'),
));

foreach ($list as $row) {
    $id = $row['id'];

    $conetlist = array();
    $split = unserialize($row['split']);

    $tpl = '<table>';
    foreach (explode("\n", $row['content']) as $index => $item) {
        list($first, $secnd) = explode(lang('plugin/xigua_x', 'dot'), $item);
        if(!$secnd){
            $secnd = $first;
        }
        $secnd = str_replace(array('{{','.DATA}}'), '', $secnd);
        $first = str_replace(array('{{','.DATA}}'), '', $first);
        $ck = "{$id}_$index";
        $tpl .= "<tr class='noborder nopadding'><td>$first</td><td><input name='row[$id][split][$secnd][value]' value='{$split[$secnd]['value']}' />
</td><td>
<input name=\"row[$id][split][$secnd][color]\" id=\"{$ck}_v\" type=\"text\" class=\"txt\" style='float:left;' value=\"{$split[$secnd]['color']}\" onchange=\"updatecolorpreview('{$ck}')\">
<input id=\"{$ck}\" type=\"button\" class=\"colorwd\" onclick=\"return showcolor1('$ck');\" style='background:{$split[$secnd]['color']}'>
<span id=\"{$ck}_menu\" style=\"display: none\"><iframe id=\"{$ck}_frame\" src=\"\" frameborder=\"0\" width=\"210\" height=\"148\" scrolling=\"no\"></iframe>
</td></tr>";
    }
    $tpl .= '</table>';


    showtablerow('', $td, array(
        "<input type='checkbox' class='checkbox' name='delete[]' value='{$id}' />",
        '<input type="text" name="row['.$id.'][template_id]" value="'.$row['template_id'].'" />',
        $row['title'],
        '<select name="row['.$id.'][type]"><option value="0" '.($row['type']==0?'selected':'').'>'.lang('plugin/xigua_x', 'd1').'</option><option value="1" '.($row['type']==1?'selected':'').'>'.lang('plugin/xigua_x', 'd2').'</option><option value="2" '.($row['type']==2?'selected':'').'>'.lang('plugin/xigua_x', 'd3').'</option></select>',
        $tpl,
        ($row['lastsend']?lang('plugin/xigua_x','new').':'.date('m-d H:i:s', $row['lastsend']).'<br>':'').$row['succeedtimes'].'/'.$row['sendtimes'],
    ));
}

showsubmit('dosubmit', 'submit', 'del');
showtablefooter();

showtableheader(lang('plugin/xigua_x','ilist'));
showsetting(lang('plugin/xigua_x','ilist'), '', '',
    "<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=template&test=1&formhash=".FORMHASH."\">".lang('plugin/xigua_x', lang('plugin/xigua_x','get'))."</a><br />"
);
showtablefooter();


showformfooter();
?>
<style> table tr.nopadding td{padding:2px 3px!important;height:20px} </style>
<script>
    function showcolor1(ck) {
        document.getElementById(ck+'_frame').src='static/image/admincp/getcolor.htm?'+ck+'|'+ck+'_v';
        showMenu({ctrlid:ck});
    }
</script>

