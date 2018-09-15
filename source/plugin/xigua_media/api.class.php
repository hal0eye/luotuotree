<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class xigua_media
{
    public function  __construct()
    {
        global $_G;
        loadcache('plugin');
        $this->config = $_G['cache']['plugin']['xigua_media'];

        $this->width = '100%';
        $this->height = $this->config['height'] ? $this->config['height'] .'px' : '240px';

        $this->iframe = <<<IFRAME
style="width:$this->width;height:$this->height" frameborder="0" scrolling="no" allowfullscreen="false"
IFRAME;
    }

    public function viewthread_variables(& $params)
    {
        global $_G;

        foreach ($params['postlist'] as $key => $post)
        {
            $tid = $post['tid'];
            if(strpos($post['message'], 'class="media"') !== false)
            {
                $post['message'] = preg_replace("#<a[^>]+class\s*=\s*['\"]media['\"][^>]+>([^<]*)<\/a>#ies", "\$this->media('\\1', '".$post['pid']."', '".$tid."')",  $post['message']);
            }
            $msglower = strtolower($post['message']);
            if(
                strpos($msglower, '.mp4') !== false ||
                strpos($msglower, '.mov') !== false ||
                strpos($msglower, '.mp3') !== false ||
                strpos($msglower, '.m4a') !== FALSE ||
                strpos($msglower, '.ogg') !== false ||
                strpos($msglower, '.wav') !== false ||
                strpos($msglower, '.swf') !== false
            )
            {
                $post['message'] = preg_replace("#<a[^>]+>([^<]*\.(mp4|mp3|ogg|wav|swf|m4a)[^<]*)<\/a>#ies", "\$this->parseMp3('\\1', '" . $post['pid'] . "', '" . $tid . "', '\\0')", $post['message']);
            }

            if(strpos($msglower, '.mp4') !== FALSE) {
                $post['message'] = preg_replace("/\[media\=?([\w,]*)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/ies", "\$this->media('\\2', '".$post['pid']."', '".$tid."')" , $post['message']);
            }


            if(
                strpos($post['message'], '[/audio]') !== FALSE ||
                strpos($post['message'], '[/media]') !== FALSE ||
                strpos($post['message'], '[/flash]') !== FALSE
            ){
                $post['message'] = preg_replace("/attach:\/\/(\d+)\.?(\w*)/ie", "parseattachurl('\\1', '\\2', 1)", $post['message']);
                $post['message'] = preg_replace("/\[(audio|media|flash)\=?([\w,]*)\]\s*(.*?)\s*\[\/(audio|media|flash)\]/ies", 'parsexiguamedia_pc123("\\2","\\3","\\0")', $post['message']);
            }

            $params['postlist'][ $key ]['message'] = $post['message'];
        }

        return TRUE;
    }

    public function media($url, $pid, $tid)
    {
        $url = html_entity_decode($url);
        $msg = $this->get_message($tid, $pid);
        $msglower = strtolower($msg);
        if(strpos($msglower, '[/media]') !== FALSE) {
            preg_match("/\[media\=?([\w,]*)\]\s*".preg_quote($url, '/')."\s*\[\/media\]/ies", $msg, $match);
            $attr = $match[1];
        }
        $link = $this->build(array(
            'attr' => $attr,
            'url'  => $url,
            'formhash' => FORMHASH
        ));
        return <<<VIDEO
<div style="width:100%" class="xigua_media"><iframe $this->iframe src="$link"></iframe></div>
VIDEO;
    }

    public function parseMp3($url, $pid, $tid, $o){
        if(strpos($o, '"media"') !== false){
            return "<a class=\"media\" href=\"$url\">$url</a>";
        }
        $og_url = html_entity_decode($url);
        $url = $og_url;
        $urllower = strtolower($url);
        if(
            strpos($urllower, '.mp4') !== false ||
            strpos($urllower, '.mov') !== false ||
            strpos($urllower, '.mp3') !== false ||
            strpos($urllower, '.m4a') !== FALSE ||
            strpos($urllower, '.ogg') !== false ||
            strpos($urllower, '.wav') !== false
        ){
            $iframe = strpos($urllower, '.mp4') === false ? str_replace("height:$this->height", "height:40px", $this->iframe) : $this->iframe;

            $link = $this->build(array(
                'attr' => 'x_mp3',
                'url'  => $url,
                'formhash' => FORMHASH
            ));
            return <<<VIDEO
    <div style="width:100%" class="xigua_media"><iframe $iframe src="$link"></iframe></div>
VIDEO;
        }else if(strpos($url, '.swf') !== false){
            $msg = $this->get_message($tid, $pid);
            $msglower = strtolower($msg);
            $attr = 'swf';
            if(strpos($msglower, '[/flash]') !== FALSE) {
                preg_match("/\[flash\=?([\w,]*)\]\s*".preg_quote($og_url, '/')."\s*\[\/flash\]/ies", $msg, $match);
                $attr .= $match[1] ? ','. $match[1] : '';
            }
            $link = $this->build(array(
                'attr' => $attr,
                'url'  => $url,
                'formhash' => FORMHASH
            ));
            return <<<VIDEO
<div style="width:100%" class="xigua_media"><iframe $this->iframe src="$link"></iframe></div>
VIDEO;
        }
    }

    public function get_message($tid, $pid)
    {
        if(isset($this->messags[$tid .'_' .$pid])){
            return $this->messags[$tid .'_' .$pid];
        }else{
            $this->messags[$tid .'_' .$pid] = DB::result_first("SELECT message FROM %t WHERE pid =%d", array(table_forum_post::get_tablename('tid:' . $tid), $pid));
            return $this->messags[$tid .'_' .$pid];
        }
    }

    public function build($data)
    {
        $data = daddslashes($data);
        global $_G;
        return $_G['siteurl']. 'plugin.php?id='.urlencode('xigua_media:fetchid').'&param='. urlencode(base64_encode(http_build_query($data)));
    }
}

function parsexiguamedia_pc123($attr,$url, $full ){
    global $_G;
    $height = $_G['cache']['plugin']['xigua_media']['height']*2;
    $width  = checkmobile() ? '100%' : '500px';

    if(!$attr){
        $attr = checkmobile() ? '' : "x,500,$height";
    }else{
        list($x, $width, $height) = explode(',', $attr);
        if($width){
            $width = $width.'px';
        }
        if(checkmobile()){
            $width = '100%';
        }
    }

    $og_url = html_entity_decode($url);
    $url = $og_url;
    $urllower = strtolower($url);
    $link = $_G['siteurl']. 'plugin.php?id='.urlencode('xigua_media:fetchid').'&param='. urlencode(base64_encode(http_build_query(array(
            'attr' => $attr,
            'url'  => $url,
            'formhash' => FORMHASH
        ))));
    return '<iframe style="width:'.$width.';height:'.$height.'px" frameborder="0" scrolling="no" allowfullscreen="false" src="'.$link.'"></iframe>';
}