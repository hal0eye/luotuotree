<?php exit('xxx'); ?>

<!--{eval $backlist=1;}-->
<!--{template common/header}-->
<!-- header start -->

<ul id="thread_types" class="ttp cl">
    <li <!--{if !$_REQUEST['type']}-->class="xw1 a"<!--{/if}-->><a style="width:33%" href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me">{lang favorite_all}</a></li>
    <li <!--{if $_REQUEST['type'] == 'forum'}-->class="xw1 a"<!--{/if}-->><a style="width:33%" href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=forum">{lang favforum}</a></li>
    <li <!--{if $_REQUEST['type'] == 'thread'}-->class="xw1 a"<!--{/if}-->><a style="width:33%" href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">{lang favthread}</a></li>
</ul>

<!-- main collectlist start -->

<div class="weui-cells">

    <!--{if $list}-->
    <!--{loop $list $k $value}-->

    <div class="weui-cell" >
        <div class="weui-cell__bd">
            <a href="$value[url]">$value[title]</a>
        </div>
        <div class="weui-cell__ft">
            <a href="home.php?mod=spacecp&ac=favorite&op=delete&favid=$value[favid]&type=$_GET[type]&mobile=2" class="dialog"><i class="iconfont icon-shanchu"></i></a>
        </div>
    </div>
    <!--{/loop}-->
    <!--{else}-->

    <div class="weui-cell" href="javascript:;">
        <div class="weui-cell__bd">
            <p>{lang no_favorite_yet}</p>
        </div>
    </div>
    <!--{/if}-->

</div>

<!-- main collectlist end -->
$multi
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
