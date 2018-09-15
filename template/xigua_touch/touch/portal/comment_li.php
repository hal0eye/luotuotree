<?php exit('xxxx');?>
<div class="plc cl postitem">
    <span class="avatar"><img src="{avatar($comment['uid'],'middle',true)}" style="width:32px;height:32px;"></span>
    <ul class="authi">
        <li class="grey">
            <!--{if !empty($comment['uid'])}-->
            <a href="home.php?mod=space&uid=$comment[uid]" class="blue">$comment[username] <!--{if $comment[status] == 1}-->({lang moderate_need})<!--{/if}--></a>
            <!--{else}-->
            <a>{lang guest} <!--{if $comment[status] == 1}-->({lang moderate_need})<!--{/if}--></a>
            <!--{/if}-->

            <!--{if ($_G['group']['allowmanagearticle'] || $_G['uid'] == $comment['uid']) && $_G['groupid'] != 7 && !$article['idtype']}-->
            <div class="replybtn y">
                <a href="portal.php?mod=portalcp&ac=comment&op=edit&cid=$comment[cid]" id="c_$comment[cid]_edit" >{lang edit}</a>
                <a href="portal.php?mod=portalcp&ac=comment&op=delete&cid=$comment[cid]" id="c_$comment[cid]_delete">{lang delete}</a>
            </div>
            <!--{/if}-->
        </li>
        <li class="grey rela f12"><!--{date($comment[dateline])}--></li>
    </ul>
    <div class="display pi postmessage1">
        <div class="message"><!--{if $_G[adminid] == 1 || $comment[uid] == $_G[uid] || $comment[status] != 1}-->$comment[message]<!--{else}-->{lang moderate_not_validate}<!--{/if}--></div>

    </div>
</div>
