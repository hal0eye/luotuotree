<?php
/**
 * Created by PhpStorm.
 * User: yangzhiguo
 * Date: 15/7/19
 * Time: 20:42
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT . 'source/plugin/xigua_integralmall/init.php';


class threadplugin_xigua_integralmall{
    public $config = array();
    public $name = XIGUA_INTEGRALMALL_NAME;
    public $buttontext = XIGUA_INTEGRALMALL_BUTTONTEXT;
	public $iconfile = 'static/images/icon.png';

    public function __construct(){
        global $config;
        $this->config = $config;
    }

    public function set_cover($aid, $pid, $tid)
    {
        global $_G;
        $attachtable = DB::result_first('SELECT tableid FROM %t WHERE aid=%d', array(
            'forum_attachment', $aid
        ));
        if(!$attachtable){
            $attachment = DB::fetch_first('SELECT * FROM %t WHERE aid=%d AND uid=%d AND isimage=1', array(
                'forum_attachment_unused', $aid, $_G['uid']
            ));
        }
        $attachtable = $attachtable == 127 ? 'unused' : $attachtable;

        if ($attachtable && empty($attachment)) {
            $attachment = DB::fetch_first('SELECT * FROM %t WHERE aid=%d AND uid=%d AND isimage=1', array(
                'forum_attachment_'.$attachtable, $aid, $_G['uid']
            ));
        }
        if(empty($attachment)) {
            return true;
//            showmessage(lang('plugin/xigua_integralmall', 'fengmian'));
        }
        if($attachtable == 'unused') {
            convertunusedattach($aid, $tid, $pid);
        }
        $tableid = DB::result_first('SELECT posttableid FROM %t WHERE tid=%d', array(
            'forum_thread', $tid
        ));
        if(!$tableid) {
            $tablename = 'forum_post';
        } else {
            $tablename = "forum_post_$tableid";
        }
        DB::query('UPDATE %t SET attachment=2 WHERE tid=%d', array(
            'forum_thread', $tid
        ));
        DB::query('UPDATE %t SET attachment=2 WHERE pid=%d', array(
            $tablename, $pid
        ));

        if(setthreadcover(0, 0, $aid)) {
            $threadimage = DB::fetch_first('SELECT tid, pid, attachment, remote FROM %t WHERE aid=%d', array(
                getattachtablebyaid($aid), $aid
            ));
            $threadimage = daddslashes($threadimage);
            DB::delete('forum_threadimage', "tid='$threadimage[tid]'");
            DB::insert('forum_threadimage', array(
                'tid' => $threadimage['tid'],
                'attachment' => $threadimage['attachment'],
                'remote' => $threadimage['remote'],
            ));
        }
        return TRUE;
    }

    public function check_isimage($tid){
        $imgaids = array();
        $query = DB::query("SELECT a.aid,a.tableid from " . DB::table('forum_attachment') . " as a  where a.tid='$tid'");
        while($arow = DB::fetch($query))
        {
            $arow['tableid'] = $arow['tableid'] == 127 ? 'unused' : $arow['tableid'];

            $table = DB::table('forum_attachment_'.intval($arow['tableid']));
            $aid   = $arow['aid'];
            $row = DB::fetch(DB::query("SELECT aid FROM $table WHERE aid='$aid' AND isimage IN (-1,1) LIMIT 1"));
            if($row['aid']){
                $imgaids[] = $row['aid'];
            }
        }
        return $imgaids;
    }

    public static function is_virtual($data)
    {
        return $data['goodkind'] == 1;
    }

    public function get_input()
    {
        $data = array();
        $data['goodkind']             = intval($_GET['goodkind']);
        $data['virtualcode']          = array_filter(explode("\n", str_replace("\r", '', trim($_GET['virtualcode']))));
        $data['goodname']             = cutstr(trim($_GET['goodname']), 200);
        $data['marketprice']          = intval($_GET['marketprice']);
        $data['goodnum']              = intval($_GET['goodnum']);
        $data['mallstart']            = strtotime($_GET['mallstart']);
        $data['mallend']              = strtotime($_GET['mallend']);

        $data['integralmall_aid']     = intval($_GET['integralmall_aid']);
        $data['integralmall_url']     = $_GET['integralmall_url'];
        $data['malltype']             = intval($_GET['malltype']);
        $data['sellprice']            = intval($_GET['sellprice']);
        $data['baseprice']            = intval($_GET['baseprice']);
        $data['rangeprice']           = intval($_GET['rangeprice']);
        $data['rangemaxprice']        = intval($_GET['rangemaxprice']);
        $data['ccd']                  = intval($_GET['ccd']);
        $data['zuobi']                = $_GET['zuobi'];
        $data['shuxing']               = $_GET['shuxing'];
        $data['shuxingprice']          = $_GET['shuxingprice'];


        if(empty($data['malltype']) || !in_array($data['malltype'], array(1, 2, 3, 4, 5))) {
            showmessage(lang('plugin/xigua_integralmall', 'j1'));
        }

        if(empty($data['goodkind']) || !in_array($data['goodkind'], array(1, 2))) {
            showmessage(lang('plugin/xigua_integralmall', 'j2'));
        }
        if (self::is_virtual($data)) {
            $data['goodnum'] = count($data['virtualcode']);
            if ($data['goodnum']<=0) {
                showmessage(lang('plugin/xigua_integralmall', 'j3'));
            }
        }else{
            if ($data['goodnum']<=0) {
                showmessage(lang('plugin/xigua_integralmall', 'j4'));
            }
        }

        if(empty($data['goodname'])) {
            showmessage(lang('plugin/xigua_integralmall', 'j5'));
        }
        if($data['marketprice'] <0) {
            showmessage(lang('plugin/xigua_integralmall', 'j6'));
        }
        if(empty($data['mallstart'])) {
            showmessage(lang('plugin/xigua_integralmall', 'j7'));
        }
        if(empty($data['mallend'])) {
            showmessage(lang('plugin/xigua_integralmall', 'j8'));
        }
        if($data['mallend']-$data['mallstart']<=60){
            showmessage(lang('plugin/xigua_integralmall', 'j9'));
        }

        if($data['malltype'] == 3){
            if ($data['baseprice']<0) {
                showmessage(lang('plugin/xigua_integralmall', 'j10'));
            }
            if ($data['rangeprice']<0) {
                showmessage(lang('plugin/xigua_integralmall', 'j11'));
            }
            if ($data['rangemaxprice']<0) {
                showmessage(lang('plugin/xigua_integralmall', 'j12'));
            }
            if($data['rangemaxprice'] && $data['rangemaxprice']<$data['rangeprice']){
                showmessage(lang('plugin/xigua_integralmall', 't9'));
            }
        }else if($data['malltype'] == 5){
            if(!$data['shuxing'] || !$data['shuxingprice']){
                showmessage(lang('plugin/xigua_integralmall', 'p1'));
            }
        }else{
            if($data['sellprice']<0){
                showmessage(lang('plugin/xigua_integralmall', 'j13'));
            }
        }

//        if (! ($data['integralmall_aid'] && $data['integralmall_url'])) {
//            if(!$this->edit){
//                showmessage(lang('plugin/xigua_integralmall', 'fengmian'));
//            }
//        }

        return $data;
    }

    public function newthread($fid) {
        global $_G;
        $return = '';
        $edit = 0;

        include template('xigua_integralmall:newthread');
        return $return;
    }

    public function newthread_submit($fid) {
        global $modnewthreads,$displayorder, $integralmall;

        $integralmall = $this->get_input();

        $goodname = censor(dhtmlspecialchars($integralmall['goodname']));
        $modnewthreads = censormod($goodname) ? 1 : 0;
        $displayorder  = $modnewthreads ? -2 : 0;
    }

    public function newthread_submit_end($fid, $tid) {
        global $_G, $pid, $integralmall, $params;
        $aid = $integralmall['integralmall_aid'];

        $this->set_cover($aid, $pid, $tid);

        $message = $params['message'];
        if(strpos($message, '[/attach]') !== FALSE || strpos($message, '[/attachimg]') !== FALSE){
            if(preg_match_all("/\[attach(img)?\](\d+)\[\/attach(img)?\]/i", $message, $matchaids)) {
                $unsetaids = $matchaids[2];
            }
        }
        $aids = array($aid => 1);
        if($attachnew = $this->check_isimage($tid)){
            foreach ($attachnew as $v) {
                if(!in_array($v, $unsetaids)){
                    $aids[$v] = 1;
                }
            }
        }
        $aids = array_keys($aids);

        $insertdata = array(
            'tid'           => $tid,
            'uid'           => $_G['uid'],
            'aid'           => implode(',', $aids),
            'author'        => $_G['username'],
            'goodkind'      => $integralmall['goodkind'],
            'goodname'      => $integralmall['goodname'],
            'marketprice'   => $integralmall['marketprice'],
            'goodnum'       => $integralmall['goodnum'],
            'mallstart'     => $integralmall['mallstart'],
            'mallend'       => $integralmall['mallend'],
            'malltype'      => $integralmall['malltype'],
            'sellprice'     => $integralmall['sellprice'],
            'baseprice'     => $integralmall['baseprice'],
            'rangeprice'    => $integralmall['rangeprice'],
            'rangemaxprice' => $integralmall['rangemaxprice'],
            'lastpost'      => '',
            'give'          => 0,
            'hot'           => 0,
            'status'        => 0,
            'ccd'           => $integralmall['ccd'],
            'zuobi'         => $integralmall['zuobi'],
            'shuxing'       => serialize(array(
                'shuxing'      => $integralmall['shuxing'],
                'shuxingprice' => $integralmall['shuxingprice']
            )),
        );
        C::t('#xigua_integralmall#xigua_intmall')->insert($insertdata);

        if($integralmall['virtualcode']) {
            C::t('#xigua_integralmall#xigua_intmall_code')->inserts($tid, $integralmall['virtualcode']);
        }else{
            for($i = 0; $i <$integralmall['goodnum']; $i ++){
                $goods[] = $integralmall['goodname'];
            }
            C::t('#xigua_integralmall#xigua_intmall_code')->inserts($tid, $goods);
        }
    }

    public function editpost($fid, $tid) {
        global $_G, $ini;
        $return = '';

        if($idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid)) {
            $finish = $idata['mallend'] <$_G['timestamp'];
            $idata['mallstart'] = dgmdate($idata['mallstart'], 'Y-m-d H:i');
            $idata['mallend'] = $idata['mallend'] ? dgmdate($idata['mallend'], 'Y-m-d H:i') : '';

            if($idata['aid']) {
                $aids = explode(',', $idata['aid']);
                $aid = $aids[0];
                $oldattach = C::t('forum_attachment_n')->fetch('aid:'.$aid, $aid);
                if($oldattach['remote']) {
                    $oldattach['attachment'] = $_G['setting']['ftp']['attachurl'].'forum/'.$oldattach['attachment'];
                    $oldattach['attachment'] = substr($oldattach['attachment'], 0, 7) != 'http://' ? 'http://'.$oldattach['attachment'] : $oldattach['attachment'];
                } else {
                    $oldattach['attachment'] = $_G['setting']['attachurl'].'forum/'.$oldattach['attachment'];
                }
            }
            if($idata['goodkind'] == 1){
                if($code = C::t('#xigua_integralmall#xigua_intmall_code')->fetch_unuse_code($tid)){
                    $tmp = array();
                    foreach ($code as $v) {
                        $tmp[] = $v['code'];
                    }
                    $retcode = implode("\r\n", $tmp);
                }
            }
        } else {
            return $return;
        }

        $edit = 1;
        $idata['shuxing'] = format_shuxing($idata['shuxing']);
        include template('xigua_integralmall:newthread');
        return $return;
    }

    public function editpost_submit($fid, $tid) {
        global $modnewthreads,$displayorder, $integralmall;

        $this->edit = 1;
        $integralmall = $this->get_input();

        $goodname = censor(dhtmlspecialchars($integralmall['goodname']));
        $modnewthreads = censormod($goodname) ? 1 : 0;
        $displayorder  = $modnewthreads ? -2 : 0;

    }


    public function editpost_submit_end($fid, $tid) {
        global $_G, $pid, $integralmall, $param;
        $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
        $tmpaid = explode(',', $idata['aid']);

        if($aid = $integralmall['integralmall_aid']){
            if(DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_attachment_unused')." WHERE aid='$aid' AND uid='{$_G[uid]}'")) {

                if($tmpaid[0]) {
                    $att = DB::fetch_first("SELECT aid,tid,tableid FROM ".DB::table('forum_attachment')." WHERE aid='$tmpaid[0]'");
                    if(is_numeric($att['tableid'])){
                        $attach = DB::fetch_first("SELECT tid, pid, attachment, thumb, remote, aid FROM ".DB::table('forum_attachment_'.$att['tableid'])." WHERE aid='$tmpaid[0]'");
                        dunlink($attach);
                        DB::query("DELETE FROM ".DB::table('forum_attachment_'.$att['tableid'])." WHERE aid='$tmpaid[0]'");
                        DB::query("DELETE FROM ".DB::table('forum_attachment')." WHERE aid='$tmpaid[0]'");
                    }
                }

                $this->set_cover($aid, $pid, $tid);
            }
        }else{
            $aid = $tmpaid[0];
        }

        $message = $param['message'];
        if(strpos($message, '[/attach]') !== FALSE || strpos($message, '[/attachimg]') !== FALSE){
            if(preg_match_all("/\[attach(img)?\](\d+)\[\/attach(img)?\]/i", $message, $matchaids)) {
                $unsetaids = $matchaids[2];
            }
        }
        $aids = array($aid => 1);
        if($attachnew = $this->check_isimage($tid)){
            foreach ($attachnew as $v) {
                if(!in_array($v, $unsetaids)){
                    $aids[$v] = 1;
                }
            }
        }
        $aids = array_keys($aids);

        $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
        if(!$integralmall['virtualcode'] && abs($idata['lognum']) >abs($integralmall['goodnum'])){
            $integralmall['goodnum'] = abs($idata['lognum']);
        }

        $update_data = array(
            'aid'           => implode(',', $aids),
            'goodkind'      => $integralmall['goodkind'],
            'goodname'      => $integralmall['goodname'],
            'marketprice'   => $integralmall['marketprice'],
            'goodnum'       => $integralmall['goodnum'],
            'mallstart'     => $integralmall['mallstart'],
            'mallend'       => $integralmall['mallend'],
            'malltype'      => $integralmall['malltype'],
            'sellprice'     => $integralmall['sellprice'],
            'baseprice'     => $integralmall['baseprice'],
            'rangeprice'    => $integralmall['rangeprice'],
            'rangemaxprice' => $integralmall['rangemaxprice'],
            'zuobi'         => $integralmall['zuobi'],
            'shuxing'       => serialize(array(
                'shuxing'      => $integralmall['shuxing'],
                'shuxingprice' => $integralmall['shuxingprice']
            )),
        );
        C::t('#xigua_integralmall#xigua_intmall')->update($tid, $update_data);

        if(!$integralmall['virtualcode']) {
            $num = $integralmall['goodnum'] - $idata['goodnum'];
            if($num> 0){
                for($i = 0; $i <$num; $i ++){
                    $goods[] = $integralmall['goodname'];
                }
                C::t('#xigua_integralmall#xigua_intmall_code')->inserts($tid, $goods);
            }
        }
    }

    public function newreply_submit_end($fid, $tid) {
    //TODO - Insert your code here

    }

    public function viewthread($tid, $ret = 0, $idata = array()) {

        if(!$ret){
            if(checkmobile()){
                return false;
            }
        }
        global $config;
        global $_G,$skipaids,$postlist, $ini, $idata;
        $return = '';

        if(!$idata){
            $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
        }
        if($idata ) {
            end_duobaodao($idata);

            $idata['malltype_name'] = $ini['malltypes'][$idata['malltype']];
            $idata['goodkind_name'] = $ini['goodkinds'][$idata['goodkind']];
            $notstart = $idata['mallstart'] > $_G['timestamp'];
            $finish = $idata['finish'];
            $idata['mallend_string'] = dgmdate($idata['mallend'], 'Y/m/d H:i:s');
            $idata['mallstart_string'] = dgmdate($idata['mallstart'], 'Y/m/d H:i:s');

            if($aids = explode(',', $idata['aid'])) {
                foreach ($aids as $k => $v) {
                    $idata['attachment'][$k] = $v ? getforumimg($v, 0, 400, 300) : $GLOBALS['noimg1'];
                    $idata['encodeaid'][$k] = $v ? aidencode($v) : '';
                    $skipaids[] = $v;
                }
            }
            C::t('#xigua_integralmall#xigua_intmall')->incr_hit($tid);

            if(defined('IN_MOBILE_API')){
                return $return;
            }

            if($idata['malltype'] == 1){
                $current_price = $idata['sellprice'];
                $current_price_title = lang('plugin/xigua_integralmall', 'yikou');
                $joinaction = 'join';
                $btn_title = lang('plugin/xigua_integralmall', 'yemiedie').lang('plugin/xigua_integralmall', 'dui');
            }else if($idata['malltype'] == 3){
                $last = C::t('#xigua_integralmall#xigua_intmall_log')->getlast($tid, $idata['goodnum']);
                $myoldprice = C::t('#xigua_integralmall#xigua_intmall_log')->getmyoldprice($_G['uid'], $tid);
                $current_price = max($last['currentprice'], $idata['baseprice'], $myoldprice['currentprice']);
                $current_price_title = lang('plugin/xigua_integralmall', 'cur');
                $joinaction = 'joinduobao';
                $btn_title = lang('plugin/xigua_integralmall', 'yemiedie').lang('plugin/xigua_integralmall', 'chujia');
            }else if($idata['malltype'] == 4){
                $current_price = ($finish && $idata['status']) ? $idata['sellprice'] :lang('plugin/xigua_integralmall', 'caicais');
                $current_price_title = lang('plugin/xigua_integralmall', 'cur');
                $joinaction = 'join';
                $btn_title = lang('plugin/xigua_integralmall', 'yemiedie').lang('plugin/xigua_integralmall', 'caicaicai');
            }else if($idata['malltype'] == 2){
                $current_price = $idata['sellprice'];
                $current_price_title = lang('plugin/xigua_integralmall', 'choujiangh');
                $joinaction = 'join';
                $btn_title = lang('plugin/xigua_integralmall', 'yemiedie').lang('plugin/xigua_integralmall', 'choujiangs');
            }else if($idata['malltype'] == 5){
                $idata['shuxing'] = format_shuxing($idata['shuxing']);

                $current_price = $idata['shuxing']['shuxingprice'][0];
                $current_price_title = lang('plugin/xigua_integralmall', 'yikou');
                $joinaction = 'join';
                $btn_title = lang('plugin/xigua_integralmall', 'yemiedie').lang('plugin/xigua_integralmall', 'dui');
            }

            if($idata['goodkind'] == 1 ){
                if($_G['adminid'] == 1 || $_G['uid'] == $idata['uid']){
                    $showcodeinfo = 1;
                }else if($_G['uid']){
                    $codeinfo = C::t('#xigua_integralmall#xigua_intmall_code')->get_code($_G['uid'], $tid);
                    if($codeinfo){
                        $cvs = array();
                        foreach ($codeinfo as $ck => $cv) {
                            $cod = $ck %2 ==0 ? "odd" : '';
                            $cvs[] = '<tr><td class=\\\''.$cod.'\\\'>'.str_replace(array('\''), array("\'"), htmlspecialchars($cv['code'])).'</td></tr>';
                        }
                        $mycodeinfo = '<div style=\\\'max-height:200px;overflow-y:auto;overflow-x: hidden;padding: 0 5px;\\\'><table class=\\\'table min200\\\'>'.implode('', $cvs).'</table></div>';
                    }
                }
            }else{
                if($_G['adminid'] == 1 || $_G['uid'] == $idata['uid']){
                    $showmyprofile = 1;
                    $showgoodinfo = 1;
                }elseif($_G['uid']){
                    $showmyprofile = 1;
                    $tmp = C::t('#xigua_integralmall#xigua_intmall_code')->get_code($_G['uid'], $tid);
                    if($tmp[0]){
                        $showmygoodinfo = 1;
                    }
                }
            }
            if($ret){
                return array(
                    'idata' => $idata,
                    'notstart' => $notstart,
                    'finish' => $finish,
                    'skipaids' => $skipaids,
                    'current_price' => $current_price,
                    'current_price_title' => $current_price_title,
                    'joinaction' => $joinaction,
                    'btn_title' => $btn_title,
                    'showcodeinfo' => $showcodeinfo,
                    'mycodeinfo' => $mycodeinfo,
                    'showmyprofile' => $showmyprofile,
                    'showgoodinfo' => $showgoodinfo,
                    'showmygoodinfo' => $showmygoodinfo,
                    'postlist' => $postlist,
                    'codeinfo' =>$codeinfo
                );
            }
            global $wechat;
            include template('xigua_integralmall:viewthread');
            return $return;
        } else {
            return $return;
        }
    }
}