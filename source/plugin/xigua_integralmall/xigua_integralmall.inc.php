<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/27
 * Time: 14:46
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT . 'source/plugin/xigua_integralmall/init.php';
//sleep(9999);
$allows = array('', 'view', 'message', 'view_message', 'viewthread');
$operation = trim($_GET['operation']);
$_G['tid'] = $tid = intval($_GET['tid']);

if(!$_G['uid'] && !in_array($operation, $allows)) {
    showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
}

if($operation == 'myprofile'){
    if(submitcheck('formhash')){
        $pf = $_GET['pf'];
        $pf['residecityboxvalue'] = base64_encode(strip_tags($pf['residecityboxvalue'], '<select><option>'));
        $pf['resideprovince'] = $_GET['resideprovince'];
        $pf['residecity'] = $_GET['residecity'];
        $pf['residedist'] = $_GET['residedist'];
        $pf['residecommunity'] = $_GET['residecommunity'];
        $pf['upts'] = $_G['timestamp'];

        $pf = xtrim((dhtmlspecialchars($pf)));
        C::t('#xigua_integralmall#xigua_intmall_receiver')->insert(array(
            'uid' => $_G['uid'],
            'fields' => serialize($pf),
        ), false, true);
        showmessage(lang('plugin/xigua_integralmall', 's1'), 'forum.php?mod=viewthread&tid='.$tid);
    }else{
        include_once libfile('function/profile');
        $birthcityhtml = showdistrict(
            array(0,0,0),
            array('resideprovince', 'residecity', 'residedist'),
            'residecitybox', 3, 'reside');

        $pf = C::t('#xigua_integralmall#xigua_intmall_receiver')->fetch($_G['uid']);
        if($pf['fields']){
            $pfinfo = unserialize($pf['fields']);
            $oldhtml = base64_decode($pfinfo['residecityboxvalue']);
            if($oldhtml){
                $birthcityhtml = $oldhtml;
            }
        }

        include template('xigua_integralmall:myprofile');
    }
    exit;
}elseif($operation == 'viewprofile'){
    $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
    $ruid = intval($_GET['reciver_uid']);
    $canadmin = ($_G['adminid']) == 1 || ($_G['uid'] == $idata['uid']);
    if($canadmin || $_G['uid'] == $ruid){
        if(submitcheck('formhash') && $canadmin){
            if(empty($ruid)){
                showmessage(lang('plugin/xigua_integralmall', 's5'));
            }
            if(empty($_GET['kuaidi'])){
                showmessage(lang('plugin/xigua_integralmall', 's4'));
            }
            $sendinfo['kuaidi'] = dhtmlspecialchars(daddslashes(trim($_GET['kuaidi'])));
            $sendinfo['crts'] = $_G['timestamp'];
            $_GET['beizhu'] && $sendinfo['beizhu'] = dhtmlspecialchars(daddslashes(trim($_GET['beizhu'])));

            if(C::t('#xigua_integralmall#xigua_intmall_code')->update_sendinfo($tid, $ruid, serialize($sendinfo))){
                showmessage(lang('plugin/xigua_integralmall', 's2'), '', '', array('showdialog' => true, 'closetime' => 3, 'extrajs' => '<script>setTimeout(function(){hideWindow(\'iextraform\')}, 2000);</script>'));
            }else{
                showmessage(lang('plugin/xigua_integralmall', 's3'));
            }
        }else {
            $pf = C::t('#xigua_integralmall#xigua_intmall_receiver')->fetch($ruid);
            if ($pf['fields']) {
                $pfary = reciver_address($pf['fields'], 1);
            }
            $codeinfo = C::t('#xigua_integralmall#xigua_intmall_code')->get_code($ruid, $tid);
            $codeinfo = $codeinfo[0];
            if($codeinfo['hassend']){
                $sendinfo = unserialize($codeinfo['sendinfo']);
                $kuaidi   = $sendinfo['kuaidi'];
                $crts     = dgmdate($sendinfo['crts'], 'Y-m-d H:i:s');
                $beizhu   = $sendinfo['beizhu'];
            }else if(!$canadmin){
                $crts = $beizhu = '-';
                $kuaidi = lang('plugin/xigua_integralmall', 's0');
            }
            include template('xigua_integralmall:view_reciver');
        }
    }
    exit;
}

include_once libfile('function/forum');
$thread = get_thread_by_tid($tid);
$idata = array();

if($thread) {
    $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
    end_duobaodao($idata);
}
if($operation){
    if(!$thread || !$idata) {
        showmessage(lang('plugin/xigua_integralmall', 'ss'), '', '', array('showdialog' => true));
    }
    if(!in_array($operation, $allows) && $idata['mallend'] < $_G['timestamp']) {
        showmessage(lang('plugin/xigua_integralmall', 'ss'), '', '', array('showdialog' => true));
    }
}
if(
    $config['zhoutip'] &&
    $idata['goodkind'] ==2 &&
    ($operation == 'join' || $operation =='joinduobao')
){
    if(!C::t('#xigua_integralmall#xigua_intmall_receiver')->fetch($_G['uid'])){
        showmessage($config['zhoutip'], '', '', array('showdialog' => true));
    }
}

switch($operation){
    case 'join':

        $allowgroup = unserialize($config['allowgroup']);
        if(!in_array($_G['groupid'], $allowgroup)){
            showmessage(lang('plugin/xigua_integralmall', 'wuquan'));
        }

        $mycredict = getuserprofile('extcredits'.$idata['ccd']);
        if($idata['malltype'] == 5){
            $_GET['shuxing'] = intval($_GET['shuxing']);
            $idata['shuxing'] = format_shuxing($idata['shuxing']);
            if(!$price = $idata['shuxing']['shuxingprice'][$_GET['shuxing']]){
                showmessage(lang('plugin/xigua_integralmall', 'sorrydui'), 'forum.php?mod=viewthread&tid='.$tid);
            }
            $current_price = $idata['sellprice'] = $price;
        }else{
            $current_price = $idata['sellprice'];
        }

        if(submitcheck('formhash')){

            if($idata['malltype'] == 4){
                $current_price = dintval($_GET['myprice']);
                if($current_price <1){
                    showmessage(sprintf(lang('plugin/xigua_integralmall', 'jcs'), $GLOBALS['_G']['setting']['extcredits'][$idata['ccd']]['title']), 'forum.php?mod=viewthread&tid='.$tid);
                }
            }


            if($mycredict <$current_price) {
                showmessage(lang('plugin/xigua_integralmall', 'noen',
                    array(
                        'price' => $current_price,
                        'title' => $GLOBALS['_G']['setting']['extcredits'][$idata['ccd']]['title'],
                        'ext' => $mycredict,
                        'unit' => $GLOBALS['_G']['setting']['extcredits'][$idata['ccd']]['unit'],
                    ), true), 'forum.php?mod=viewthread&tid='.$tid
                );
            }
            $t = intval($idata['lognum']);

            if($idata['malltype'] == 1 || $idata['malltype'] == 5){

                if(($t> $idata['goodnum']-1) || $idata['goodnum'] <1){
                    showmessage(lang('plugin/xigua_integralmall', 'sorrydui'), 'forum.php?mod=viewthread&tid='.$tid);
                }
                if(C::t('#xigua_integralmall#xigua_intmall_log')->getmycount($_G['uid'], $tid)>= intval($config['maxdui'])){
                    showmessage(lang('plugin/xigua_integralmall', 'sorryhas'), 'forum.php?mod=viewthread&tid='.$tid);
                }

                updatemembercount($_G['uid'], array('extcredits'.$idata['ccd'] => -$current_price), false, 'CUC', $tid);
                $insert_data = array(
                    'tid' => $tid,
                    'uid' => $_G['uid'],
                    'username' => $_G['username'],
                    'dateline' => $_G['timestamp'],
                    'currentprice' => $current_price,
                    'extra' => $_GET['shuxing'],
                );
                C::t('#xigua_integralmall#xigua_intmall_log')->insert($insert_data);

                do_duobaodao($idata, array($insert_data), array());
            }elseif($idata['malltype'] == 2){
                if(C::t('#xigua_integralmall#xigua_intmall_log')->getmyoldprice($_G['uid'], $tid)){
                    showmessage(lang('plugin/xigua_integralmall', 'choujiangw'), 'forum.php?mod=viewthread&tid='.$tid);
                }
                updatemembercount($_G['uid'], array('extcredits'.$idata['ccd'] => -$current_price), false, 'CUC', $tid);
                C::t('#xigua_integralmall#xigua_intmall_log')->insert(array(
                    'tid' => $tid,
                    'uid' => $_G['uid'],
                    'username' => $_G['username'],
                    'dateline' => $_G['timestamp'],
                    'currentprice' => $current_price,
                    'extra' => '',
                ));
            }else if($idata['malltype'] ==4){
                if(C::t('#xigua_integralmall#xigua_intmall_log')->getmyoldprice($_G['uid'], $tid)){
                    showmessage(lang('plugin/xigua_integralmall', 'scss'), 'forum.php?mod=viewthread&tid='.$tid);
                }
                updatemembercount($_G['uid'], array('extcredits'.$idata['ccd'] => -$current_price), false, 'CUC', $tid);
                C::t('#xigua_integralmall#xigua_intmall_log')->insert(array(
                    'tid' => $tid,
                    'uid' => $_G['uid'],
                    'username' => $_G['username'],
                    'dateline' => $_G['timestamp'],
                    'currentprice' => $current_price,
                    'extra' => '',
                ));
            }

            auto_replay();
            C::t('#xigua_integralmall#xigua_intmall')->incr_hit($tid, 1, 1);
            showmessage(sprintf(lang('plugin/xigua_integralmall', 'gxcg'), $titles[$idata['malltype']]), 'forum.php?mod=viewthread&tid='.$tid);

        }else{
            include template('xigua_integralmall:join');
        }
        break;
    case 'joinduobao':

        $allowgroup = unserialize($config['allowgroup']);
        if(!in_array($_G['groupid'], $allowgroup)){
            showmessage(lang('plugin/xigua_integralmall', 'wuquan'));
        }

        $mycredict = getuserprofile('extcredits'.$idata['ccd']);
        if(submitcheck('formhash')){

            $myprice = dintval($_GET['myprice']);

            $last = C::t('#xigua_integralmall#xigua_intmall_log')->getlast($tid, $idata['goodnum']);
            $myoldprice = C::t('#xigua_integralmall#xigua_intmall_log')->getmyoldprice($_G['uid'], $tid);

            if(!$last['currentprice']){
                if($myoldprice['currentprice']){
                    $last['currentprice'] = $myoldprice['currentprice'];
                }else{
                    $last['currentprice'] = $idata['baseprice'];
                }
            }

            if($myprice <$last['currentprice'] + $idata['rangeprice']) {
                showmessage(lang('plugin/xigua_integralmall', 'guodi'), 'forum.php?mod=viewthread&tid='.$tid);
            }

            if($myprice> $last['currentprice'] + $idata['rangemaxprice']){
                showmessage(lang('plugin/xigua_integralmall', 'guogao'), 'forum.php?mod=viewthread&tid='.$tid);
            }

            if($mycredict <$myprice-intval($myoldprice['currentprice'])) {
                showmessage(lang('plugin/xigua_integralmall', 'noen',
                    array(
                        'price' => $myprice,
                        'title' => $GLOBALS['_G']['setting']['extcredits'][$idata['ccd']]['title'],
                        'ext' => $mycredict,
                        'unit' => $GLOBALS['_G']['setting']['extcredits'][$idata['ccd']]['unit'],
                    ), true), 'forum.php?mod=viewthread&tid='.$tid
                );
            }

            if($myoldprice) {
                $freeze_price = $myprice - $myoldprice['currentprice'];
            } else {
                $freeze_price = $myprice;
            }

            updatemembercount($_G['uid'], array('extcredits'.$idata['ccd'] => -$freeze_price), false, 'CUC', $tid);

            if($myoldprice){
                C::t('#xigua_integralmall#xigua_intmall_log')->update($myoldprice['lid'], array(
                    'dateline' => $_G['timestamp'],
                    'currentprice' => $myprice,
                    'extra' => '',
                ));
            }else{
                C::t('#xigua_integralmall#xigua_intmall_log')->insert(array(
                    'tid' => $tid,
                    'uid' => $_G['uid'],
                    'username' => $_G['username'],
                    'dateline' => $_G['timestamp'],
                    'currentprice' => $myprice,
                    'extra' => '',
                ));
            }

            auto_replay();

            C::t('#xigua_integralmall#xigua_intmall')->incr_hit($tid, 1, 1);
            showmessage(lang('plugin/xigua_integralmall', 'succeed'), 'forum.php?mod=viewthread&tid='.$tid);
        }else{

            $last = C::t('#xigua_integralmall#xigua_intmall_log')->getlast($tid, $idata['goodnum']);
            $myoldprice = C::t('#xigua_integralmall#xigua_intmall_log')->getmyoldprice($_G['uid'], $tid);
            $current_price = max($last['currentprice'], $idata['baseprice'], $myoldprice['currentprice']);

            $can_max_price = $current_price + $idata['rangemaxprice'];
            $can_min_price = $current_price + $idata['rangeprice'];


            include template('xigua_integralmall:join_duobao');
        }
        break;
    case 'view':
        $page = max(1, intval(getgpc('page')));
        $lpp   = 10;
        $start_limit = ($page - 1) * $lpp;
        $finish = (($idata['mallend'] <$_G['timestamp']) || !$idata['leavenum']);

        if($icount = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_all_by_count($tid)){
            $ilist =  C::t('#xigua_integralmall#xigua_intmall_log')->fetch_all_by_page($tid, $start_limit, $lpp, $idata['goodnum']);
        }

        $realpages = @ceil($icount / $lpp);
        $_G['gp_ajaxtarget'] = '';
        $multi = multi($icount, $lpp, $page, 'plugin.php?id=xigua_integralmall&operation=view&tid='.$tid);
        $multi = preg_replace("/<a\shref=\"([\s\S]*?)\"(.*?)>/ies", "js_ajaxget('\\1','\\2')", $multi);
        $multi = str_replace('\"', '"', $multi);
        include template('xigua_integralmall:viewlist');
        break;
    case 'view_message':
        if(($_G['adminid'] == 1 || $_G['uid'] == $idata['uid'])){
            $codeinfo = C::t('#xigua_integralmall#xigua_intmall_code')->get_code(0, $tid);
            if($idata['goodkind'] == 1){
                $showcodeinfo = 1;
                foreach ($codeinfo as $k => $v) {
                    $codeinfo[$k]['stat'] = $v['uid'] ? '<span class="icons iconsright"></span> '.lang('plugin/xigua_integralmall', 'yifa') : '<span class="icons iconsinfo"></span> '.lang('plugin/xigua_integralmall', 'weifa');
                }
            }else if($idata['goodkind'] == 2){  //shiwushangpin
                $showcodeinfo = 0;
                foreach ($codeinfo as $k => $v) {
                    if($v['uid']){
                        $atag = '<a href="javascript:void(0);" onclick="return send_good('.$v['uid'].');">';

                        $codeinfo[$k]['stat'] = $v['hassend'] ? '<span class="icons iconsright"></span> '.$atag.lang('plugin/xigua_integralmall', 'yifahuo').'</a>' : '<span class="icons iconsinfo"></span>'.$atag.lang('plugin/xigua_integralmall', 'dianjifahuo').'</a>';
                        $receivers[] = $v['uid'];
                    }else{
                        $codeinfo[$k]['stat'] = '<span class="icons iconsnone"></span> '.lang('plugin/xigua_integralmall', 'bunengfa');
                    }
                }
                if($receivers){
                    $pfary = array();
                    $pfs = C::t('#xigua_integralmall#xigua_intmall_receiver')->fetch_all($receivers);
                    foreach ($pfs as $v) {
                        if($v['fields']){
                            $pfary[$v['uid']] = reciver_address($v['fields']);
                        }
                    }
                }
            }
            include template('xigua_integralmall:view_message');
        }else{
            showmessage(lang('plugin/xigua_integralmall', 'wuquan'));
        }
        break;
    case 'viewthread':
        if(!checkmobile()){
            dheader('location:forum.php?mod=viewthread&tid='.$tid);
            exit;
        }
        $navtitle = $idata['goodname'];
        include_once DISCUZ_ROOT .'source/plugin/xigua_integralmall/special.class.php';
        $s = new threadplugin_xigua_integralmall();
        $ret = $s->viewthread($tid, 1, $idata);
        extract($ret);

        $mycredict = getuserprofile('extcredits'.$idata['ccd']);
        $rtnav = $nav = array();
        if($config['nav']){
            foreach (array_filter(explode("\n", str_replace("\r", '', trim($config['nav'])))) as $k => $v) {
                $nav[] = explode(',', trim($v));
            }
        }
        if($config['rtnav']){
            foreach (array_filter(explode("\n", str_replace("\r", '', trim($config['rtnav'])))) as $k => $v) {
                $rtnav[] = explode(',', trim($v));
            }
        }

        if(!$_GET['ifr']){
            $firstpost = C::t('forum_post')->fetch_threadpost_by_tid_invisible($tid);
            $pid = $firstpost['pid'];

            include_once libfile('function/discuzcode');
            $message = discuzcode($firstpost['message']);
            $sppos = strpos($message, chr(0).chr(0).chr(0));
            if($sppos !== false) {
                $message = substr($message, 0, $sppos);
            }
            $message = preg_replace_callback("/\[attach\](\d+)\[\/attach\]/i", 'attachparse', $message);
        }

        include_once template('xigua_integralmall:viewthread');
        break;
    default:
        $mycredict = getuserprofile('extcredits'.$setting_credit);
        $rtnav = $nav = array();
        if($config['nav']){
            foreach (array_filter(explode("\n", str_replace("\r", '', trim($config['nav'])))) as $k => $v) {
                $nav[] = explode(',', trim($v));
            }
        }
        if($config['rtnav']){
            foreach (array_filter(explode("\n", str_replace("\r", '', trim($config['rtnav'])))) as $k => $v) {
                $rtnav[] = explode(',', trim($v));
            }
        }
        if($_G['uid'] && $_GET['count'] == 1 && $_GET['formhash'] == FORMHASH){
            $myjoin = $mycount = 0;
            $mycount = C::t('#xigua_integralmall#xigua_intmall')->fetch_my_count($_G['uid']);
            $myjoin = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_my_count($_G['uid']);
            include template('common/header');
            $faqi = lang('plugin/xigua_integralmall', 'faqi');
            $canyu = lang('plugin/xigua_integralmall', 'canyu');
            echo <<<HTML
<p class="my_p"><a href="plugin.php?id=xigua_integralmall&my=my">$faqi<em>$mycount</em></a></p>
<p class="my_p"><a href="plugin.php?id=xigua_integralmall&my=join">$canyu<em>$myjoin</em></a></p>
HTML;
            include template('common/footer');
            exit;
        }

        $page = max(1, intval(getgpc('page')));
        $lpp   = 12;
        $start_limit = ($page - 1) * $lpp;

        if(($mtype = intval($_GET['mtype']) ) && in_array($mtype, array_keys($ini['malltypes']))){
            $icount = C::t('#xigua_integralmall#xigua_intmall')->fetch_by_count($mtype);
            $ilist[$mtype] = C::t('#xigua_integralmall#xigua_intmall')->fetch_by_per_page($mtype, $start_limit, $lpp);
            $multi = multi($icount, $lpp, $page, "plugin.php?id=xigua_integralmall&mtype=$mtype", 0, 5);
            $noheader = 1;

            $ilist[$mtype] = ilist($mtype, $ilist[$mtype]);

            $realpages = @ceil($icount / $lpp);
            include template('diy:xindex', 0, 'source/plugin/xigua_integralmall/template');

            exit;
        }

        if($_G['uid'] && $my = $_GET['my']){
            if($my == 'my'){
                $navtitle = lang('plugin/xigua_integralmall', 'wofaqi');
                $mycount = C::t('#xigua_integralmall#xigua_intmall')->fetch_my_count($_G['uid']);
                $ilist   = C::t('#xigua_integralmall#xigua_intmall')->fetch_my_by_page($_G['uid'], $start_limit, $lpp);
            }else{
                $navtitle = lang('plugin/xigua_integralmall', 'wocanyu');
                $my = 'join';
                $mycount = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_my_count($_G['uid']);
                $tids = C::t('#xigua_integralmall#xigua_intmall_log')->fetch_my_logs($_G['uid'], $start_limit, $lpp);
                $ilist   = C::t('#xigua_integralmall#xigua_intmall')->fetch_my_by_page(0, 0, 0, $tids);
            }
            if($ilist){
                foreach ($ilist as $k => $v) {
                    $ilist[$k] = ilist($k, $ilist[$k]);
                }
            }

            $multi = multi($mycount, $lpp, $page, "plugin.php?id=xigua_integralmall&my=$my", 0, 5);
            $noheader = 1;

            $realpages = @ceil($mycount / $lpp);
            include template('diy:xindex', 0, 'source/plugin/xigua_integralmall/template');

            exit;
        }

        foreach ($ini['malltypes'] as $k => $v) {
            $ilist[$k] = C::t('#xigua_integralmall#xigua_intmall')->fetch_by_per_page($k, 0, abs($config['pcpage1']));
            $ilist[$k] = ilist($k, $ilist[$k]);
        }

        $slderindex = array();
        if($config['slderindex']){
            foreach (array_filter(explode("\n", str_replace("\r", '', trim($config['slderindex'])))) as $k => $v) {
                $slderindex[] = explode(',', trim($v));
            }
        }

        if($config['pcnav']){
            foreach (array_filter(explode("\n", str_replace("\r", '', trim($config['pcnav'])))) as $k => $v) {
                $pcnav[] = explode(',', trim($v));
            }
        }

        include template('diy:xindex', 0, 'source/plugin/xigua_integralmall/template');
        break;
}