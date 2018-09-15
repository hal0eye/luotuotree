<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/25
 * Time: 21:16
 */
function build($data)
{
    $data = daddslashes($data);
    global $_G;
    return $_G['siteurl']. 'plugin.php?id='.urlencode('xigua_media:fetchid').'&param='. urlencode(base64_encode(http_build_query($data)));
}

function parsemedia1($match){
    $a = $match[1];
    $b = $match[2];
    if(strpos($b, '.mp4') === false){
        return "[media=$a]{$b}[/media]";
    }
    $ur = build(array(
        'attr' => 'x_mp3',
        'url'  => $b,
        'formhash' => FORMHASH
    ));

    global $_G;
    $height = $_G['cache']['plugin']['xigua_media']['height'];
    if(checkmobile()){
        $st = "style=\"width:100%;height:{$height}px\"";
    }else{
        $height = $height*2;
        $st = "style=\"width:480px;height:{$height}px\"";
    }

    return "<iframe $st frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"false\" src='$ur'></iframe>";
}

function forbuild11($data)
{
    $data = daddslashes($data);
    global $_G;
    return $_G['siteurl'] . 'plugin.php?id=' . urlencode('xigua_media:fetchid') . '&param=' . urlencode(base64_encode(http_build_query($data)));
}
function parsexiguamedia11($match){
    $attr = $match[2];
    $url = $match[3];
    global $_G;
    $height = $_G['cache']['plugin']['xigua_media']['height'];

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
        $thisiframe = "style=\"width:100%;height:$height\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"false\"";
        $iframe = strpos($urllower, '.mp4') === false ? str_replace("height:$height", "height:40px", $thisiframe) : $thisiframe;

        $link = forbuild11(array(
            'attr' => 'x_mp3',
            'url'  => $url,
            'formhash' => FORMHASH
        ));
        return <<<VIDEO
    <div style="width:100%" class="xigua_media"><iframe $iframe src="$link"></iframe></div>
VIDEO;
    }

    $link = $_G['siteurl']. 'plugin.php?id='.urlencode('xigua_media:fetchid').'&param='. urlencode(base64_encode(http_build_query(array(
            'attr' => $attr,
            'url'  => $url,
            'formhash' => FORMHASH
        ))));
    return '<iframe style="width:100%;height:'.$height.'px" frameborder="0" scrolling="no" allowfullscreen="false" src="'.$link.'"></iframe>';
}
function parsexiguamedia_pc($m){
    $attr = $m[2];
    $url = $m[3];
    $full = $m[0];
    global $_G;
    $height = $_G['cache']['plugin']['xigua_media']['height']*2;
    $width  = checkmobile() ? '100%' : '480px';

    if(
        strpos($url, 'miaopai')===false &&
        strpos($url, 'sohu')===false
    ){
        if(!$_REQUEST['parseall']){
            return $full;
        }
    }

    if(!$attr){
        $attr = checkmobile() ? '' : "x,480,$height";
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
function parsexiguamediamp3($m ){
    $attr = $m[2];
    $url = $m[3];
    global $_G;
    $height = $_G['cache']['plugin']['xigua_media']['height'];

    $og_url = html_entity_decode($url);
    $url = $og_url;
    $urllower = strtolower($url);
    if(
        strpos($urllower, '.mp3') !== false ||
        strpos($urllower, '.m4a') !== FALSE ||
        strpos($urllower, '.ogg') !== false ||
        strpos($urllower, '.wav') !== false
    ){
        $thisiframe = "style=\"width:350px;height:$height\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"false\"";
        $iframe = strpos($urllower, '.mp4') === false ? str_replace("height:$height", "height:40px", $thisiframe) : $thisiframe;

        $link = forbuild11(array(
            'attr' => 'x_mp3',
            'url'  => $url,
            'formhash' => FORMHASH
        ));
        return <<<VIDEO
        <div style="width:100%" class="xigua_media"><iframe $iframe src="$link"></iframe></div>
VIDEO;
    }
}

function parsemedia2($m){
    $a = $m[1];
    $b = $m[2];
    if(strpos($b, '.mp4') === false){
        return "[media=$a]{$b}[/media]";
    }
    $ur = build(array(
        'attr' => 'x_mp3',
        'url'  => $b,
        'formhash' => FORMHASH
    ));
    return "<iframe style=\"width:100%;height:300px\" frameborder=\"0\" scrolling=\"no\" allowfullscreen=\"false\" src='$ur'></iframe>";
}

class plugin_xigua_media
{
    public function discuzcode($param){
        global $_G;
        if($param['caller'] == 'discuzcode') {
            $msglower = strtolower($_G['discuzcodemessage']);

            if(strpos($msglower, '.mp4') !== FALSE) {
                $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
                $_G['discuzcodemessage'] = preg_replace_callback("/\[media\=?([\w,]*)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", "parsemedia1" , $_G['discuzcodemessage']);
            }

            if(strpos($msglower, '[/audio]') !== FALSE){
                $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
                $_G['discuzcodemessage'] = preg_replace_callback("/\[(audio)\=?([\w,]*)\]\s*(.*?)\s*\[\/(audio)\]/is", 'parsexiguamediamp3', $_G['discuzcodemessage']);
            }

            if(
                strpos($msglower, '[/audio]') !== FALSE ||
                strpos($msglower, '[/media]') !== FALSE ||
                strpos($msglower, '[/flash]') !== FALSE
            ){
                $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
                $_G['discuzcodemessage'] = preg_replace_callback("/\[(audio|media|flash)\=?([\w,]*)\]\s*(.*?)\s*\[\/(audio|media|flash)\]/is", 'parsexiguamedia_pc', $_G['discuzcodemessage']);
            }

        }
    }
}
class plugin_xigua_media_portal extends plugin_xigua_media{

    public function view_output($param)
    {
        global $content, $_G;

        $msglower = strtolower($content['content']);

        if(strpos($msglower, '.mp4') !== FALSE) {
            $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
            $content['content'] = preg_replace_callback("/\[media\=?([\w,]*)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", "parsemedia1" , $content['content']);
        }

        if(strpos($msglower, '[/audio]') !== FALSE){
            $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
            $content['content'] = preg_replace_callback("/\[(audio)\=?([\w,]*)\]\s*(.*?)\s*\[\/(audio)\]/is", 'parsexiguamediamp3', $content['content']);
        }

        if(
            strpos($msglower, '[/audio]') !== FALSE ||
            strpos($msglower, '[/media]') !== FALSE ||
            strpos($msglower, '[/flash]') !== FALSE
        ){
            $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
            $_REQUEST['parseall'] = 1;
            $content['content'] = preg_replace_callback("/\[(audio|media|flash)\=?([\w,]*)\]\s*(.*?)\s*\[\/(audio|media|flash)\]/is", 'parsexiguamedia_pc', $content['content']);
        }
    }
}
class mobileplugin_xigua_media_portal extends plugin_xigua_media_portal{

}

class mobileplugin_xigua_media extends plugin_xigua_media {

    public function discuzcode($param){
        global $_G;
        if($param['caller'] == 'discuzcode') {
            $msglower = strtolower($_G['discuzcodemessage']);

            if(strpos($msglower, '.mp4') !== FALSE) {
                $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
                $_G['discuzcodemessage'] = preg_replace_callback("/\[media\=?([\w,]*)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", "parsemedia2" , $_G['discuzcodemessage']);
            }

            if(
                strpos($msglower, '[/audio]') !== FALSE ||
                strpos($msglower, '[/media]') !== FALSE ||
                strpos($msglower, '[/flash]') !== FALSE
            ){
                $_G['discuzcodemessage'] = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", "parseattachurl_callback", $_G['discuzcodemessage']);
                $_G['discuzcodemessage'] = preg_replace_callback("/\[(audio|media|flash)\=?([\w,]*)\]\s*(.*?)\s*\[\/(audio|media|flash)\]/is", 'parsexiguamedia11', $_G['discuzcodemessage']);
            }
        }
    }

}


function parseattachurl_callback($match) {
    $aid = $match[1];
    $ext = $match[2];
    $ignoretid = 1;
    global $_G;
    $_G['forum_skipaidlist'][] = $aid;
    return $_G['siteurl'].'forum.php?mod=attachment&aid='.aidencode($aid, $ext, $ignoretid ? '' : $_G['tid']).($ext ? '&request=yes&_f=.'.$ext : '');
}

/*
 *
 * <!--{eval}-->
<!--
function parse_article_media2( $url, $att){
    global $_G;
    $data = daddslashes(array(
        'attr' => $att,
        'url'  => $url,
        'formhash' => FORMHASH
    ));
    $link = $_G['siteurl']. 'plugin.php?id='.urlencode('xigua_media:fetchid').'&param='. urlencode(base64_encode(http_build_query($data)));
    return <<<VIDEO
<div style="width:100%" class="xigua_media"><iframe style="width:100%;height:240px" frameborder="0" scrolling="no" allowfullscreen="true" ____src="$link"></iframe></div>
VIDEO;
}
-->
<!--{/eval}-->
<!--{eval
global $content;
$contents= C::t('portal_article_content')->fetch_all($aid);
$content = $contents[0];
$message = $content['content'];

if(preg_match('/<embed.*?sid\/([^\.]+)\/v.swf(.*?)>/iU', $message, $match)):
    $html5src = "http://player.youku.com/embed/$match[1]";
    $media = "<iframe height=\"200\" width=\"100%\" src=\"$html5src\" frameborder=\"0\" allowfullscreen=\"false\"></iframe>";
    $message = str_replace($match[0], $media, $message);
else:
    $message = preg_replace("/\[(media|flash)\=?([\w,]*)\]\s*(.*?)\s*\[\/(media|flash)\]/ies", "parse_article_media2('\\3', '\\4')",  $message);
endif;
    echo str_replace(array('100%', '____src'), array('98%', 'src'), $message);

}-->
*/