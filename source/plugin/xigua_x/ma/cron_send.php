<?php
/**
 *	[【西瓜】模版消息发送消息] (C)2015-2099 Powered by 西瓜先生.
 *	Version: 1.20150815
 *	Date: 2015-8-15 16:25
 *	Warning: Don't delete this comment
 *
 *	cronname:send_template
 *	week:-1
 *	day:-1
 *	hour:-1
 *	minute:0,5,10,15,20,25,30,35,40,45,50,55
 *	desc:微信发送消息
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

global $_G;
if(!$_G['cache']['plugin']){
    loadcache('plugin');
}
$config = $_G['cache']['plugin']['xigua_x'];
$wechat_table = $config['wechattable'];
$replace_ary  = array('&nbsp;', lang('plugin/xigua_x', 'view'), lang('plugin/xigua_x', 'click'), '&rsaquo;', '&raquo;', strip_tags(x_unescape('&#26597;&#30475;')));

if($config['auto']){

include_once DISCUZ_ROOT. './source/plugin/xigua_x/xWechat.lib.class.php';
$client = new xWeChat($config['appid'], $config['appsecret']);
$template_sys = C::t('#xigua_x#xigua_x')->get_by_type(2);  //system template
$template_rep = C::t('#xigua_x#xigua_x')->get_by_type(1);  //reply template

$pms = DB::fetch_all("SELECT h.*,w.openid FROM %t AS h,%t AS w WHERE h.uid=w.userid AND h.new=1 AND h.uid>0 AND w.openid<>'' ORDER BY h.id DESC LIMIT 0,1",array('home_notification', $wechat_table));
foreach ($pms as $pm) {
    if($pm){
        DB::query('UPDATE %t SET new=0 WHERE id=%d',array('home_notification', $pm['id']));

        //filter user set
        if($userset = C::t('#xigua_x#xigua_x_user')->fetch($pm['uid'])){
            $userset = unserialize($userset['opentype']);
            if(
                (isset($userset[$pm['type']]) && $userset[$pm['type']]==1) ||
                (strpos($pm['type'], 'verify')!==false&&$userset['verify']==1)
            ){

                C::t('#xigua_x#xigua_x_log')->insert(array(
                    'uid'         => $pm['uid'],
                    'openid'      => $openid,
                    'template_id' => $template_id,
                    'crts'        => TIMESTAMP,
                    'content'     => json_encode(array()),
                    'code' => '-1',
                    'errmsg' => lang('plugin/xigua_x', 'js').$pm['type'],
                ));
                continue;
            }
        }

        $_G['siteurl'] = C::t('common_setting')->fetch('siteurl');
        if(substr($_G['siteurl'], -1)!='/'){
            $_G['siteurl'] = $_G['siteurl'].'/';
        }

        $opentype = unserialize($config['opentype']);
        $system_ary = $rep_ary = array();
        foreach ($opentype as $index => $item) {
            if(in_array($item, array('post', 'pcomment'))){
                $rep_ary[] = $item;
            }else{
                $system_ary[] = $item;
            }
        }

        $data_sys = unserialize($template_sys['split']);
        $data_rep = unserialize($template_rep['split']);
        $openid = $pm['openid'];
        $note = str_replace($replace_ary,'',x_unescape(strip_tags($pm['note'])));
        if( (in_array($pm['type'], $system_ary) || strpos($pm['type'], 'verify')!==false) && $data_sys ){
            $template_id = $template_sys['template_id'];

            $user = getuserbyuid($pm['uid']);
            if(!in_array($user['groupid'], unserialize($config['opengroup']))){

                C::t('#xigua_x#xigua_x_log')->insert(array(
                    'uid'         => $pm['uid'],
                    'openid'      => $openid,
                    'template_id' => $template_id,
                    'crts'        => TIMESTAMP,
                    'content'     => json_encode(array()),
                    'code' => '-1',
                    'errmsg' => lang('plugin/xigua_x', 'nogroup'),
                ));


                continue;
            }

            $author = getuserbyuid($pm['authorid']);

            if(preg_match_all("/<a(.+?)href=(['\"]?)([^>\s]+)\\2([^>]*)>/i", $pm['note'], $m)){
                $link = array_pop($m[3]);
                if($link == 'about:blank'){
                    $link = array_pop($m[3]);
                }
                $tmpurl = ($link ? $link : './home.php?mod=space&do=notice&view=system');
                $url = xget_picurl($tmpurl);
            }else{
                $url = $_G['siteurl'].'./home.php?mod=space&do=notice&view=system';
            }

            $empty = 0;
            foreach ($data_sys as $index => $item) {

                $item['value'] = str_replace(array(
                    '{note}',
                    '{time}',
                    '{author}',
                    '{username}',
                    '{type}'
                ), array(
                    $note,
                    dgmdate($pm['dateline'], 'Y-m-d H:i:s'),
                    $author['username'],
                    $user['username'],
                    lang('plugin/xigua_x', 'system'),
                ), $item['value']);

                if(!$item['value']){
                    $empty ++;
                }
                $data_sys[$index]['value'] = diconv($item['value'], CHARSET, 'UTF-8');
            }

            if($empty> (count($data_sys)-1)){

                C::t('#xigua_x#xigua_x_log')->insert(array(
                    'uid'         => $pm['uid'],
                    'openid'      => $openid,
                    'template_id' => $template_id,
                    'crts'        => TIMESTAMP,
                    'content'     => json_encode(array()),
                    'code' => '-1',
                    'errmsg' => lang('plugin/xigua_x', 'emtp'),
                ));


                continue;
            }

            $data        = $data_sys;

        }else if(in_array($pm['type'], $rep_ary) && $data_rep){

            $template_id = $template_rep['template_id'];
            $user = getuserbyuid($pm['uid']);
            if(!in_array($user['groupid'], unserialize($config['opengroup']))){

                C::t('#xigua_x#xigua_x_log')->insert(array(
                    'uid'         => $pm['uid'],
                    'openid'      => $openid,
                    'template_id' => $template_id,
                    'crts'        => TIMESTAMP,
                    'content'     => json_encode(array()),
                    'code' => '-1',
                    'errmsg' => lang('plugin/xigua_x', 'nogroup'),
                ));

                continue;
            }

            $author = getuserbyuid($pm['authorid']);
            if($pm['from_idtype'] == 'quote'){
                $tid = DB::result_first('SELECT tid FROM %t WHERE pid=%d',array('forum_post', $pm['from_id']));
                $url = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$tid;
            }else if(preg_match_all("/<a(.+?)href=(['\"]?)([^>\s]+tid[^>\s]+)\\2([^>]*)>/i", $pm['note'], $m)){
                $link = array_pop($m[3]);
                if($link == 'about:blank'){
                    $link = array_pop($m[3]);
                }
                $url = xget_picurl($link);
            }else{
                $url = $_G['siteurl'];
            }

            $empty = 0;
            foreach ($data_rep as $index => $item) {
                $item['value'] = str_replace(array(
                    '{note}',
                    '{time}',
                    '{author}',
                    '{username}',
                    '{type}',
                ), array(
                    $note,
                    dgmdate($pm['dateline'],'Y-m-d H:i:s'),
                    $author['username'],
                    $user['username'],
                    lang('plugin/xigua_x', 'reply'),
                ), $item['value']);
                $data_rep[$index]['value'] = diconv($item['value'], CHARSET, 'UTF-8');

                if(!$item['value']){
                    $empty ++;
                }
            }

            if($empty> (count($data_rep)-1)){
                C::t('#xigua_x#xigua_x_log')->insert(array(
                    'uid'         => $pm['uid'],
                    'openid'      => $openid,
                    'template_id' => $template_id,
                    'crts'        => TIMESTAMP,
                    'content'     => json_encode(array()),
                    'code' => '-2',
                    'errmsg' => lang('plugin/xigua_x', 'emtp'),
                ));
                continue;
            }

            $data        = $data_rep;
        }else{
            DB::query('UPDATE %t SET new=0 WHERE id=%d',array('home_notification', $pm['id']));

            C::t('#xigua_x#xigua_x_log')->insert(array(
                'uid'         => $pm['uid'],
                'openid'      => $openid,
                'template_id' => $template_id,
                'crts'        => TIMESTAMP,
                'content'     => json_encode(array()),
                'code' => '-1',
                'errmsg' => lang('plugin/xigua_x', 'notype').$pm['type'],
            ));
            continue;
        }

        $param = array(
            'touser'      => $openid,
            'template_id' => $template_id,
            'url'         => $url,
            'topcolor'    => '#ff0000',
            'data'        => $data,
        );

        $data['url'] = array('value' => $url,  );
        $insertdata = array(
            'uid'         => $pm['uid'],
            'openid'      => $openid,
            'template_id' => $template_id,
            'crts'        => TIMESTAMP,
            'content'     => json_encode($data),
        );
        if($result = $client->dosendTemplate($param)){
            $insertdata['code'] = 0;
            $insertdata['errmsg'] = lang('plugin/xigua_x', 'sendsuccess');
            C::t('#xigua_x#xigua_x')->incr_by_tplid($template_id, 1);
        }else{
            $error = diconv($client->error(), 'UTF-8');
            $insertdata['code'] = $client->ERROR_NO;
            $insertdata['errmsg'] = $error;
            C::t('#xigua_x#xigua_x')->incr_by_tplid($template_id, 0);
        }
        C::t('#xigua_x#xigua_x_log')->insert($insertdata);
    }
}
}

function xget_picurl($pic){
    global $_G;
    if(xis_picurl($pic)){
        return $pic;
    }
    return $_G['siteurl'].$pic;
}
function xis_picurl($pic){
    return in_array(strtolower(substr($pic, 0, 6)), array('http:/', 'https:', 'ftp://'));
}


function x_unescape($str) {
    $str = rawurldecode($str);
    preg_match_all("/(?:%u.{4})|&#x.{4};|&#\d+;|.+/U",$str,$r);
    $ar = $r[0];
    foreach($ar as $k=>$v) {
        if(substr($v,0,2) == "%u"){
            $ar[$k] = iconv("UCS-2BE","UTF-8",pack("H4",substr($v,-4)));
        }
        elseif(substr($v,0,3) == "&#x"){
            $ar[$k] = iconv("UCS-2BE","UTF-8",pack("H4",substr($v,3,-1)));
        }
        elseif(substr($v,0,2) == "&#") {

            $ar[$k] = iconv("UCS-2BE","UTF-8",pack("n",substr($v,2,-1)));
        }
    }
    return implode("",$ar);
}