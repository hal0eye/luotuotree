<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/14
 * Time: 11:31
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class xigua_integralmall
{
    public function viewthread_variables(& $params)
    {
        global $_G;

        foreach ($params['postlist'] as $key => $post) {
            if($post['first'] == 1 && C::t('#xigua_integralmall#xigua_intmall')->check($post['tid'])){

                $src = $_G['siteurl'].'plugin.php?id=xigua_integralmall&operation=viewthread&from1=api&showilist=1&ifr=1&tid='.$post['tid'];
                $exthtml = <<<HTML
<style>#iframepage{transition: all 0.2s linear;-webkit-transition: all 0.2s linear;-moz-transition: all 0.2s linear;min-width:100%;width:92vw;min-height:600px;border:0;}</style ><script>
function iFrameHeight() {
  setTimeout(function(){
      var ifm= document.getElementById("iframepage");
      var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;
      if(ifm != null && subWeb != null) {
        ifm.height = subWeb.body.clientHeight;
      }
  }, 1200);
}</script >
HTML;

                $params['postlist'][$key]['message'] = '<iframe id="iframepage" scrolling="no" onload="iFrameHeight();" src="'.$src.'"></iframe>'.$post['message'].$exthtml;
            }
        }
    }

    public function profile_variables(& $variables)
    {
        global $_G;
        if($_GET['backurl']){
            $_G['messageparam'] = array();
            $params = base64_decode($_GET['backurl']);
            $variables['function'] = array_merge(
                array('XIR' => array('WSQ.location', array($params))),
                (array)$variables['function']
            );
        }
    }

    public function profile_authorInfo(){
        if($_GET['backurl']){
            return '<div style="display:none"><wsqscript>XIR()</wsqscript></div>';
        }
        return '';
    }
}