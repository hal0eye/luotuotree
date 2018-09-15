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

class table_xigua_intmall_code extends  discuz_table
{
    public function __construct()
    {
        $this->_table = 'xigua_intmall_code';
        $this->_pk = 'vid';

        parent::__construct();
    }

    public function inserts($tid, $data)
    {
        $sql = '';
        foreach($data as $row) {
            $sql .= "(null,'{$tid}','".daddslashes($row)."','0','0',''),";
        }
        $sql = trim($sql, ',');
        return DB::query("INSERT INTO ".DB::table($this->_table)." VALUES {$sql}");
    }

    public function send_code($uid, $tid)
    {
        return DB::query("UPDATE %t SET uid=%d WHERE tid=%d AND uid='0' LIMIT 1", array(
            $this->_table,
            $uid,
            $tid
        ));
    }

    public function get_code($uid, $tid)
    {
        if($uid){
            $where = " AND uid=$uid";
        }
        $result = DB::fetch_all('SELECT * FROM '.DB::table($this->_table) . " WHERE tid=$tid $where");
        foreach ($result as $v) {
            $uids[$v['uid']] = 1;
        }
        $users = C::t('common_member')->fetch_all_username_by_uid(array_keys($uids));
        foreach ($result as $k => $v) {
            $result[$k]['username'] = $users[$v['uid']];
        }

        return $result;
    }

    public function fetch_unuse_code($tid)
    {
        $result = DB::fetch_all('SELECT * FROM '.DB::table($this->_table) . " WHERE tid=$tid ");
        return $result;
    }

    public function update_sendinfo($tid, $uid, $sendinfo = '')
    {
        if(empty($sendinfo)){
            return false;
        }
        return DB::query("UPDATE %t SET hassend=1,sendinfo=%s WHERE tid=%d AND uid=%d", array(
            $this->_table,
            $sendinfo,
            $tid,
            $uid,
        ));
    }

    public function delete_by_tid($tid)
    {
        return DB::delete($this->_table, array('tid' => $tid));
    }
}