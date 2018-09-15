<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{eval $group = $_G['group'];}-->
<!--{template common/header}-->
<div class="weui-cells">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <p>{lang memcp_usergroup}</p>
        </div>
        <div class="weui-cell__ft">{$group['grouptitle']}</div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <p>{lang spacecp_usergroup_message2}</p>
        </div>
        <div class="weui-cell__ft">{$group['groupcreditshigher']}</div>
    </div>
    <!--{echo permtbody($group)}-->
</div>

{eval
function permtbody($maingroup) {
global $_G, $bperms, $pperms, $sperms, $aperms,$permlang;
}

<div class="weui-cell">
    <div class="weui-cell__bd">
        <p>{lang user_level}</p>
    </div>
    <div class="weui-cell__ft">LV{$_G['cache']['usergroups'][$maingroup['groupid']]['stars']}</div>
</div>

<!--{loop $bperms $key $groupbperm}-->
<div class="weui-cell">
    <div class="weui-cell__bd">
        <p>$permlang['perms_'.$groupbperm]</p>
    </div>
    <div class="weui-cell__ft">
        <!--{if $groupbperm == 'creditshigher' || $groupbperm == 'readaccess' || $groupbperm == 'maxpmnum'}-->
        $maingroup[$groupbperm]
        <!--{elseif $groupbperm == 'allowsearch'}-->
        <!--{if $maingroup['allowsearch'] == '0'}-->{lang permission_basic_disable_sarch}<!--{elseif $maingroup['allowsearch'] == '1'}-->{lang permission_basic_search_title}<!--{else}-->{lang permission_basic_search_content}<!--{/if}-->
        <!--{else}-->
        <!--{if $maingroup[$groupbperm] >= 1}--><i class="iconfont icon-zhengque color_1"></i><!--{else}--><i class="iconfont icon-cuowu color_2"></i><!--{/if}-->
        <!--{/if}-->
        
    </div>
</div>

<!--{/loop}-->

<!--{loop $pperms $key $grouppperm}-->

<div class="weui-cell">
    <div class="weui-cell__bd">
        <p>$permlang['perms_'.$grouppperm]</p>
    </div>
    <div class="weui-cell__ft">
        <!--{if in_array($grouppperm, array('maxsigsize', 'maxbiosize'))}-->
        $maingroup[$grouppperm] {lang bytes}
        <!--{elseif $grouppperm == 'allowrecommend'}-->
        <!--{if $maingroup[allowrecommend] > 0}-->+$maingroup[allowrecommend]<!--{else}--><i class="iconfont icon-cuowu color_2"></i><!--{/if}-->
        <!--{elseif in_array($grouppperm, array('allowat', 'allowcreatecollection'))}-->
        <!--{echo intval($maingroup[$grouppperm])}-->
        <!--{else}-->
        <!--{if $maingroup[$grouppperm] == 1 || (in_array($grouppperm, array('raterange', 'allowcommentpost')) && !empty($maingroup[$grouppperm]))}--><i class="iconfont icon-zhengque color_1"></i><!--{else}--><i class="iconfont icon-cuowu color_2"></i><!--{/if}-->
        <!--{/if}-->
        
    </div>
</div>
<!--{/loop}-->

<!--{loop $sperms $key $perm}-->
<div class="weui-cell">
    <div class="weui-cell__bd">
        <p>$permlang['perms_'.$perm]</p>
    </div>
    <div class="weui-cell__ft">
        <!--{if in_array($perm, array('maxspacesize', 'maximagesize'))}-->
        <!--{if $maingroup[$perm]}-->$maingroup[$perm]<!--{else}-->{lang permission_attachment_nopermission}<!--{/if}-->
        <!--{else}-->
        <!--{if $maingroup[$perm] == 1}--><i class="iconfont icon-zhengque color_1"></i><!--{else}--><i class="iconfont icon-cuowu color_2"></i><!--{/if}-->
        <!--{/if}-->
    </div>
</div>
<!--{/loop}-->

<!--{loop $aperms $key $groupaperm}-->

<div class="weui-cell">
    <div class="weui-cell__bd">
        <p>$permlang['perms_'.$groupaperm]</p>
    </div>
    <div class="weui-cell__ft">
        <!--{if in_array($groupaperm, array('maxattachsize', 'maxsizeperday', 'maxattachnum'))}-->
        <!--{if $maingroup[$groupaperm]}-->$maingroup[$groupaperm]<!--{else}-->{lang permission_attachment_nopermission}<!--{/if}-->
        <!--{elseif $groupaperm == 'attachextensions'}-->
        <!--{if $maingroup[allowpostattach] == 1}--><!--{if $maingroup[attachextensions]}--><p>$maingroup[attachextensions]</p><!--{else}-->{lang permission_attachment_nopermission}<!--{/if}--><!--{else}--><i class="iconfont icon-cuowu color_2"></i><!--{/if}-->
        <!--{else}-->
        <!--{if $maingroup[$groupaperm] == 1}--><i class="iconfont icon-zhengque color_1"></i><!--{else}--><i class="iconfont icon-cuowu color_2"></i><!--{/if}-->
        <!--{/if}-->
        
    </div>
</div>

<!--{/loop}-->
<!--{eval
}
}-->
<!--{template common/footer}-->