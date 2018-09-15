<?php exit('xxx'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="{if $_G['setting']['mobile'][mobilecachetime] > 0}{$_G['setting']['mobile'][mobilecachetime]}{else}no-cache{/if}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if},$_G['setting']['bbname']" />
<title><!--{if !empty($navtitle)}-->$navtitle<!--{/if}--><!--{if !$_G['cache']['plugin']['xigua_th']['hidewaptitle']}--><!--{if empty($nobbname)}--> - $_G['setting']['bbname']<!--{/if}--> {lang waptitle} - Powered by Discuz!<!--{/if}--></title><base href="http://www.luotuotree.com/">
<link href="{IMGDIR}/common.css?{VERHASH}" rel="stylesheet"/>
<link href="{IMGDIR}/iconfont.css?{VERHASH}" rel="stylesheet"/>

<!--{eval
if (empty($_G['cache']['plugin'])) :
    loadcache('plugin');
endif;
}-->
<!--{eval include_once DISCUZ_ROOT.TPLDIR.'/php/discuz.php';}-->
<!--{eval include_once DISCUZ_ROOT.TPLDIR.'/php/lang.php';}-->
<script src="template/xigua_touch/xtatic/jquery-1.11.3.min.js?{VERHASH}"></script>
<script src="{IMGDIR}/jquery.lazyload.min.js?{VERHASH}"></script>

<script type="text/javascript">var STYLEID = '{STYLEID}', STATICURL = '{STATICURL}', IMGDIR = '{IMGDIR}', VERHASH = '{VERHASH}', charset = '{CHARSET}', discuz_uid = '$_G[uid]', cookiepre = '{$_G[config][cookie][cookiepre]}', cookiedomain = '{$_G[config][cookie][cookiedomain]}', cookiepath = '{$_G[config][cookie][cookiepath]}', showusercard = '{$_G[setting][showusercard]}', attackevasive = '{$_G[config][security][attackevasive]}', disallowfloat = '{$_G[setting][disallowfloat]}', creditnotice = '<!--{if $_G['setting']['creditnotice']}-->$_G['setting']['creditnames']<!--{/if}-->', defaultstyle = '$_G[style][defaultextstyle]', REPORTURL = '$_G[currenturl_encode]', SITEURL = '$_G[siteurl]', JSPATH = '$_G[setting][jspath]';var relatedlink = [];var safescripts = {}, evalscripts = [];
var NOFASKCLICK=<!--{if $noclick}-->1;<!--{else}-->0;<!--{/if}-->var VOTESUCCEED = '{echo xtl("toucheng");}'; var CLOSEBTXT = '{echo xtl('close');}';</script>

<script src="{IMGDIR}/common.js?{VERHASH}" charset="utf-8"></script>
<script src="{IMGDIR}/xigua.js?{VERHASH}" charset="{CHARSET}"></script>
<!--{if $_G['cache']['plugin']['xigua_th']['color1']}--><!--{eval $_G['style']['color1'] = $_G['cache']['plugin']['xigua_th']['color1'];}--><!--{/if}-->
<!--{if $_G['cache']['plugin']['xigua_th']['color2']}--><!--{eval $_G['style']['color2'] = $_G['cache']['plugin']['xigua_th']['color2'];}--><!--{/if}-->
<style>
<!--{if $_G['style']['color1']}-->
.banner nav a.active,.color_11,.guidenav .a a, #thread_types li.xw1 a, .myprofile i,.weui_tabbar_item.weui_bar_item_on .weui_tabbar_icon,.weui_tabbar_item.weui_bar_item_on .weui_tabbar_label{color:{$_G['style']['color1']}!important;}
.button, .bgcolor_11,.myprofile_cols, .user_avatar, .forumlist .sub_forum li a span.num, .weui-btn_disabled,.weui-btn_primary{background:{$_G['style']['color1']}!important;}
<!--{/if}-->
<!--{if $_G['style']['color2']}-->
.favuserbtn{border-color:{$_G['style']['color2']}!important}
.yd-classify-wrapper .classify-names a.active:before, .quick-publish,.dialog_green,.dialog_green:after,.stick li .ico-laba, .button2,.button{background-color:{$_G['style']['color2']}!important;}
.yd-classify-wrapper .classify-names a.active, .m_article_channel,.favuserbtn,.mod-post-list-item-content .post-component .post-component-vote .vote-title .G-ico,.mod-post-list-item-content .post-component .post-component-vote .vote-title .G-ico-circle,.mod-post-list-item-content .post-component .post-component-vote .vote-title .mod-share .icon-share,.mod-share .mod-post-list-item-content .post-component .post-component-vote .vote-title .icon-share {color:{$_G['style']['color2']}!important;}<!--{/if}-->
<!--{if !$_G['cache']['plugin']['xigua_th']['fillimg']}-->.mod-post-list-item-content .photo,.showpic{margin-left:0;margin-right:0}<!--{/if}-->
.mod-cricle-headertypes em.hot{background:{$_G['cache']['plugin']['xigua_th']['color_11']}!important}
.bgcolor_1{background-color:{$_G['cache']['plugin']['xigua_th']['color_1']}!important}
.bgcolor_2{background-color:{$_G['cache']['plugin']['xigua_th']['color_2']}!important}
.bgcolor_3{background-color:{$_G['cache']['plugin']['xigua_th']['color_3']}!important}
.bgcolor_4{background-color:{$_G['cache']['plugin']['xigua_th']['color_4']}!important}
.bgcolor_5{background-color:{$_G['cache']['plugin']['xigua_th']['color_5']}!important}
.bgcolor_6{background-color:{$_G['cache']['plugin']['xigua_th']['color_6']}!important}
.bgcolor_7{background-color:{$_G['cache']['plugin']['xigua_th']['color_7']}!important}
.bgcolor_8{background-color:{$_G['cache']['plugin']['xigua_th']['color_8']}!important}
.bgcolor_9{background-color:{$_G['cache']['plugin']['xigua_th']['color_9']}!important}
.bgcolor_10{background-color:{$_G['cache']['plugin']['xigua_th']['color_10']}!important}
.bcolor_1{border-color:{$_G['cache']['plugin']['xigua_th']['color_1']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_1']}!important}
.bcolor_2{border-color:{$_G['cache']['plugin']['xigua_th']['color_2']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_2']}!important}
.bcolor_3{border-color:{$_G['cache']['plugin']['xigua_th']['color_3']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_3']}!important}
.bcolor_4{border-color:{$_G['cache']['plugin']['xigua_th']['color_4']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_4']}!important}
.bcolor_5{border-color:{$_G['cache']['plugin']['xigua_th']['color_5']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_5']}!important}
.bcolor_6{border-color:{$_G['cache']['plugin']['xigua_th']['color_6']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_6']}!important}
.bcolor_7{border-color:{$_G['cache']['plugin']['xigua_th']['color_7']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_7']}!important}
.bcolor_8{border-color:{$_G['cache']['plugin']['xigua_th']['color_8']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_8']}!important}
.bcolor_9{border-color:{$_G['cache']['plugin']['xigua_th']['color_9']}!important ;color:{$_G['cache']['plugin']['xigua_th']['color_9']}!important}
.bcolor_10{border-color:{$_G['cache']['plugin']['xigua_th']['color_10']}!important;color:{$_G['cache']['plugin']['xigua_th']['color_10']}!important}
.color_1{color:{$_G['cache']['plugin']['xigua_th']['color_1']}!important}
.color_2{color:{$_G['cache']['plugin']['xigua_th']['color_2']}!important}
.color_3{color:{$_G['cache']['plugin']['xigua_th']['color_3']}!important}
.color_4{color:{$_G['cache']['plugin']['xigua_th']['color_4']}!important}
.color_5{color:{$_G['cache']['plugin']['xigua_th']['color_5']}!important}
.color_6{color:{$_G['cache']['plugin']['xigua_th']['color_6']}!important}
.color_7{color:{$_G['cache']['plugin']['xigua_th']['color_7']}!important}
.color_8{color:{$_G['cache']['plugin']['xigua_th']['color_8']}!important}
.color_9{color:{$_G['cache']['plugin']['xigua_th']['color_9']}!important}
.color_10{color:{$_G['cache']['plugin']['xigua_th']['color_10']}!important}
<!--{if $_G['cache']['plugin']['xigua_th']['fontweight']}-->
* {font-weight:$_G['cache']['plugin']['xigua_th']['fontweight']}
<!--{else}-->
<!--{/if}-->
</style>
</head>

<body class="bg">
<!--{hook/global_header_mobile}-->
<header class="x_header bgcolor_11 cl" <!--{if stripos($_SERVER['HTTP_USER_AGENT'], 'Appbyme') !== false}-->style="display:none"<!--{/if}-->>
    <div class="thr">
        <!--{if $backlist}-->

        <!--{if $_GET[fromguid] == 'hot'}-->
            <!--{eval $backhref = "forum.php?mod=guide&view=hot&page=$_GET[page]";}-->
        <!--{elseif $_G[fid]>0&&!$_GET[fid]}-->
            <!--{eval $backhref = "forum.php?mod=forumdisplay&fid=$_G[fid]&".rawurldecode($_GET[extra]);}-->
        <!--{else}-->
        <!--{eval $backhref = "javascript:window.history.go(-1);";}-->
        <!--{/if}-->
        <!--{if $_GET[mod]=='post'}-->
            <!--{eval $backhref = "javascript:window.history.go(-1);";}-->
        <!--{/if}-->


        <a class="y" href="{$backhref}"><i class="iconfont icon-xiangzuojiantou"></i> </a>
        <!--{else}-->
        <a href="./forum.php">
            <!--{if $_G['cache']['plugin']['xigua_th']['logo']}-->
            <img src="{$_G['cache']['plugin']['xigua_th']['logo']}" />
            <!--{else}-->
            <img src="{$_G['style']['logo']}" />
            <!--{/if}-->
        </a>
        <!--{/if}-->
    </div>
    <!--{if !$hide_right}-->
        <a class="y sidectrl" href="javascript:;"><i class="iconfont icon-caidan"></i></a>
        <!--{if (CURMODULE=='index'||CURMODULE=='guide')&& !$_GET['forumlist']}-->
        <a class="y" href="search.php?mod=forum&mobile=2" style="padding-right:0"><i class="iconfont icon-sousuo"></i></a>
        <!--{/if}-->
    <!--{else}-->
        <a class="y" href="forum.php"><i class="icon iconfont icon-shouye"></i></a>
    <!--{/if}-->
    <!--{if !empty($navtitle)&&$backlist }-->
        <!--{if $shownavtitle}-->
        $shownavtitle
        <!--{else}-->
        $navtitle
        <!--{/if}-->
    <!--{/if}-->
</header>


<div class="right_sidebox">
    <div class="oh cl sidebox_userinfo">
        <!--{if $_G[uid]}-->
        <div class=" bg-blur" style="background-image: url({avatar($_G[uid], big, true)});"></div>
        <!--{else}-->
        <div class=" bg-blur" style="background-image: url(template/xigua_touch/xtatic/avatarbg.jpg);"></div>
        <!--{/if}-->
        <div class="sidebox_avatar cl">
            <a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1"><img src="{avatar($_G[uid], middle, true)}" /></a>
            <h3><!--{if $_G[username]}-->{$_G[username]}<!--{else}-->{lang guest}<!--{/if}--></h3>
            <!--{if $_G[uid]}-->
            <a class="nlink" href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" ><i class="iconfont icon-shezhi vm"></i> {echo lang('core', 'title_setup')}</a>
            <a class="nlink" href="member.php?mod=logging&action=logout&formhash={FORMHASH}"><i class="iconfont icon-fenxiang vm"></i> {lang logout}</a>
            <!--{else}-->
            <a  class="nlink" href="member.php?mod=logging&action=login" title="{lang login}">[{lang login}]</a>
                <!--{if $_G['setting']['regstatus']}-->
                <a  class="nlink" href="member.php?mod={$_G[setting][regname]}" title="{lang register}">[{lang register}]</a>
                <!--{/if}-->
            <!--{/if}-->
        </div>
    </div>
    <div class="weui-cells cl right_sideboxnav">
        <a class="weui-cell weui-cell_access" href="forum.php?mobile=2">
            <div class="weui-cell__hd"><i class="iconfont icon-shouye"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('home');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="forum.php?forumlist=1&mobile=2">
            <div class="weui-cell__hd"><i class="iconfont icon-zonghe"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('forum');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="search.php?mod=forum&mobile=2">
            <div class="weui-cell__hd"><i class="iconfont icon-fatie"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('faxian');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="forum.php?mod=misc&action=nav&mobile=2">
            <div class="weui-cell__hd"><i class="iconfont icon-ziliao"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('fatie');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="home.php?mod=space&uid=$_G[uid]&do=favorite&view=me&mobile=2">
            <div class="weui-cell__hd"><i class="iconfont icon-zhuti"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('fav');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="misc.php?mod=tag&mobile=2">
            <div class="weui-cell__hd"><i class="iconfont icon-tag"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('tag');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>

        <!--{eval $sideboxnavs = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['sideboxnav'])));}-->
        <!--{loop $sideboxnavs $sideboxnav}-->
        <!--{eval list($font, $link, $icon)= explode(",", trim($sideboxnav)); }-->
        <a class="weui-cell weui-cell_access" href="{$link}">
            <div class="weui-cell__hd"><!--{if $icon}--><img src="$icon" style="width:20px;height:20px;vertical-align:middle" /> <!--{else}--><i class="iconfont icon-zonghe"></i><!--{/if}--> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>$font</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <!--{/loop}-->

        <a class="weui-cell weui-cell_access" href="javascript:window.location.reload();">
            <div class="weui-cell__hd"><i class="iconfont icon-shuaxin"></i> &nbsp; </div>
            <div class="weui-cell__bd">
                <p>{echo xtl('shuaxin');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>
</div>
<div class="sidemask"></div>