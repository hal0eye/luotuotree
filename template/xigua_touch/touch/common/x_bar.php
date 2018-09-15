<?php exit('xigua_exit!')?>

<!--{if !$nofooter && !$noxb}-->
<div class="weui_tabbar">


    <!--{eval $bottomstr = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['bottomstr'])));}-->
    <!--{if $bottomstr}-->
    <!--{loop $bottomstr $bottoms}-->
    <!--{eval list($font, $link, $icon)= explode(",", trim($bottoms)); }-->
    <a href="$link" class="weui_tabbar_item">
        <div class="weui_tabbar_icon">
            <img src="$icon" style="width:22px;height:22px;vertical-align:middle" />
        </div>
        <p class="weui_tabbar_label">{$font}</p>
    </a>
    <!--{/loop}-->
    <!--{else}-->
    <a href="forum.php" class="weui_tabbar_item <!--{if (CURMODULE=='index'||CURMODULE=='guide')&& !$_GET['forumlist']}-->weui_bar_item_on<!--{/if}-->">
        <div class="weui_tabbar_icon">
            <i class="icon iconfont icon-shouye<!--{if (CURMODULE=='index'||CURMODULE=='guide')&& !$_GET['forumlist']}--><!--{/if}-->"></i>
        </div>
        <p class="weui_tabbar_label">{echo xtl('home');}</p>
    </a>
    <a href="forum.php?forumlist=1&mobile=2" class="weui_tabbar_item {if $_GET['forumlist']}weui_bar_item_on{/if} ">
        <div class="weui_tabbar_icon">
            <i style="font-size: 20px!important;" class="icon iconfont icon-zonghe{if $_GET['forumlist']}{/if}"></i>
        </div>
        <p class="weui_tabbar_label">{echo xtl('forum');}</p>
    </a>
    <a <!--{if $_G[fid]}-->href="forum.php?mod=post&action=newthread&fid=$_G[fid]"<!--{else}-->href="forum.php?mod=misc&action=nav&mobile=2"<!--{/if}--> class="weui_tabbar_item {if $postpage}weui_bar_item_on{/if}  ">
    <div class="weui_tabbar_icon">
        <i class="icon iconfont icon-{if $postpage}ziliao{else}ziliao{/if}"></i>
    </div>
    <p class="weui_tabbar_label">{echo xtl('fatie');}</p>
    </a>
    <a href="search.php?mod=forum&mobile=2" class="weui_tabbar_item  <!--{if (CURSCRIPT=='search')}-->weui_bar_item_on<!--{/if}-->">
        <div class="weui_tabbar_icon">
            <i class="icon iconfont icon-fatie"></i>
        </div>
        <p class="weui_tabbar_label">{echo xtl('faxian');}</p>
    </a>
    <!--{/if}-->

    <!--{if $_G['uid'] || $_G['connectguest']}-->
    <a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="weui_tabbar_item <!--{if (CURMODULE=='space'||CURMODULE=='home')&&(!($_REQUEST[uid]&&$_REQUEST[uid]!=$_G[uid]))}-->weui_bar_item_on<!--{/if}-->">
        <div class="weui_tabbar_icon">
            <img class="img" src="{avatar($_G[uid], middle, true)}" />
            <!--{if $_G[member][newpm] || $_G[member][newprompt]}-->
            <span class="weui-badge weui-badge_dot" style="position: absolute;top: 0;right: -6px;"></span>
            <!--{/if}-->
        </div>
        <p class="weui_tabbar_label">{echo xtl('wode');}</p>
    </a>
    <!--{else}-->
    <a href="member.php?mod=logging&action=login" class="weui_tabbar_item">
        <div class="weui_tabbar_icon">
            <i class="icon iconfont icon-wo"></i>
            <!--{if $_G[member][newpm] || $_G[member][newprompt] || $_G['connectguest'] }--><!--{/if}-->
        </div>
        <p class="weui_tabbar_label">{lang login}</p>
    </a>
    <!--{/if}-->
</div>
<!--{/if}-->