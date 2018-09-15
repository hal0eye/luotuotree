<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/17/017
 * Time: 22:22
 */

if (!defined('IN_DISCUZ') ) {
    exit('Access Denied');
}

if(!$_G['cache']['plugin']){
    loadcache('plugin');
}
$config = $_G['cache']['plugin']['xigua_x'];

$setar = unserialize($config['opentype']);

/*        $notice_structure = array(
            'mypost' => array('post','pcomment','activity','reward','goods','at'),
            'interactive' => array('poke','friend','wall','comment','click','sharenotice'),
            'system' => array('system','myapp','credit','group','verify','magic','task','show','group','pusearticle','mod_member','blog','article'),
            'manage' => array('mod_member','report','pmreport'),
        );
*/

$row = C::t('#xigua_x#xigua_x_user')->fetch($_G['uid']);

if($row){
    $opt = unserialize($row['opentype']);
}

$apple = 1;
define('INC_WECHAT', strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false);

if(submitcheck('formhash')){
    if($_GET['ismobile']){
        foreach ($setar as $k => $item) {
            if($_GET['my'][$item]){
                $_GET['my'][$item] = 0;
            }else{
                $_GET['my'][$item] = 1;
            }
        }
    }

    if(C::t('#xigua_x#xigua_x_user')->insert(array('uid' => $_G['uid'], 'opentype' => serialize($_GET['my'])), false, true)){
        showmessage('do_success', '', array(), array('alert'=> 'right'));
    }
}

if(checkmobile()){
    include_once template('xigua_x:myset');
    exit;
}