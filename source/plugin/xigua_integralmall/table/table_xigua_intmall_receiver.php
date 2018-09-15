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
class table_xigua_intmall_receiver extends  discuz_table
{
    public function __construct()
    {
        $this->_table = 'xigua_intmall_receiver';
        $this->_pk = 'uid';

        parent::__construct();
    }
}