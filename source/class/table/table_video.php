<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_video extends discuz_table{

    private static $course_type_map = [
        '1' => '社群招生',
        '2' => '教学教研',
        '3' => '课程销售'
    ];

    private static $charge_type_map = [
        '1' => '公开课',
        '2' => '会员课程',
        '3' => '收费课程'
    ];

    private static $is_remind_map = [
        '1' => '是',
        '0' => '否',
    ];

    private static $is_out_of_stock_map = [
        '1' => '是',
        '0' => '否',
    ];

    public function __construct() {
        $this->_table = 'video';
        $this->_pk    = 'id';
        parent::__construct();
    }

    public function get_video_list($page){
        $result = DB::fetch_all("SELECT * FROM ".DB::table('video')." WHERE is_out_of_stock = 0" . DB::limit($page*10-10,10));
        foreach ($result as &$value) {
            $value['course_type'] = isset(self::$course_type_map[$value['course_type']]) ? self::$course_type_map[$value['course_type']] : '';
            $value['charge_type'] = isset(self::$charge_type_map[$value['charge_type']]) ? self::$charge_type_map[$value['charge_type']] : '';
        }
        return $result;
    }

    public function count_video_info(){
        $result = DB::result_first("SELECT COUNT(*) FROM ".DB::table('video')." WHERE is_out_of_stock = 0 ");
        return $result;
    }

    public function get_video_info($id){
        $result = DB::fetch_all("SELECT * FROM ".DB::table('video')." WHERE is_out_of_stock = 0 AND id = {$id}");
        foreach ($result as &$value) {
            $value['course_type'] = isset(self::$course_type_map[$value['course_type']]) ? self::$course_type_map[$value['course_type']] : '';
            $value['charge_type'] = isset(self::$charge_type_map[$value['charge_type']]) ? self::$charge_type_map[$value['charge_type']] : '';
        }
        return $result;
    }

}