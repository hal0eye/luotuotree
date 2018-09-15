<?php
/**
 * Created by PhpStorm.
 * User: yzg
 * Date: 2015/8/3
 * Time: 13:37
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT . 'source/plugin/xigua_integralmall/init.php';

class plugin_xigua_integralmall
{
    /*function deletethread($param) {
        global $config;

        if($param['step'] == 'delete') {
            if($tid = $param['param'][0][0]) {
                $idata = C::t('#xigua_integralmall#xigua_intmall')->fetch($tid);
                if(!$idata['status']) {
                    $users = C::t('#xigua_integralmall#xigua_intmall_log')->get_unsettle($tid);
                    foreach ($users as $v) {
                        updatemembercount($v['uid'], array('extcredits'.$config['credit'] => $v['currentprice']), false, 'CUC', $tid);
                        notification_add(
                            $v['uid'],
                            'system',
                            lang('plugin/xigua_integralmall', 'del_back'),
                            array(
                                'subject' => $idata['goodname'],
                            ),
                            1
                        );
                    }
                }
                C::t('#xigua_integralmall#xigua_intmall')->delete_by_tid($tid);
                C::t('#xigua_integralmall#xigua_intmall_log')->delete_by_tid($tid);
                C::t('#xigua_integralmall#xigua_intmall_code')->delete_by_tid($tid);
            }
        }
    }*/
}

class plugin_xigua_integralmall_home extends plugin_xigua_integralmall {

    function spacecp_credit_bottom_output(){
        global $_G;
        lang('spacecp');
        $_G['lang']['spacecp']['logs_credit_update_CUC'] = lang('plugin/xigua_integralmall', 'log');

    }
}

class mobileplugin_xigua_integralmall_forum extends plugin_xigua_integralmall {
    public function viewthread_mydefined_output(){
        global $postlist, $_G;
        foreach ($postlist as $k => $post) {
            if($post['first'] == 1 && C::t('#xigua_integralmall#xigua_intmall')->check($post['tid'])){
                $js =<<<HTML
<style>#iframepage{transition: all 0.2s linear;-webkit-transition: all 0.2s linear;-moz-transition: all 0.2s linear;min-width:100%;width:92vw;min-height:600px;border:0;}</style><script>
function iFrameHeight() {
  setTimeout(function(){
      var ifm= document.getElementById("iframepage");
      var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;
      if(ifm != null && subWeb != null) {
        ifm.height = subWeb.body.clientHeight;
      }
  }, 1200);
}</script>
HTML;
                $src = $_G['siteurl'].'plugin.php?id=xigua_integralmall&operation=viewthread&ifr=1&showilist=1&tid='.$post['tid'];
                $postlist[$k]['message'] = '<iframe id="iframepage" scrolling="no" onload="iFrameHeight();" src="'.$src.'"></iframe>'.$post['message'].$js;
            }
        }
    }
}