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
class table_xigua_intmall_log extends  discuz_table
{
    public function __construct()
    {
        $this->_table = 'xigua_intmall_log';
        $this->_pk = 'lid';

        parent::__construct();
    }

    public function get_total($tid)
    {
        $count = (int) DB::result_first("SELECT count(*) FROM %t WHERE tid=%d", array(
            $this->_table,
            $tid
        ));
        return $count;
    }

    /**
     * @param $tid
     * @param $start_offset
     * @return array
     */
    public function getlast($tid, $start_offset)
    {
        if($start_offset<=1){
            $start_offset = 1;
        }
        $last = DB::fetch_first("SELECT * FROM %t WHERE tid=%d ORDER BY currentprice DESC,dateline ASC LIMIT %d,1", array(
            $this->_table,
            $tid,
            $start_offset - 1,
        ));
        return $last;
    }

    public function getmycount($uid, $tid)
    {
        return DB::result_first("SELECT COUNT(*) AS c FROM  %t WHERE tid=%d AND uid=%d", array(
            $this->_table,
            $tid,
            $uid
        ));
    }

    public function getmyoldprice($uid, $tid)
    {
        return DB::fetch_first("SELECT * FROM  %t WHERE tid=%d AND uid=%d ORDER BY currentprice DESC LIMIT 1", array(
            $this->_table,
            $tid,
            $uid
        ));
    }

    public function getmyoldprices($uid, $tids)
    {
        $limit = count($tids);
        return DB::fetch_all("SELECT tid,uid,currentprice FROM  %t WHERE tid IN (%n) AND uid=%d ORDER BY currentprice DESC LIMIT $limit", array(
            $this->_table,
            $tids,
            $uid
        ), 'tid');
    }

    public function fetch_all_log($tid)
    {
        $result = DB::fetch_all('SELECT * FROM %t WHERE tid=%d ORDER BY currentprice DESC,dateline ASC ', array(
            $this->_table,
            $tid
        ), 'uid');
        return $result;
    }

    public function fetch_all_by_page($tid, $start_limit , $lpp, $goodnum = 0){
        global $idata, $finish;
        if($idata['malltype'] ==3){
            $order = 'currentprice DESC,dateline DESC';
        }else{
            $order = 'dateline DESC';
        }
        $idata['shuxing'] = format_shuxing($idata['shuxing']);

        $result = DB::fetch_all('SELECT * FROM '.DB::table($this->_table)." WHERE tid=$tid ORDER BY $order " . DB::limit($start_limit, $lpp));
        foreach ($result as $k => $v) {
            $get = $v['status']==2;
            switch($idata['malltype']){
                case 5:
                    if($get){
                        $status = lang('plugin/xigua_integralmall', 'hasdui').' '.$idata['shuxing']['shuxing'][$v['extra']];
                    }else{
                        $status = lang('plugin/xigua_integralmall', 'duii').' '.$idata['shuxing']['shuxing'][$v['extra']];
                    }
                    break;
                case 1:
                    if($get){
                        $status = lang('plugin/xigua_integralmall', 'hasdui');
                    }else{
                        $status = lang('plugin/xigua_integralmall', 'duii');
                    }
                    break;
                case 2:
                    if($get){
                        $status = lang('plugin/xigua_integralmall', 'yizhong');
                    }else{
                        $status = $finish ? lang('plugin/xigua_integralmall', 'weizhong') : lang('plugin/xigua_integralmall', 'daikai');
                    }
                    break;
                case 3:
                    $index = $start_limit+$k;
                    if($index == 0){
                        $status = lang('plugin/xigua_integralmall', 'lingxian');
                    }else if($index <$goodnum){
                        $status = lang('plugin/xigua_integralmall', 'anquan');
                    }else{
                        $status = lang('plugin/xigua_integralmall', 'chuju');
                    }
                    break;
                case 4:
                    if($get){
                        $status = lang('plugin/xigua_integralmall', 'yicai');
                    }else{
                        $status = $finish ? lang('plugin/xigua_integralmall', 'weicai') : lang('plugin/xigua_integralmall', 'daijie');
                    }
                    break;
            }

            $result[$k]['status'] = $status;
            $result[$k]['dateline'] = dgmdate($v['dateline'], 'u');
        }

        return $result;
    }
    public function fetch_all_by_count($tid){
        $result = DB::result_first('SELECT count(*) as c FROM '.DB::table($this->_table) . " WHERE tid=$tid");
        return $result;
    }

    public function finish_update($uid, $tid, $get = 0)
    {
        return DB::update($this->_table, array(
            'status' => ($get ? 2 : 1),
        ), array(
            'tid' => $tid,
            'uid' => $uid,
        ));
    }

    public function get_unsettle($tid){
        $result = DB::fetch_all('SELECT * FROM %t WHERE tid=%d AND status=0 ', array(
            $this->_table,
            $tid
        ), 'uid');
        return $result;
    }

    public function delete_by_tid($tid)
    {
        return DB::delete($this->_table, array('tid' => $tid));
    }

    public function fetch_my_count($uid){
        return DB::result_first('SELECT COUNT(*) AS c FROM %t WHERE uid=%d', array(
            $this->_table,
            $uid
        ));
    }

    public function fetch_my_logs($uid, $start_limit , $lpp)
    {
        $tids = DB::fetch_all('SELECT tid FROM %t WHERE uid=%d ORDER BY dateline DESC '. DB::limit($start_limit, $lpp), array(
            $this->_table,
            $uid
        ));
        $ret = array();
        foreach ($tids as $v) {
            $ret[] = $v['tid'];
        }
        return $ret;
    }
}