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

class table_xigua_x extends  discuz_table
{

    public function __construct()
    {
        $this->_table = 'xigua_x';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function take_replace($template_list)
    {
        foreach ($template_list as $index => $item) {
            if($row = $this->get_by_tplid($item['template_id'])){
                $this->update($row[$this->_pk], $item);
            }else{
                $this->insert($item, true);
            }
        }
        return true;
    }

    public function fetch_list_by_page($start_limit = 0 , $lpp = 999)
    {
        $result = DB::fetch_all('SELECT * FROM ' . DB::table($this->_table) . " ORDER BY {$this->_pk} DESC " . DB::limit($start_limit, $lpp), array(), 'template_id');
        return $result;
    }

    public function multi_delete($ids)
    {
        if(!$ids){
            return false;
        }
        return DB::query("DELETE FROM %t WHERE {$this->_pk} IN (%n) ", array($this->_table, $ids));
    }

    public function get_by_tplid($tplid)
    {
        return DB::fetch_first("SELECT * FROM %t WHERE template_id=%s", array($this->_table, $tplid));
    }

    public function get_by_type($type = 1)
    {
        return DB::fetch_first("SELECT * FROM %t WHERE type=%d", array($this->_table, $type));
    }

    public function incr_by_tplid($tplid, $succeed = 1)
    {
        return DB::query("UPDATE %t SET lastsend=%s,sendtimes=sendtimes+1,succeedtimes=succeedtimes+%d WHERE template_id=%s", array($this->_table, TIMESTAMP, $succeed, $tplid));
    }

}