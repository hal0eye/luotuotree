<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_xigua_login_unbind_log extends  discuz_table
{
    public function __construct()
    {
        $this->_table = 'xigua_login_unbind_log';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function deletes($ids)
    {
        return DB::query("DELETE FROM %t WHERE {$this->_pk} IN (%n)", array($this->_table, $ids));
    }
}