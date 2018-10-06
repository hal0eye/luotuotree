<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$step = max(1, intval($_GET['step']));
shownav('tools', 'nav_updatecache');
showsubmenusteps('nav_updatecache', array(
	array('nav_updatecache_confirm', $step == 1),
	array('nav_updatecache_completed', $step == 2)
));

if($step == 1) {
	cpmsg("$lang[nav_updatecache_confirm]", 'action=plugins&operation=config&identifier=cack_wxjssdk&pmod=admincp_updatecache&step=2', 'form', '', FALSE);
} elseif($step == 2) {
	savecache('cack_wxjssdk_jsapi', array('expire_time' => '', 'jsapi_ticket' => ''));
	savecache('cack_wxjssdk_access', array('expire_time' => '', 'access_token' => ''));
	cpmsg('update_cache_succeed', '', 'succeed', '', FALSE);
}
?>