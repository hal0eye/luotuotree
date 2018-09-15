<?php exit('xxxx'); ?>
<!--{if $_GET['mycenter'] && !$_G['uid']}-->
<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
<!--{/if}-->
<!--{if $_GET['mycenter'] && ($space['uid'] != $_G['uid'])}-->
<!--{eval dheader("Location:home.php?mod=space&uid=$space[uid]&do=profile&mobile=2");exit;}-->
<!--{/if}-->

<!--{eval $backlist=1;}-->
<!--{template common/header}-->

<!-- userinfo start -->
<div class="userinfo">
    <div class="user_avatar">
        <div class="avatar_m"><span><img src="<!--{avatar($space[uid], 'big', true)}-->" /></span></div>
        <h2 class="name">$space[username]</h2>

        <div class="mod-lv user-level bgcolor_{echo usergroup_iconid($space[groupid])}">
            <span class="mod-lv-icon color_{echo usergroup_iconid($space[groupid])}"><i class="iconfont icon-<!--{if $space[gender]==1}-->nan<!--{elseif $space[gender]==2}-->nv<!--{else}-->biaoxing<!--{/if}-->"></i></span>
            <span>{$_G['cache']['usergroups'][$space['groupid']]['grouptitle']}</span>
        </div>

    </div>

    <!--{if $_GET[mycenter]}-->
    <!--{template home/mycenter}-->
    <!--{else}-->
    <!--{template home/mycredit}-->
    <!--{/if}-->

    <!--{if $space['uid'] == $_G['uid']}-->
    <div class="weui-cells myprofile nobg">
        <div class="weui-btn-area mbw"><a class="btn_pn weui-btn weui-btn_primary" href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout_mobile}</a></div>
    </div>
    <!--{/if}-->
</div>
<!-- userinfo end -->


<!--{template common/footer}-->
