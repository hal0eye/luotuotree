<?php exit('hehehe!') ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta content="telephone=no" name="format-detection"/>
    <title>{$navtitle}</title>
    <link href="source/plugin/xigua_x/static/common.css?{VERHASH}" rel="stylesheet"/>
    <link href="source/plugin/xigua_x/static/iconfont.css?{VERHASH}" rel="stylesheet"/>
    <link href="source/plugin/xigua_x/static/weui.css?{VERHASH}" rel="stylesheet"/>
    <script src="source/plugin/xigua_x/static/jquery.min.js?{VERHASH}"></script>
    <script src="source/plugin/xigua_x/static/custom.js?{VERHASH}"></script>
    <!--{if $config[bgcolor]}-->
    <style>
        .topavatar{background:{$config[bgcolor]}}
        .ullist li p span{color:{$config[bgcolor]}}
        .btn-orange{background-color:{$config[bgcolor]}}
    </style>
    <!--{/if}-->
</head>
<body>
<div id="page-loading-overlay">
    <div class="ajxloading"></div>
</div>
<div class="topnav cl">
    <!--{if INC_WECHAT && $apple}-->
    <!--{else}-->
    <a class="home-return" href="javascript:window.history.go(-1);">{lang xigua_x:back}</a>
    <!--{/if}-->
</div>
<div class="container_map_ami container_map">
    <div class="topavatar">
        <div class="pa">
            <div class="avatarimg">
                <a href="home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1"><img src="{avatar($_G[uid], 'middle', 1)}"></a>
            </div>
            <span class="username">{$_G[username]}</span>
        </div>
    </div>



    <form method="post" autocomplete="off" id="confirmpost" action="home.php?mod=spacecp&ac=plugin&id=xigua_x:myset">
        <input type="hidden" name="formhash" value="{FORMHASH}" />
        <div class="weui-cells__title">{lang xigua_x:you}</div>

        <div class="weui-cells weui-cells_form">
        <!--{loop $setar $k $v}-->
            <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">{eval echo lang('plugin/xigua_x', $v);}</div>
                <div class="weui-cell__ft">
                    <input name="my[$v]" class="weui-switch" type="checkbox" value="1" <!--{if !$opt[$v]}-->checked<!--{/if}-->>
                </div>
            </div>
        <!--{/loop}-->
        </div>
        <div class="zlistwrap">
            <a href="javascript:;" class="weui-btn weui-btn_primary primaryc">{lang save}</a>
        </div>

    </form>

</div>
<div id="backtotop" class="backtotop"><span class="icon-vertical-align-top"></span></div>
<script>
    $('.primaryc').on('touchstart', function(){
        var form = $('#confirmpost');
        $.ajax({
            type: 'POST',
            url: form.attr('action') + '&inajax=1&ismobile=1',
            data: form.serialize(),
            dataType: 'xml'
        })
            .success(function (s) {
                var html = s.lastChild.firstChild.nodeValue.replace(/<script.*?>([\s\S]*?)<\/script>/ig, '');
                html = $(html).find('p').text();
                alert(html);
                window.location.href = window.location.href;
            })
            .error(function () {
            });
        return false;
    });
</script>
</body>
</html>