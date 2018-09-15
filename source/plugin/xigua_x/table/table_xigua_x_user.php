<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17/017
 * Time: 23:13
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_xigua_x_user extends  discuz_table
{

    public function __construct()
    {
        $this->_table = 'xigua_x_user';
        $this->_pk = 'uid';

        parent::__construct();
    }

}