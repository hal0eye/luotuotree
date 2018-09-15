<?php exit('xxxxx');?>


<div class="weui-flex myprofile_cols" style="position:relative;">
    <a href="home.php?mod=space&do=pm&mobile=2" class="weui-flex__item">
        <i class=" iconfont icon-pinglunyehuifu"></i>
        <p class="">{lang mypm}</p>
        <!--{if $_G[member][newpm]}--><span class="weui-badge" style="position: absolute;top: -.1em;right: 0;background-color:{$_G['style']['color2']}">{$_G[member][newpm]}</span><!--{/if}-->
    </a>
    <a href="home.php?mod=space&do=friend&mobile=2" class="weui-flex__item">
        <i class=" iconfont icon-haoyou"></i>
        <p class="">{lang my_friends}</p>
    </a>
    <a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread" class="weui-flex__item">
        <i class=" iconfont icon-favorite"></i>
        <p class="">{lang myfavorite}</p>
    </a>
    <a href="home.php?mod=space&uid={$_G[uid]}&do=thread&view=me" class="weui-flex__item">
        <i class=" iconfont icon-xiangqu"></i>
        <p class="">{lang mythread}</p>
    </a>

    <div class="water">
        <div class="water-c">
            <div class="water-1"></div>
            <div class="water-2"></div>
        </div>
    </div>
</div>

<div class="weui-cells myprofile">
    <a class="weui-cell weui-cell_access" href="home.php?mod=space&do=notice">
        <div class="weui-cell__hd"><i class=" iconfont icon-naozhong"></i></div>
        <div class="weui-cell__bd">
            <span>{echo xtl('wodetixing');}</span>
            <!--{if $_G[member][newprompt]}--><span class="weui-badge" style="margin-left: 5px;">$_G[member][newprompt]</span><!--{/if}-->
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <a class="weui-cell weui-cell_access" href="home.php?mod=space&uid={$_G[uid]}&do=profile">
        <div class="weui-cell__hd"><i class=" iconfont icon-yijianfankui"></i></div>
        <div class="weui-cell__bd">
            <p>{lang myprofile}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <a class="weui-cell weui-cell_access" href="home.php?mod=follow&do=following&uid={$_G[uid]}">
        <div class="weui-cell__hd"><i class=" iconfont icon-xiaoxi1"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('myfav');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <a class="weui-cell weui-cell_access" href="home.php?mod=follow&view=other">
        <div class="weui-cell__hd"><i class=" iconfont icon-repaitop"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('guangbo');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{if $_G['cache']['plugin']['xigua_member']}-->
    <a class="weui-cell weui-cell_access" href="plugin.php?id=xigua_member:profile">
        <div class="weui-cell__hd"><i class=" iconfont icon-ziliao"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('xiu');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <!--{if $_G['cache']['plugin']['xigua_verify']}-->
    <a class="weui-cell weui-cell_access" href="plugin.php?id=xigua_verify">
        <div class="weui-cell__hd"><i class=" iconfont icon-yirenzheng"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('ren');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <a class="weui-cell weui-cell_access" href="home.php?mod=space&do=profile&uid={$_G[uid]}&view=credit">
        <div class="weui-cell__hd"><i class=" iconfont icon-jifen"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('jifen');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>

    <!--{if $_G['cache']['plugin']['xigua_sf']}-->
    <a class="weui-cell weui-cell_access" href="home.php?mod=spacecp&ac=plugin&id=xigua_sf:setting">
        <div class="weui-cell__hd"><i class=" iconfont icon-tixian1"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('shoufei');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <!--{if $_G['cache']['plugin']['xigua_x']}-->
    <a class="weui-cell weui-cell_access" href="home.php?mod=spacecp&ac=plugin&id=xigua_x:myset">
        <div class="weui-cell__hd"><i class=" iconfont icon-xiaoxizhongxin"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('xiao');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <!--{if $_G['cache']['plugin']['xigua_re']}-->
    <a class="weui-cell weui-cell_access" href="home.php?mod=spacecp&ac=plugin&id=xigua_re:setting">
        <div class="weui-cell__hd"><i class=" iconfont icon-qian"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('da');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <!--{if $_G['cache']['plugin']['xigua_c']}-->
    <a class="weui-cell weui-cell_access" href="plugin.php?id=xigua_c">
        <div class="weui-cell__hd"><i class=" iconfont icon-tixian1"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('c');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <!--{if $_G['cache']['plugin']['xigua_t']}-->
    <a class="weui-cell weui-cell_access" href="plugin.php?id=xigua_t">
        <div class="weui-cell__hd"><i class=" iconfont icon-tixian"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('t');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->
    <!--{if $_G['cache']['plugin']['xigua_login']}-->
    <a class="weui-cell weui-cell_access" href="home.php?mod=spacecp&ac=plugin&id=xigua_login:xgbind">
        <div class="weui-cell__hd"><i class=" iconfont icon-bangding"></i></div>
        <div class="weui-cell__bd">
            <p>{echo xtl('b');}</p>
        </div>
        <div class="weui-cell__ft"> </div>
    </a>
    <!--{/if}-->


    <!--{eval $mycenters = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['mycenter'])));}-->
    <!--{loop $mycenters $mycenter}-->
    <!--{eval list($font, $link, $icon)= explode(",", trim($mycenter)); }-->
    <a class="weui-cell weui-cell_access" href="{$link}">
        <div class="weui-cell__hd"><!--{if $icon}--><img src="$icon" style="width:20px;height:20px;vertical-align:middle" /><!--{else}--><i class="iconfont icon-zonghe"></i><!--{/if}--></div>
        <div class="weui-cell__bd">
            <p>$font</p>
        </div>
        <div class="weui-cell__ft"></div>
    </a>
    <!--{/loop}-->
    <!--{if CURMODULE == 'space'}-->
    <!--{hook/space_profile_baseinfo_bottom}-->
    <!--{elseif CURMODULE == 'follow'}-->
    <!--{hook/follow_profile_baseinfo_bottom}-->
    <!--{/if}-->

</div>
