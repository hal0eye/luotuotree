<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16/016
 * Time: 1:35
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
global $_G;
if(!$_G['cache']['plugin']){
    loadcache('plugin');
}
$config = $_G['cache']['plugin']['xigua_x'];
$wechat_table = $config['wechattable'];
$limit  = 20;

include_once DISCUZ_ROOT. './source/plugin/xigua_x/xWechat.lib.class.php';

if(
    (!empty($_GET['postdosubmit']) && $_GET['postdosubmit']=='yes' && !empty($_GET['formhash']) && $_GET['formhash'] == formhash())
    ||
    submitcheck('postdosubmit')
){
    $processed = 0;
    $pagesize = $limit;
    $current = isset($_GET['current']) && $_GET['current'] > 0 ? intval($_GET['current']) : 0;
    $next = $current + $pagesize;


    $r = $_GET['row'];
    $r['template'] = $r['split'] ? $r['split'][$r['template_id']] : $r['template'];
    unset($r['split']);
    $template_id = $r['template_id'];

    switch ($r['target']){
        case 'target_uid':
            $uids = explode(',', trim($r['uid']));
            foreach ($uids as $index => $item) {
                $uids[$index] = intval($item);
            }
            if($uids){
                $openids = DB::fetch_all("SELECT openid,userid FROM %t WHERE userid IN (%n) AND openid<>''", array($wechat_table, $uids), 'userid');
            }
            break;
        case 'target_openid':
            $uids = array();
            foreach (explode("\n", trim($r['openid'])) as $index => $item) {
                $openids[$item] = trim($item);
            }
            break;
        case 'target_group':
            if($r['group']){
                $openids = DB::fetch_all("SELECT w.openid,m.uid FROM %t AS w, %t AS m WHERE m.uid=w.userid AND m.groupid IN (%n) AND w.openid<>'' ORDER BY m.uid ASC LIMIT $current,$pagesize ", array($wechat_table,'common_member', $r['group']), 'uid');
            }
            $processed = $openids ? 1 : 0;
            break;
        case 'target_all':
            $openids = DB::fetch_all("SELECT w.openid,m.uid FROM %t AS w, %t AS m WHERE m.uid=w.userid AND w.openid<>'' ORDER BY m.uid ASC LIMIT $current,$pagesize ", array($wechat_table,'common_member'), 'uid');
            $processed = $openids ? 1 : 0;
            break;
        case 'target_uids':

            list($minuid, $maxuid) = explode('-', trim($r['uids']));
            if($minuid && $maxuid && ($minuid<=$maxuid)){
                $minuid = intval($minuid);
                $maxuid = intval($maxuid);
                $openids = DB::fetch_all("SELECT w.openid,m.uid FROM %t AS w, %t AS m WHERE m.uid=w.userid AND m.uid>=$minuid AND m.uid<=$maxuid AND w.openid<>'' ORDER BY m.uid ASC LIMIT $current,$pagesize ", array($wechat_table,'common_member'), 'uid');
                $processed = $openids ? 1 : 0;
            }
            break;
        case 'by_fans':
            $openids = C::t('#xigua_x#xigua_x_fans')->fetch_by_page( $current, $pagesize);
            $processed = $openids ? 1 : 0;
            break;
    }


    $client = new xWeChat($config['appid'], $config['appsecret']);
    if($openids){
      foreach ($openids as $uid => $openidinfo) {

          $openid = (is_array($openidinfo)&&$openidinfo['openid']) ? $openidinfo['openid'] : $openidinfo;
          $user = is_numeric($uid) ? getuserbyuid($uid) : array();

          $data = $r['template'];
          foreach ($data as $key => $val) {
              $val['value'] = str_replace(array(
                  '{note}',
                  '{time}',
                  '{author}',
                  '{username}',
                  '{type}',
              ), array(
                  '',
                  date('Y-m-d H:i:s', TIMESTAMP),
                  $_G['username'],
                  $user['username'],
                  lang('plugin/xigua_x', 'system'),
              ), $val['value']);
              $data[$key]['value'] = diconv($val['value'], CHARSET, 'UTF-8');
          }

          $param = array(
              'touser'      => $openid,
              'template_id' => $template_id,
              'url'         => $r['url'],
              'topcolor'    => '#ff0000',
              'data'        => $data,
          );

          $data['url'] = array('value' => $r['url'],  );
          $insertdata = array(
              'uid'         => $uid,
              'openid'      => $openid,
              'template_id' => $template_id,
              'crts'        => TIMESTAMP,
              'content'     => json_encode($data),
          );
          if($result = $client->dosendTemplate($param)){
              $insertdata['code'] = 0;
              $insertdata['errmsg'] = lang('plugin/xigua_x', 'sefsendsuccess');
              C::t('#xigua_x#xigua_x')->incr_by_tplid($template_id, 1);
          }else{
              $error = diconv($client->error(), 'UTF-8');
              $insertdata['code'] = $client->ERROR_NO;
              $insertdata['errmsg'] = $error;
              C::t('#xigua_x#xigua_x')->incr_by_tplid($template_id, 0);
          }
          C::t('#xigua_x#xigua_x_log')->insert($insertdata);
      }
    }

    if($processed) {
        $appendurl = http_build_query(array('row' => $r));
        $nextlink = "action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=post&current=$next&postdosubmit=yes&formhash=".FORMHASH.'&'.$appendurl;
        cpmsg(sprintf(lang('plugin/xigua_x', 'counter_processing'), $current, $next), $nextlink, 'loading');
    } else {
        cpmsg(lang('plugin/xigua_x', 'counter_forum_succeed'), 'action=plugins&operation=config&do='.$pluginid.'&identifier=xigua_x&pmod=post', 'succeed');
    }
}


$list = array();
$res = C::t('#xigua_x#xigua_x')->fetch_list_by_page();


foreach ($res as $index => $item) {

    $ext = array();
    foreach ($res as $kk => $vv) {

        $ext['ext'.$vv['id']] = $vv['id']==$item['id'] ? '' : 'none';
    }

    $list[] = array($index, $item['title'], $ext);
}

showformheader("plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=post");
showtableheader();

showsetting(lang('plugin/xigua_x', 'tpl'), array('row[template_id]', $list, TRUE), $list[0][0], 'mradio');


$ccheck = 1;
foreach ($res as $i => $row) {

    $id = $row['id'];
    $template_id = $row['template_id'];

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
        $tpl .= "<tr class='noborder nopadding'><td>$first</td><td><textarea name='row[split][$template_id][$secnd][value]' value='{$split[$secnd]['value']}' >{$split[$secnd]['value']}</textarea>
</td><td>
<input name=\"row[split][$template_id][$secnd][color]\" id=\"{$ck}_v\" type=\"text\" class=\"txt\" style='float:left;' value=\"{$split[$secnd]['color']}\" onchange=\"updatecolorpreview('{$ck}')\">
<input id=\"{$ck}\" type=\"button\" class=\"colorwd\" onclick=\"return showcolor1('$ck');\" style='background:{$split[$secnd]['color']}'>
<span id=\"{$ck}_menu\" style=\"display: none\"><iframe id=\"{$ck}_frame\" src=\"\" frameborder=\"0\" width=\"210\" height=\"148\" scrolling=\"no\"></iframe>
</td></tr>";
    }
    $tpl .= '</table>';


    showtagheader('tbody', 'ext'.$row['id'], $ccheck, 'sub');

    echo <<<HTML
<tr>
<td class="vtop" colspan="2">
<div style="width:500px">
$tpl
</div>
</td>
</tr>
HTML;


    showtagfooter('tbody');
    $ccheck = 0;
}
showsetting(lang('plugin/xigua_x', 'url'), 'row[url]', $_G['siteurl'], 'text', '',0,lang('plugin/xigua_x', 'url_desc'));

showsetting(lang('plugin/xigua_x', 'sendfanwei'), array('row[target]', array(
    array('target_uid', lang('plugin/xigua_x', 'zhiding'), array('target_all'=> 'none', 'target_group' => 'none', 'target_uid' => '', 'target_openid' => 'none', 'target_uids' => 'none', 'by_fans' => 'none')),
    array('target_uids', lang('plugin/xigua_x', 'target_uids'), array('target_all'=> 'none', 'target_group' => 'none', 'target_uid' => 'none', 'target_openid' => 'none', 'target_uids' => '', 'by_fans' => 'none')),
    array('target_openid', 'OPENID', array('target_all'=> 'none', 'target_group' => 'none', 'target_uid' => 'none', 'target_openid' => '', 'target_uids' => 'none', 'by_fans' => 'none')),
    array('target_group', lang('plugin/xigua_x', 'group1'), array('target_all'=> 'none', 'target_group' => '', 'target_uid' => 'none', 'target_openid' => 'none', 'target_uids' => 'none', 'by_fans' => 'none')),
    array('target_all', lang('plugin/xigua_x', 'all'), array('target_all'=> '', 'target_group' => 'none', 'target_uid' => 'none', 'target_openid' => 'none', 'target_uids' => 'none', 'by_fans' => 'none')),
    array('by_fans', lang('plugin/xigua_x', 'by_fans'), array('target_all'=> 'none', 'target_group' => 'none', 'target_uid' => 'none', 'target_openid' => 'none', 'target_uids' => 'none', 'by_fans' => '')),
), TRUE), 'target_uid', 'mradio');

showtagheader('tbody', 'target_all', 0, '');
showtagfooter('tbody');

showtagheader('tbody', 'target_group', 0, '');
$groups = $forums = array();
foreach(C::t('common_usergroup')->range() as $group) {
    $groups[] = array($group['groupid'], $group['grouptitle']);
}
showsetting(lang('plugin/xigua_x', 'group1'), array('row[group][]', $groups), '', 'mselect');
showtagfooter('tbody');

showtagheader('tbody', 'target_uid', 1, '');
showsetting(lang('plugin/xigua_x', 'uid'), 'row[uid]', '', 'text','',0, lang('plugin/xigua_x', 'uid_desc'));
showtagfooter('tbody');

showtagheader('tbody', 'target_uids', 0, '');
showsetting(lang('plugin/xigua_x', 'target_uids'), 'row[uids]', '', 'text','',0, lang('plugin/xigua_x', 'uids_desc'));
showtagfooter('tbody');

showtagheader('tbody', 'target_openid', 0, '');
showsetting('OPENID', 'row[openid]', '', 'textarea','',0,lang('plugin/xigua_x', 'openid_desc'));
showtagfooter('tbody');

showtagheader('tbody', 'by_fans', 0, '');
$u = '<li>'.lang('plugin/xigua_x', 'by_fans_desc'). "&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=xigua_x&pmod=fans&reset_fans=1&formhash=".FORMHASH."\">".lang('plugin/xigua_x', lang('plugin/xigua_x','reset'))."</a></li>";
showtablerow('', 'class="tipsblock" s="1"', '<ul id="lis">'.$u.'</ul>');
showtagfooter('tbody');

showsubmit('postdosubmit');
showtablefooter();
showformfooter();

?>
<style>.tb2 .rowform{width:600px}</style>
<script>
    function showcolor1(ck) {
        document.getElementById(ck+'_frame').src='static/image/admincp/getcolor.htm?'+ck+'|'+ck+'_v';
        showMenu({ctrlid:ck});
    }
</script>
