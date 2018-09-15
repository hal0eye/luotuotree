<?php
/**
 * Created by PhpStorm.
 * User: yangzhiguo
 * Date: 15/9/3
 * Time: 17:31
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$page = max(1, intval(getgpc('page')));
$lpp   = 30;
$start_limit = ($page - 1) * $lpp;
$url = "plugins&operation=config&do=$pluginid&identifier=xigua_login&pmod=unbindlog&page=$page";


if(submitcheck('permsubmit')) {
    if ($delete = dintval($_GET['delete'], true)) {
        $r = C::t('#xigua_login#xigua_login_unbind_log')->deletes($delete);
        cpmsg('succeed', "action=$url", 'succeed');
    }
}
if(submitcheck('searchtxt')){
    $txt = stripsearchkey($_GET['searchtxt']);
    if(strlen($txt)==11 && is_numeric($txt)){
        $user = DB::fetch_all('SELECT * FROM %t WHERE mobile IN (%n)', array('xigua_login_unbind_log', array($txt)), 'uid');
    }elseif(is_numeric($txt)){
        $user = DB::fetch_all('SELECT * FROM %t WHERE uid IN (%n)', array('common_member', array($txt)), 'uid');
    }else{
        $user = DB::fetch_all("SELECT * FROM %t WHERE openid LIKE %s", array('xigua_login_unbind_log', '%'.$txt.'%'), 'uid');
    }
    foreach ($user as $v) {
        if ($v['uid']) {
            $uids[$v['uid']] = $v['uid'];
        }
    }

    $list  = DB::fetch_all('SELECT * FROM %t WHERE uid IN (%n)', array('xigua_login_unbind_log', $uids), 'id');

    $count = count($user);
    $user = DB::fetch_all('SELECT * FROM %t WHERE uid IN (%n)', array('common_member', $uids), 'uid');
}
else
{
    $list  = DB::fetch_all("SELECT * FROM %t ORDER BY crts DESC " . DB::limit($start_limit, $lpp), array('xigua_login_unbind_log'));
    foreach ($list as $v) {
        if ($v['uid']) {
            $uids[$v['uid']] = $v['uid'];
        }
    }
    $user = DB::fetch_all('SELECT * FROM %t WHERE uid IN (%n)', array('common_member', $uids), 'uid');

    $count = DB::result_first('SELECT count(*) as c FROM '.DB::table('xigua_login_unbind_log'));
}

$multipage = multi($count, $lpp, $page, ADMINSCRIPT."?action=$url");

showformheader($url,'','vlist');

echo '<div><input type="text" id="searchtxt" name="searchtxt" value="'.$txt.'" class="txt" /> <input type="submit" class="btn" value="'.cplang('search').'" /></div>';
showtableheader(lang('home/template', 'member_manage'));

$rowhead = array(
    'ID',
    'openid',
    lang('plugin/xigua_login', 'mobile'),
    'UID',
    cplang('username'),
    cplang('forums_edit_perm_formula_regdate'),
    lang('plugin/xigua_login', 'unbind_ts'),
);

showtablerow('class="header"', array(), $rowhead);
$lang_unbind = lang('plugin/xigua_login', 'unbind');
$lang_unbindandel = lang('plugin/xigua_login', 'unbindanddel');
$confirm1 = lang('plugin/xigua_login', 'confirm1');
$confirm2 = lang('plugin/xigua_login', 'confirm2');

foreach ($list as $row) {
    $uid = $row['uid'];
    $username = $user[$uid]['username'];

    $rowbody = array(
        $row['id']."<input type='checkbox' class='checkbox' name='delete[]' value='{$row['id']}' />",
        $row['openid'],
        $row['mobile'],
        $uid,
        "<img src='".avatar($uid, 'small', true)."' style='vertical-align:middle;height:20px;width:20px;' /> $username",
        date('Y-m-d H:i:s', $user[$uid]['regdate']),
        date('Y-m-d H:i:s', $row['crts'])
    );
    showtablerow('', array(), $rowbody);
}

showsubmit('permsubmit', 'submit', 'select_all', '',$multipage);
showtablefooter();
showformfooter();