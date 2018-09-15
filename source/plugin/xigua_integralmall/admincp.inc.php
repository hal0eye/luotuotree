<?php
/**
 * Created by PhpStorm.
 * User: yangzhiguo
 * Date: 15/7/19
 * Time: 20:49
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT . 'source/plugin/xigua_integralmall/init.php';


echo <<<HTML
<style>
#tips1lis li{display:block!important;}
#tips1lis li#tips1_more{display:none!important;}
#tips1lis img{vertical-align: middle;}
#tips1lis img.w{height:24px;vertical-align: middle;}
#tips1lis .g{margin-right:5px;color:#578CC0;font-weight:bolder}
#tips1lis .b{margin-right:5px;color:forestgreen;font-weight:bolder}
#tips1lis .t{margin-right:5px;color:orangered;font-weight:bolder}
#tips1lis .n{margin-right:5px;color:#333;font-weight:bolder}
</style>
HTML;

$message = str_replace(
    array('{url}'),
    array($_G['siteurl'].'plugin.php?id=xigua_integralmall'),
    lang('plugin/xigua_integralmall', 'notice1'));
showtips($message, 'tips1', TRUE);