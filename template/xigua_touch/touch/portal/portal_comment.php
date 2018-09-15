<?php exit('xxxx'); ?>

<div class="weui-cells__title">{lang latest_comment}</div>
<div class="cl bgf">

    <!--{loop $commentlist $comment}-->
    <!--{template portal/comment_li}-->
    <!--{/loop}-->

    <!--{if $data[commentnum]}-->
    <div class="weui-cells__title tc">
        <a href="$common_url" class="xi2">{lang view_all_comments}(<em id="_commentnum">$data[commentnum]</em>)</a>
    </div>
    <!--{/if}-->

</div>
<div class="ipc">
    <form id="cform" name="cform" action="$form_url" method="post" autocomplete="off">

        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" name="message" rows="3" id="message"></textarea>
                </div>
            </div>
        </div>


        <!--{if checkperm('seccode') && ($secqaacheck || $seccodecheck)}-->
        <!--{subtemplate common/seccheck}-->
        <!--{/if}-->
        <!--{if !empty($topicid) }-->
        <input type="hidden" name="referer" value="portal.php?mod=topic&topicid=$topicid#comment"/>
        <input type="hidden" name="topicid" value="$topicid">
        <!--{else}-->
        <input type="hidden" name="portal_referer" value="portal.php?mod=view&aid=$aid#comment">
        <input type="hidden" name="referer" value="portal.php?mod=view&aid=$aid#comment"/>
        <input type="hidden" name="id" value="$data[id]"/>
        <input type="hidden" name="idtype" value="$data[idtype]"/>
        <input type="hidden" name="aid" value="$aid">
        <!--{/if}-->
        <input type="hidden" name="formhash" value="{FORMHASH}">
        <input type="hidden" name="replysubmit" value="true">
        <input type="hidden" name="commentsubmit" value="true"/>
        <div class="weui-btn-area mbw">
            <button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true"
                    class="weui-btn weui-btn_primary">{lang comment}
            </button>
        </div>
    </form>
</div>