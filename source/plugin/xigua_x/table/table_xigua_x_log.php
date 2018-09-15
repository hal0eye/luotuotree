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

class table_xigua_x_log extends  discuz_table
{

    public function __construct()
    {
        $this->_table = 'xigua_x_log';
        $this->_pk = 'log_id';

        parent::__construct();
    }


    public function fetch_all_bypage($start_limit, $lpp)
    {
        $result = DB::fetch_all('SELECT * FROM ' . DB::table($this->_table) . "  ORDER BY $this->_pk DESC " . DB::limit($start_limit, $lpp));
        return $result;
    }

    public function fetch_count_bypage()
    {
        $result = DB::result_first('SELECT  count(*) as c FROM ' . DB::table($this->_table));
        return $result;
    }

    public function clear_log()
    {
        return DB::query("DELETE FROM %t WHERE 1", array($this->_table));
    }

}