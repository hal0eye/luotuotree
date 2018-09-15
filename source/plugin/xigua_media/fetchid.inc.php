<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

if(submitcheck('param', true))
{
    $param = base64_decode($_GET['param']);
    parse_str($param, $xmediainfo);

    include_once libfile('function/discuzcode');
    $url = $xmediainfo['url'];
    $attr = $xmediainfo['attr'];

    loadcache('plugin');
    $config = $_G['cache']['plugin']['xigua_media'];
    $width = '100%';
    $height = $config['height'] ? $config['height'] .'px' : '240px';

    $attr = explode(',', $attr);
    $param = $attr[0] . ",$width,$height";
    if(!checkmobile()){
        $width = $attr[1] ? $attr[1].'px': '570px';
        $height = $attr[2]? $attr[2].'px': ($config['height']*2).'px';
    }

    if($xmediainfo['attr'] == 'x_mp3'){
        $media = "<audio style='width:100%' src='$url' controls='controls'></audio>";
        if(strpos(strtolower($url), '.mp4') !== false){
            $media = "<video style='width:100%;height:$height' src='$url' controls='controls'></video>";
        }
    }else{
        if(strpos($url, 'youku.com') !== false)
        {
            if(strpos($url, 'Type/Folder/Fid') !== false){
                $url = preg_replace('#Type\/Folder\/Fid\/[^\/]+/[^\/]+/[^\/]+\/(sid\/[^\/]+/v\.swf)#i', '$1', $url);
            }
            $match = array();
            if(preg_match('/https?\:\/\/player\.youku\.com\/player\.php\/sid\/([^\/]+)\/v\.swf/i', $url, $match)){
                $html5src = "http://player.youku.com/embed/$match[1]";
                if(strpos($html5src, '.html') !==false){
                    $html5src = str_replace('.html','', $html5src);
                }
            }else if(preg_match('/https?\:\/\/\w+\.youku\.com\/(v_show|video)\/id_([^\.]+).*?/i', $url, $match)){
                $html5src = "http://player.youku.com/embed/$match[2]";
            }
        }else if(strpos($url, 'qq.com') !== false){
            $url = str_replace('&amp;', '&', $url);
            $url_array = parse_url($url);
            parse_str($url_array['query'], $querys);
            $vid = $querys['vid'];
            if(empty($vid)){
                if(preg_match('#\/(\w+)\.html$#i', $url, $match)){
                    $querys['vid'] = $vid = $match[1];
                }
            }

            $querys['width'] = $width;
            $querys['height'] = $height ? intval($height) : '';
            $querys['auto'] = 0;
            $html5src = 'http://v.qq.com/iframe/player.html?'. http_build_query($querys);
        }else if(strpos($url, 'tudou.com') !== false){
            if (dstrpos($url, array('tudou.com/albumplay/', 'tudou.com/listplay/', 'tudou.com/programs/'))) {
                $pattern = '/https?:\/\/(www.)?tudou.com\/((albumplay\/(?:.+)|listplay|programs)\/(.+))/i';
            } elseif (dstrpos($url, array('tudou.com/a/', 'tudou.com/l/'))) {
                $pattern = '/https?:\/\/(www.)?tudou.com\/(a|l)\/(.+)iid=(\d+)\/v.swf/i';
            } elseif (strexists($url, 'tudou.com/v/')) {
                $pattern = '/https?:\/\/(www.)?tudou.com\/v\/([^\/]+)\//i';
            }
            if (preg_match($pattern, $url, $match)) {
                if (strpos($url, 'tudou.com/albumplay/') !== false || strpos($url, 'tudou.com/listplay/')!== false || strpos($url, 'tudou.com/programs/')!== false) {
                    $api = 'http://www.tudou.com/' . $match[2];
                } elseif (strpos($url,  'tudou.com/a/')!== false || strpos($url, 'tudou.com/l/')!== false ) {
                    $retdata = dfsockopen('http://api.tudou.com/v3/gw?method=item.info.get&appKey=8a09ac1cb1458af3&format=json&itemCodes=' . $match[4]);
                    if ($retdata1 = json_decode($retdata, true)) {
                        $api = 'http://www.tudou.com/programs/view/' . $retdata1['multiResult']['results'][0]['itemCode'];
                    }
                } elseif (strpos($url, 'tudou.com/v/') !== false) {
                    $api = 'http://www.tudou.com/programs/view/' . $match[2];
                }

                $retdata = dfsockopen($api);
                if (strpos($url, 'tudou.com/programs/')!== false|| strpos($url, 'tudou.com/l/')!== false || strpos($url,'tudou.com/v/')!==false ) {
                    if (!empty($retdata) && preg_match('/icode:\s?\'(.+?)\'(.+?)pic:\s?\'(.+?)\'(.+?)kw:\s?\'(.+?)\'/is', $retdata, $match)) {
                        $html5src = 'http://www.tudou.com/programs/view/html5embed.action?code='.$match[1] ;
                    }
                } else {
                    if (!empty($retdata) && preg_match('/icode:\s?\'(.+?)\'(?:.+?)kw:\s?\'(.+?)\'(?:.+?)pic:\s?\'(.+?)\'/is', $retdata, $match)) {
                        $html5src = 'http://www.tudou.com/programs/view/html5embed.action?code='.$match[1] ;
                    }
                }
            }

            if(!$html5src && preg_match("/https?:\/\/(www.)?tudou.com\/v\/([^\/]+)/i", $url, $matches)) {
                $html5src = 'http://www.tudou.com/programs/view/html5embed.action?code='.$matches[2] . '&amp;tiny=0&amp;auto=0';;
            }
        }else if (preg_match("/https?:\/\/v.ifeng.com\/(.+)(\/|#|guid=)([a-zA-Z0-9\-]{36})/i", $url, $matches)) {
            $api = dfsockopen('http://v.ifeng.com/video_info_new/'.substr($matches[3], -2, 1).'/'.substr($matches[3], -2).'/'.$matches[3].'.xml');
            if (!empty($api) && preg_match("/Name=\"(.+?)\"(.+)BigPosterUrl=\"(.+?)\"(?:.+)VideoPlayUrl=\"(.+?)\" PlayerUrl=\"(.+?)\"/i", $api, $match)) {
                $html5src = $match[4];
            }
        }else if (preg_match("/https?:\/\/(www|player).56.com\/(.+)?(v_|vid-)(.+?)(.html|.swf)(.*?)/i", $url, $match)) {
            $iframe = 'http://www.56.com/iframe/'.$match[4];
            $api = dfsockopen('http://vxml.56.com/json/'.$match[4].'/');
            if ($retdata = json_decode($api, true)) {
                $html5src = 'http://vxml.56.com/html5/'.$retdata['info']['vid'];
            }
        }else if (preg_match("/https?:\/\/(?:www.youtube.com|youtu.be)\/(?:watch\?(?:.+)?v=|embed\/)?([a-zA-Z0-9-]+)/i", $url, $match)) {
            if ($match[1]) {
                $html5src = 'http://www.youtube.com/embed/'. $match[1];
            }
        }else if (preg_match('/https?:\/\/www\.miaopai\.com\/show\/(.*?)\.htm(.*?)/i', $url, $tmpm)){
            $json = dfsockopen('http://gslb.miaopai.com/stream/'.$tmpm[1].'.json?token=');
            $array = json_decode($json,true);
            if($array['status'] != 200 || !$array['result'][0]['host'] || !$array['result'][0]['scheme'] || !$array['result'][0]['path']){
            }else{
                $url = $array['result'][0]['scheme'].$array['result'][0]['host'].$array['result'][0]['path'];
            }
        }else if(preg_match("#(http\:|https\:)?//(.*?)\.sohu\.com/(\d+)/v\.swf/*?#i", $url, $tmpm)){
            if (!empty($tmpm[3]))
            {
                $html5src = "http://tv.sohu.com/upload/static/share/share_play.html#{$tmpm[3]}";
            }
        }else if(preg_match("#(http\:|https\:)?//(.*?)\.sohu\.com/us/(\d+)/.*?\.shtml*?#i", $url, $tmpm)){
            if (!empty($tmpm[3]))
            {
                $html5src = "http://tv.sohu.com/upload/static/share/share_play.html#{$tmpm[3]}";
            }
        }

        if($html5src){
            $html5src = str_replace('http://', '//', $html5src);
            $media = <<<IFRAME
<iframe height="$height" width="$width" src="$html5src" frameborder="0" allowfullscreen="false"></iframe>
IFRAME;
        }else{
            $media = parsemedia($param, $url);
            if(is_array($media)){
                $media = "<a href=\"$media[swf]\" class=\"media\">$media[swf]</a>";
            }
            if(strpos($media, '/v.swf') !== false && strpos($media, 'sid/')!==false){
                if(preg_match('/.*?sid\/([^\.]+)\/v.swf.*?/i', $media, $match)){
                    $html5src = "http://player.youku.com/embed/$match[1]";
                    $media = "<iframe height=\"$height\" width=\"$width\" src=\"$html5src\" frameborder=\"0\" allowfullscreen=\"false\"></iframe>";
                }
            }
        }
    }

if(!$html5src && (strpos(strtolower($url), '.mp4') !== false || strpos(strtolower($url), '.mov') !== false)){
    $media = "<video style='width:100%;height:$height' src='$url' controls='controls'></video>";
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="<?php echo CHARSET?>">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <style type="text/css">
    *{margin:0;padding:0;}
    embed,iframe,object{width:100%!important;max-width:100%!important;}
</style>
<script type="text/javascript" src="<?php echo $_G['siteurl']?>static/js/common.js"></script>
</head>
<body>
<script type="text/javascript">
    function xg_mobileplayer() {
        var platform = navigator.platform;
        var ua = navigator.userAgent;
        var ios = /iPhone|iPad|iPod/.test(platform) && ua.indexOf( "AppleWebKit" ) > -1;
        var andriod = ua.indexOf( "Android" ) > -1;
        if(ios || andriod) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php echo str_replace('mobileplayer()', 'xg_mobileplayer()', $media)?>
</body>
</html>
<?php
}