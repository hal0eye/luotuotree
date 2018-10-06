<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_video extends discuz_table{
    public function __construct() {
        $this->_table = 'video';
        $this->_pk    = 'id';
        parent::__construct();
    }

    public function get_video_list($page){
        $result = DB::fetch_all("SELECT * FROM ".DB::table('video')." WHERE is_out_of_stock = 0" . DB::limit($page*10-10,10));
        return $result;
    }

    public function count_video_info(){
        $result = DB::result_first("SELECT COUNT(*) FROM ".DB::table('video')." WHERE is_out_of_stock = 0 ");
        return $result;
    }

}