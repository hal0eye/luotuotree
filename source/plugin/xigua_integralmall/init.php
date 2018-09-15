<?php
/**
 * Created by PhpStorm.
 * User: yangzhiguo
 * Date: 15/7/25
 * Time: 23:39
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$pluginversion = '20170203126';

define('XIGUA_INTEGRALMALL_NAME', lang('plugin/xigua_integralmall', 'name'));
define('XIGUA_INTEGRALMALL_BUTTONTEXT', lang('plugin/xigua_integralmall', 'buttontext'));

$noimg = $_G['siteurl'].'source/plugin/xigua_integralmall/static/images/nophoto.png';
$noimg1 = $_G['siteurl'].'source/plugin/xigua_integralmall/static/images/nophoto1.png';
$ini = array(
    'malltypes' => array(
        '1' => lang('plugin/xigua_integralmall', 'yikou'),
        '2' => lang('plugin/xigua_integralmall', 'choujiang'),
        '3' => lang('plugin/xigua_integralmall', 'duobaodao'),
        '4' => lang('plugin/xigua_integralmall', 'jingcai'),
        '5' => lang('plugin/xigua_integralmall', 'renyigou'),
    ),
    'goodkinds' => array(
        '2' => lang('plugin/xigua_integralmall', 'shiwu'),
        '1' => lang('plugin/xigua_integralmall', 'xuni'),
    ),
);
$titles = array(
    '1' => lang('plugin/xigua_integralmall', 'dui'),
    '2' => lang('plugin/xigua_integralmall', 'choujiangs'),
    '3' => lang('plugin/xigua_integralmall', 'chujia'),
    '4' => lang('plugin/xigua_integralmall', 'jingcais'),
    '5' => lang('plugin/xigua_integralmall', 'dui')
);
$config           = $GLOBALS['_G']['cache']['plugin']['xigua_integralmall'];

$setting_credit = $config['credit'];

$config['ctitle'] = $GLOBALS['_G']['setting']['extcredits'][$setting_credit]['title'];
$config['cunit']  = $GLOBALS['_G']['setting']['extcredits'][$setting_credit]['unit'];

$auto1 = explode("\n", trim($config['auto1']));
$auto2 = explode("\n", trim($config['auto2']));
$auto3 = explode("\n", trim($config['auto3']));
$auto4 = explode("\n", trim($config['auto4']));
$autos = array(
    1 => trim($auto1[mt_rand(0, count($auto1)-1)]),
    2 => trim($auto2[mt_rand(0, count($auto2)-1)]),
    3 => trim($auto3[mt_rand(0, count($auto3)-1)]),
    4 => trim($auto4[mt_rand(0, count($auto4)-1)]),
    5 => trim($auto1[mt_rand(0, count($auto1)-1)]),
);
if($config['logo']){
    $config['logo'] = '<img src="'.$config['logo'].'" style="border:0" />';
}else{
    $config['logo'] = $_G['style']['boardlogo'];
}
$wechat = unserialize($_G['setting']['mobilewechat']);
if(!$_GET['tid']){
    $navtitle = $config['navtitle'] ? $config['navtitle'] : $_G['setting']['bbname'];
}

if($wechat['wsq_allow']){
    $cururl = XIget_url();
    if($_GET['ifr']){
        $cururl = "http://wsq.discuz.com/?c=index&a=viewthread&f=wx&tid=".intval($_GET['tid'])."&siteid=$wechat[wsq_siteid]";
    }
    $param = urlencode(base64_encode($cururl));
    $loginurl = "http://wsq.discuz.com/?c=index&a=profile&f=wx&siteid=$wechat[wsq_siteid]&mobile=2&login=yes&backurl=".$param;
}else {
    $loginurl = $_G['siteurl'].'member.php?mod=logging&action=login&mobile=2';
}

$htitle = array(
    '1' => array(
        lang('plugin/xigua_integralmall', 'chui'), lang('plugin/xigua_integralmall', 'yikou')
    ),
    '2' => array(
        $config['ctitle'].lang('plugin/xigua_integralmall', 'choujiangs'), lang('plugin/xigua_integralmall', 'choujiangs')
    ),
    '3' =>  array(
        lang('plugin/xigua_integralmall', 'duobao'), lang('plugin/xigua_integralmall', 'jingpai')
    ),
    '4' =>  array(
        lang('plugin/xigua_integralmall', 'cai'), lang('plugin/xigua_integralmall', 'jingcais')
    ),
    '5' =>  array(
        lang('plugin/xigua_integralmall', 'renyigou'), lang('plugin/xigua_integralmall', 'renyigou')
    )
);
switch($config['charset'])
{
    case 'utf':
        $formfix = ' accept-charset="utf-8" ';
        break;
    case 'gbk':
        $formfix = ' accept-charset="gbk" ';
        break;
    default:
        $formfix = '';
        break;
}


/**
 * @return string
 */
function XIget_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? XIsafe_replace($_SERVER['PHP_SELF']) : XIsafe_replace($_SERVER['SCRIPT_NAME']);
    $path_info = isset($_SERVER['PATH_INFO']) ? XIsafe_replace($_SERVER['PATH_INFO']) : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? XIsafe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.XIsafe_replace($_SERVER['QUERY_STRING']) : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
/**
 * @param $string
 * @return mixed
 */
function XIsafe_replace($string) {
    $string = str_replace('%20','',$string);
    $string = str_replace('%27','',$string);
    $string = str_replace('%2527','',$string);
    $string = str_replace('*','',$string);
    $string = str_replace('"','&quot;',$string);
    $string = str_replace("'",'',$string);
    $string = str_replace('"','',$string);
    $string = str_replace(';','',$string);
    $string = str_replace('<','&lt;',$string);
    $string = str_replace('>','&gt;',$string);
    $string = str_replace("{",'',$string);
    $string = str_replace('}','',$string);
    $string = str_replace('\\','',$string);
    return $string;
}

function do_duobaodao($idata, $hit_list, $miss_list ){

    foreach ($hit_list as $row) {
        C::t('#xigua_integralmall#xigua_intmall_code')->send_code($row['uid'], $idata['tid']);
        C::t('#xigua_integralmall#xigua_intmall_log')->finish_update($row['uid'], $idata['tid'], 1);
        C::t('#xigua_integralmall#xigua_intmall')->incr_lognum($idata['tid'], 1);

        $credit_go_tmp[$row['uid']]['price']    = $row['currentprice'];
        $credit_go_tmp[$row['uid']]['username'] = $row['username'];
    }

    foreach ($miss_list as $row) {
        $credit_back_tmp[$row['uid']]['price']    = $row['currentprice'];
        $credit_back_tmp[$row['uid']]['username'] = $row['username'];
        C::t('#xigua_integralmall#xigua_intmall_log')->finish_update($row['uid'], $idata['tid'], 0);
    }

    return send_credit($idata, $credit_back_tmp, $credit_go_tmp);
}

function end_duobaodao($idata){
    $hit_list = $miss_list = array();
    global $_G;
    if($idata['malltype'] == 3){
        $watting_jiesuan = C::t('#xigua_integralmall#xigua_intmall')->is_watting_jiesuan($idata);
        if(!$watting_jiesuan){
            return false;
        }
        C::t('#xigua_integralmall#xigua_intmall')->finish($idata['tid']);

        $all_list = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_all_log($idata['tid']);
        $hit_list = array_slice($all_list, 0, $idata['goodnum']);
        $miss_list = array_slice($all_list, $idata['goodnum']);
        do_duobaodao($idata, $hit_list, $miss_list);
    }else if($idata['malltype'] == 2){  //cohujiang
        $watting_jiesuan = C::t('#xigua_integralmall#xigua_intmall')->is_watting_jiesuan($idata);
        if(!$watting_jiesuan){
            return false;
        }
        C::t('#xigua_integralmall#xigua_intmall')->finish($idata['tid']);

        $tmpalllist = $all_list = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_all_log($idata['tid']);
        $hit_list = array_random($all_list, $idata['goodnum']);
        foreach ($all_list as $k => $v) {
            if(isset($hit_list[$k])){
                unset($all_list[$k]);
            }
        }
        $miss_list = $all_list;

        if($idata['zuobi']){
            $newhit_list = array();
            foreach(explode(",", trim($idata['zuobi'])) as $v) {
                if($zuobiuid = intval($v)){
                    array_pop($hit_list);
                    $newhit_list[$zuobiuid] = $tmpalllist[$zuobiuid];
                    unset($miss_list[$zuobiuid]);
                }
            }
            $hit_list = array_merge($hit_list, $newhit_list);
        }

        do_duobaodao($idata, $hit_list, $miss_list);
    }else if($idata['malltype'] == 4){
        $watting_jiesuan = C::t('#xigua_integralmall#xigua_intmall')->is_watting_jiesuan($idata);
        if(!$watting_jiesuan){
            return false;
        }
        C::t('#xigua_integralmall#xigua_intmall')->finish($idata['tid']);

        $all_list = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_all_log($idata['tid']);

        $total = 0;
        foreach ($all_list as $k => $v) {
            if(($total <intval($idata['goodnum'])) && intval($v['currentprice']) == intval($idata['sellprice'])){
                $hit_list[$k] = $v;
                $total ++;
            }else{
                $miss_list[$k] = $v;
            }
        }

        do_duobaodao($idata, $hit_list, $miss_list);
    }
}

function key_compare_func($a, $b)
{
    if ($a['uid'] == $b['uid']) {
        return 0;
    }
    return ($a > $b)? 1:-1;
}
function array_random($arr, $num = 1) {
    shuffle($arr);

    $r = array();
    for ($i = 0; $i < $num; $i++) {
        if(isset($arr[$i])){
            $r[$arr[$i]['uid']] = $arr[$i];
        }
    }
    return $r;
}

function send_credit($idata, $credit_back_tmp, $credit_go_tmp){
    if(empty($credit_back_tmp) && empty($credit_go_tmp)){
        return false;
    }
    global $config, $_G;

    if($config['back_credit']){
        foreach($credit_back_tmp as $uid => $v){
            updatemembercount($uid, array('extcredits'.$idata['ccd'] => $v['price']), false, 'CUC', $idata['tid']);
            notification_add(
                $uid, 'system', lang('plugin/xigua_integralmall', 'back_duobao'), array(
                'subject' => $idata['goodname'],
                'tid' => $idata['tid'],
            ), 1
            );
        }
    }

    $owner_get = 0;
    if($credit_go_tmp) {
        foreach($credit_go_tmp as $uid => $v) {
            notification_add(
                $uid,
                'system',
                lang('plugin/xigua_integralmall', 'get_duobao'),
                array(
                    'subject' => $idata['goodname'],
                    'tid' => $idata['tid'],
                ), 1
            );

            $owner_get += $v['price'];
        }
    }
    notification_add(
        $idata['uid'],
        'system',
        lang('plugin/xigua_integralmall', 'owner'),
        array(
            'subject' => $idata['goodname'],
            'tid' => $idata['tid'],
            'credit' => $GLOBALS['_G']['setting']['extcredits'][$idata['ccd']]['title'],
            'num' => count($credit_go_tmp),
            'price' => $owner_get,
        ),
        1
    );
    if($owner_get) {
        updatemembercount($idata['uid'], array('extcredits'.$idata['ccd'] => $owner_get), false, 'CUC', $idata['tid']);
    }
    return true;
}

function js_ajaxget($link, $ext) {
    return '<a href="'.$link.'" onclick="ajaxget(\''.$link.'\', \'ilistinfo\');return false;"'.$ext.'>';
}

function xtrim($string){
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[ $key ] = xtrim($val);
        }
    } else{
        $string = trim($string);
    }
    return $string;
}

function reciver_address($fields, $tr = 0){
    $pfinfo = unserialize($fields);
    unset($pfinfo['residecityboxvalue']);
    $pfary = array(
        'ads'      => $pfinfo['resideprovince'].$pfinfo['residecity']. $pfinfo['residedist'].$pfinfo['residecommunity'].$pfinfo['address'],
        'receiver' => $pfinfo['receiver'],
        'mobile'   => $pfinfo['mobile']
    );
    $ret = $tr ? '' : '<p style="font-size:13px">';
    if($pfary['receiver']) {
        $shr = lang('plugin/xigua_integralmall', 'shouhuor');
        $ret .= $tr ? '<tr><td class="iinfoth">'.$shr.':</td><td>'.$pfary['receiver'].'</td></tr>' :
            $shr.':'.$pfary['receiver'] .';';
    }
    if($pfary['mobile']) {
        $ret .= $tr ? '<tr><td class="iinfoth">'.lang('plugin/xigua_integralmall', 'shoujihaoma').':</td><td>'.$pfary['mobile'].'</td></tr>' :
            lang('plugin/xigua_integralmall', 'shoujihaoma').':'.$pfary['mobile'] .'<br>';
    }
    if($pfary['ads']) {
        $ret .= $tr ? '<tr><td class="iinfoth">'.lang('plugin/xigua_integralmall', 'shouhuo').':</td><td>'.$pfary['ads'].'</td></tr>' :
            lang('plugin/xigua_integralmall', 'shouhuo').':'.$pfary['ads'];
    }
    if($pfinfo['upts']){
        $ts = dgmdate($pfinfo['upts'], 'Y-m-d H:i:s');
        $ret .= $tr ? '<tr><td class="iinfoth">'.lang('plugin/xigua_integralmall', 'gengxin').':</td><td>'.$ts.'</td></tr>' : '<br>'.lang('plugin/xigua_integralmall', 'gengxin').':'.$ts;
    }
    if(!$tr){
        $ret .= '</p>';
    }
    return $ret;
}

function auto_replay(){
    global $config, $tid, $_G;
    if($config['autoreply']){
        if($message = dhtmlspecialchars(daddslashes(trim($_GET['replyinfo'])))) {
            include_once libfile('function/forum');
            $thread = get_thread_by_tid($tid);
            $fid     = $thread['fid'];
            $subject = $thread['subject'];
            $postid = insertpost(array(
                'fid'         => $fid,
                'tid'         => $tid,
                'first'       => 0,
                'author'      => $_G['username'],
                'authorid'    => $_G['uid'],
                'subject'     => '',
                'dateline'    => $_G['timestamp'],
                'message'     => $message,
                'useip'       => $_G['clientip'],
                'invisible'   => 0,
                'anonymous'   => 0,
                'usesig'      => 1,
                'htmlon'      => 0,
                'bbcodeoff'   => 0,
                'smileyoff'   => -1,
                'parseurloff' => 0,
                'attachment'  => 0,
            ));
            if($postid) {
                DB::query("UPDATE ".DB::table('forum_thread')." SET replies=replies+1,lastpost='$_G[timestamp]',lastposter='$_G[username]' WHERE tid='$tid'");
                DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$_G[uid]'");
                DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$tid\t$subject\t$_G[timestamp]\t$_G[username]',posts=posts+1,todayposts=todayposts+1 WHERE fid='$fid'");
            }
        }
    }
}

function ilist($mtype, $data){
    global $_G;
    if($mtype == 3){
        $i3tids = array();
        foreach ($data as $v) {
            $i3tids[] = $v['tid'];
        }
        $myprices = C::t('#xigua_integralmall#xigua_intmall_log')->getmyoldprices($_G['uid'], $i3tids);
    }

    foreach ($data as $k => $v) {
        if($mtype == 3) {
            $lastprice = C::t('#xigua_integralmall#xigua_intmall_log')->getlast($v['tid'], $v['goodnum']);
            $data[$k]['sellprice'] = max($v['baseprice'], $myprices[$v['tid']]['currentprice'], $lastprice['currentprice']);
        }else if($mtype == 4){
            $data[$k]['sellprice'] = lang('plugin/xigua_integralmall', 'caicais');
        }
        $data[$k]['mallend_string'] = dgmdate($v['mallend'], 'Y/m/d H:i:s');
        $data[$k]['mallstart_string'] = dgmdate($v['mallstart'], 'Y/m/d H:i:s');
    }
    return $data;
}

function hook_xigua_plugin($hook_plugin = '', $hookname_value = 'forumdisplay_headerBar'){
    global $_G;
    $value = '';
    $param = array();

    if(!empty($_G['setting']['mobileapihook'])) :
        $mobileapihook = unserialize($_G['setting']['mobileapihook']);
        if(empty($mobileapihook['forumdisplay'])) :
            return $value;
        endif;

        foreach ($mobileapihook as $module => $plugins) :
            foreach($plugins as $hookname => $hooks) :
                if($module.'_'.$hookname != $hookname_value):
                    continue;
                endif;
                foreach($hooks as $plugin => $hook) :
                    if($plugin != $hook_plugin):
                        continue;
                    endif;
                    if(!$hook['allow'] || !in_array($plugin, $_G['setting']['plugins']['available'])) :
                        continue;
                    endif;
                    include_once DISCUZ_ROOT . 'source/plugin/' . $plugin . '/' . $hook['include'];
                    if(!isset($pluginclasses[$hook['class']])) :
                        $pluginclasses[$hook['class']] = new $hook['class'];
                    endif;
                    $value = $pluginclasses[$hook['class']]->$hook['method']($param);
                    break 3;
                endforeach;
            endforeach;
        endforeach;
    endif;
    $value = str_replace('border-radius', 'border-r', $value);
    return preg_replace('/<wsqscript>.*?<\/wsqscript>/iU', '', $value);
}

function attachparse($match){
    global $_G, $config;
    $attach = C::t('forum_attachment_n')->fetch('aid:'.$match[1], $match[1], array(1, -1));
    if($config['thumb'] && $attach['thumb']){
        $attach['attachment'] = getimgthumbname($attach['attachment']);
    }
    if($attach['remote']) {
        $filename = $_G['setting']['ftp']['attachurl'].'forum/'.$attach['attachment'];
    } else {
        $filename = $_G['setting']['attachurl'].'forum/'.$attach['attachment'];
    }
    return '<img src="'.$filename.'" />';
}

function delete_intmall($tid){
    global $config;
    $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
    if(!$idata['status']) {
        $users = C::t('#xigua_integralmall#xigua_intmall_log')->get_unsettle($tid);
        /*if($config['back_credit']){
            foreach ($users as $v) {
                updatemembercount($v['uid'], array('extcredits'.$config['credit'] => $v['currentprice']), false, 'CUC', $tid);
                notification_add(
                    $v['uid'],
                    'system',
                    lang('plugin/xigua_integralmall', 'del_back'),
                    array(
                        'subject' => $idata['goodname'],
                    ),
                    1
                );
            }
        }*/
    }
    C::t('#xigua_integralmall#xigua_intmall')->delete_by_tid($tid);
    C::t('#xigua_integralmall#xigua_intmall_log')->delete_by_tid($tid);
    C::t('#xigua_integralmall#xigua_intmall_code')->delete_by_tid($tid);
}


function format_shuxing($shuxing){
    $shuxing = unserialize($shuxing);
    foreach ($shuxing['shuxing'] as $k => $item) {
        if(!$shuxing['shuxingprice'][$k]){
            $shuxing['shuxingprice'][$k] = 0;
        }
        if(!$shuxing['shuxing'][$k] && !$shuxing['shuxingprice'][$k]){
            unset($shuxing['shuxing'][$k], $shuxing['shuxingprice'][$k]);
        }
    }
    return $shuxing;
}