<?php
/**
 * Created by PhpStorm.
 * User: yangzhiguo
 * Date: 15/7/23
 * Time: 23:22
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_xigua_intmall extends  discuz_table
{
    public function __construct()
    {
        $this->_table = 'xigua_intmall';
        $this->_pk = 'tid';

        parent::__construct();
    }

    public function incr_hit($tid, $incr = 1, $give = 0){
        $incr = intval($incr);
        $tid = intval($tid);
        $giver = $give ? ' ,give=give+1 ' : '';
        return DB::query("UPDATE %t SET hot=hot+$incr $giver WHERE tid=$tid LIMIT 1", array(
            $this->_table,
        ));
    }

    public function incr_lognum($tid, $incr = 1){
        $incr = intval($incr);
        $tid = intval($tid);
        return DB::query("UPDATE %t SET lognum=lognum+$incr WHERE tid=$tid LIMIT 1", array(
            $this->_table,
        ));
    }

    public function fetch($tid){
        global $setting_credit, $_G;
        $idata = DB::fetch_first('SELECT * FROM '.DB::table($this->_table).' WHERE '.DB::field($this->_pk, $tid));
        $idata['rangemaxprice'] = $idata['rangemaxprice'] ? $idata['rangemaxprice'] : 999999999;
        $idata['leavenum'] = $idata['goodnum'] - $idata['lognum'];
        if($idata['leavenum']<0){
            $idata['leavenum'] = 0;
        }
        $idata['finish'] = (($idata['mallend'] <$_G['timestamp']) || !$idata['leavenum']);

        $idata['ccd'] = $idata['ccd'] ? $idata['ccd'] : $setting_credit;

        return $idata;
    }

    public function check($tid){
        return DB::fetch_first("SELECT tid FROM %t WHERE tid=%d", array($this->_table, $tid));
    }

    public function is_watting_jiesuan($rdata){
        global $_G;
        return (!$rdata['status'] && $rdata['mallend'] <$_G['timestamp'])  ? true : false;
    }

    public function finish($tid)
    {
        global $idata;
        $idata['status'] = 1;
        return DB::update($this->_table, array(
            'status' => 1
        ), array(
            $this->_pk => $tid
        ));
    }

    public function delete_by_tid($tid)
    {
        return DB::delete($this->_table, array('tid' => $tid));
    }

    public function fetch_by_per_page($malltype, $start_limit , $lpp)
    {
        global $setting_credit, $_G, $config;

        //sortorder x.mallend t.dateline
        switch($config['sortorder']){
            case 1:
                $sortorder = " t.dateline DESC ";
                break;
            default:
            case 2:
                $sortorder = " x.mallend DESC ";
                break;
        }

        $extwhere = '';
        if($config['noend']){
            $extwhere = " AND x.goodnum>x.lognum AND x.mallend>".$_G['timestamp'];
        }

        $list = DB::fetch_all("SELECT * FROM %t AS x, " . DB::table('forum_thread') . " AS t WHERE x.tid=t.tid AND (t.displayorder>=0 AND t.closed<>1) AND x.malltype=%d $extwhere ORDER BY $sortorder ". DB::limit($start_limit, $lpp), array(
            $this->_table,
            $malltype
        ));
        if($list){
            foreach ($list as $k => $v) {
                $aids = explode(',', $v['aid']);
                $aid = $aids[0];

                $v['rangemaxprice'] = $v['rangemaxprice'] ? $v['rangemaxprice'] : 999999999;
                $v['leavenum'] = $v['goodnum'] - $v['lognum'];
                if($v['leavenum']<0){
                    $v['leavenum'] = 0;
                }
                $v['finish'] = (($v['mallend'] <$_G['timestamp']) || !$v['leavenum']);

                if($v['malltype'] ==5){
                    $v['shuxing'] = format_shuxing($v['shuxing']);
                    $v['sellprice'] = $v['shuxing']['shuxingprice'][0];
                }

                $list[$k] = $v;
                $list[$k]['attachment'] =( $aid ? getforumimg($aid, 0, 300, 300) : $GLOBALS['noimg']);
                $list[$k]['encodeaid'] = $aid ? aidencode($aid) : '';
                $list[$k]['ccd'] = $list[$k]['ccd'] ? $list[$k]['ccd'] : $setting_credit;
            }

        }
        return $list;
    }

    public function fetch_my_count($uid){
        return DB::result_first('SELECT COUNT(*) AS c FROM %t AS x, ' . DB::table('forum_thread') . ' AS t WHERE x.tid=t.tid AND (t.displayorder>=0 AND t.closed<>1) AND uid=%d', array(
            $this->_table,
            $uid
        ));
    }

    public function fetch_by_count($malltype){
        return DB::result_first('SELECT COUNT(*) AS c FROM %t AS x, ' . DB::table('forum_thread') . ' AS t WHERE x.tid=t.tid AND (t.displayorder>=0 AND t.closed<>1) AND malltype=%d', array(
            $this->_table,
            $malltype
        ));
    }

    public function fetch_my_by_page($uid, $start_limit , $lpp, $tids = array()){
        global $setting_credit, $_G;
        if($tids){
            $list = DB::fetch_all("SELECT * FROM %t WHERE tid IN(%n) ORDER BY mallend DESC ", array(
                $this->_table,
                $tids
            ));
        }else{
            $list = DB::fetch_all("SELECT * FROM %t AS x, " . DB::table('forum_thread') . " AS t WHERE x.tid=t.tid AND (t.displayorder>=0 AND t.closed<>1) AND uid=%d ORDER BY mallend DESC ". DB::limit($start_limit, $lpp), array(
                $this->_table,
                $uid
            ));
        }
        $ret = array();
        if($list){
            foreach ($list as $k => $v) {
                $aids = explode(',', $v['aid']);
                $aid = $aids[0];

                $v['rangemaxprice'] = $v['rangemaxprice'] ? $v['rangemaxprice'] : 999999999;
                $v['leavenum'] = $v['goodnum'] - $v['lognum'];
                if($v['leavenum']<0){
                    $v['leavenum'] = 0;
                }
                $v['finish'] = (($v['mallend'] <$_G['timestamp']) || !$v['leavenum']);
                $v['attachment'] = ($aid ? getforumimg($aid, 0, 300, 300) : $GLOBALS['noimg']);
                $v['encodeaid'] = $aid ? aidencode($aid) : '';
                $list[$k]['ccd'] = $list[$k]['ccd'] ? $list[$k]['ccd'] : $setting_credit;

                if($v['malltype'] ==5){
                    $v['shuxing'] = format_shuxing($v['shuxing']);
                    $v['sellprice'] = $v['shuxing']['shuxingprice'][0];
                }

                $ret[$v['malltype']][] = $v;
            }

        }
        return $ret;
    }
}