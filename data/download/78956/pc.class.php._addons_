<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once "jssdk.php";
class plugin_cack_wxjssdk {
	function global_header(){
		global $_G;
		$_C=$_G['cache']['plugin']['cack_wxjssdk'];
		if($_C['kqdnb']){
		$jssdk = new JSSDK($_C[appId], $_C[appSecret]);
		$signPackage = $jssdk->GetSignPackage();
		$cackprotocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$cwx[url] = "$cackprotocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if($_G['basescript'] == 'forum' && CURMODULE =='viewthread' && $_G[forum_thread][tid] && $_G[forum_thread][authorid]) {
				$threadtable = DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $_G[forum_thread][tid].' AND uid = '.$_G[forum_thread][authorid] .' LIMIT  0 ,'. 1 );
				if($threadtable['0'][aid]){
				$cwx[pic] = $_G['siteurl'].getforumimg($threadtable['0'][aid], '0', '80', '80');
				}
				$cwx[title] = $_G['forum_thread']['subject'];
			}else if($_G['basescript'] == 'forum' && CURMODULE =='forumdisplay') {
				$cwx[title] = $_G[forum][name];
				$cwx[pic] = $_G['siteurl'].'data/attachment/common/'.$_G['forum'][icon];
			}else if($_G['basescript'] == 'portal' && CURMODULE =='view') {
				$articletable = DB::fetch_all('SELECT * FROM '.DB::table('portal_article_title').' WHERE aid = '.intval($_GET[aid]).' LIMIT  0 ,'. 1 );
				if($articletable['0'][pic]){
				$cwx[pic] = $_G['siteurl'].'data/attachment/'.$articletable['0'][pic];
				}
			}
			
		if(!$cwx[pic]){
			$cwx[pic] = $_C[mrpic];
		}
		include template('cack_wxjssdk:jssdk');
		return $mobole;
		}
	}
}

?>