<?php
/**
 * Created by PhpStorm.
 * User: yzg
 * Date: 2016/11/14
 * Time: 11:53
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_xigua_x_fans extends  discuz_table
{

    public function __construct()
    {
        $this->_table = 'xigua_x_fans';
        $this->_pk = 'openid';

        parent::__construct();
    }

    public function delete_all()
    {
        return DB::query('DELETE FROM %t ', array( $this->_table ));
    }

    public function fetch_by_page($current, $pagesize)
    {
        $result = DB::fetch_all('SELECT * FROM ' . DB::table($this->_table) . " WHERE last_send='0000-00-00 00:00:00' LIMIT $current,$pagesize ", array(), $this->_pk);
        return $result;
    }

    public function fetch_list_by_page($start_limit = 0 , $lpp = 50, $openid)
    {
        if($openid){
            $openid = stripsearchkey($openid);
            $ext = " WHERE openid like '%$openid%' OR wechat_info like '%$openid%' ";
        }
        $result = DB::fetch_all('SELECT * FROM ' . DB::table($this->_table) . " $ext order by last_send DESC, subscribe_ts desc " . DB::limit($start_limit, $lpp), array(), $this->_pk);
        return $result;
    }
    public function fetch_count($openid) {
        if($openid){
            $openid = stripsearchkey($openid);
            $ext = " WHERE openid like '%$openid%' OR wechat_info like '%$openid%' ";
        }
        return DB::result_first("SELECT count(*) FROM ".DB::table($this->_table) . " $ext ");
    }
    public function reset_fans() {
        return DB::query('UPDATE %t SET last_send=\'0000-00-00 00:00:00\' ', array( $this->_table ));
    }
    public function upset($openid, $last_send) {
        return DB::query('UPDATE %t SET last_send=%s, total_times=total_times+1 WHERE openid=%s', array( $this->_table, $last_send,  $openid));
    }
}