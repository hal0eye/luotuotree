<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16/016
 * Time: 0:34
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_xigua_x
{

    function global_footer()
    {
        global $_G;
        if(!$_G['cache']['plugin']){
            loadcache('plugin');
        }
        $config = $_G['cache']['plugin']['xigua_x'];
        if(!$config['auto']){
            return false;
        }

        $timespace = intval($config['timespace'])*1000;
        if($timespace <5000){
            $timespace = 5000;
        }

        $formhash = FORMHASH;

        return <<<HTML
<script>
var myformhash = '$formhash', xtimespace = $timespace;
check_x_cron();
function check_x_cron(){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "plugin.php?id=xigua_x:cron&formhash="+myformhash, true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.onreadystatechange = function(){ if (xhr.readyState == 4 && xhr.status == 200) {
        if(xhr.responseText=='stop' || xhr.responseText.length>20 || xhr.responseText.length<1){
        }else{
            setTimeout(function() {
              check_x_cron();
            }, xhr.responseText?xhr.responseText:xtimespace );
        }
    }  };
    xhr.send();
}
</script>
HTML;
    }
}
class  mobileplugin_xigua_x extends plugin_xigua_x{
    function global_footer_mobile(){
        return parent::global_footer();
    }
}