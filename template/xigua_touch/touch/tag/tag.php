<?php exit; ?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<!--{if $type != 'countitem'}-->

<form method="post" action="misc.php?mod=tag">
    <div class="search weui-flex">
        <div class="weui-flex__item">
            <input autocomplete="off" class="input" id="scform_srchtxt" value="" name="name" placeholder="{lang tag}">
        </div>
        <div>
            <input type="submit" value="{lang search}" class="button2" id="scform_submit">
        </div>
    </div>
</form>

<div class="xg_taglist cl">
    <!--{if $tagarray}-->
    <!--{eval $i=0;}-->
    <!--{loop $tagarray $tag}-->
    <!--{eval $t = $i % 5;}-->
    <a href="misc.php?mod=tag&id=$tag[tagid]" class="bcolor_{eval echo mt_rand(1,10);} tag_bg t$t">$tag[tagname]</a>
    <!--{eval $i++;}-->
    <!--{/loop}-->
    <!--{else}-->
    <div class="wmt">{lang no_tag}</div>
    <!--{/if}-->
</div>

<!--{else}-->
$num
<!--{/if}-->

<!--{template common/footer}-->