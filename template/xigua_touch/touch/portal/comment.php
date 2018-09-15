<?php exit('xxxxx'); ?>

<!--{eval $backlist = 1;}-->
<!--{eval $navtitle = $csubject[title];}-->
<!--{template common/header}-->

<div class="postlist cl">
    <div class="headtitle">
        <a>
            <h2>$csubject[title]</h2>
        </a>
    </div>
</div>

<div class="weui-cells__title">{lang latest_comment}</div>
<div class="cl bgf">
    <!--{loop $commentlist $comment}-->
    <!--{subtemplate portal/comment_li}-->
    <!--{/loop}-->
</div>

<div class="pgbox">$multi</div>

<!--{if $csubject['allowcomment'] == 1}-->
<div class="ipc">
    <form name="cform" action="portal.php?mod=portalcp&ac=comment" method="post" autocomplete="off">

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

        <!--{if $idtype == 'topicid' }-->
        <input type="hidden" name="topicid" value="$id">
        <!--{else}-->
        <input type="hidden" name="aid" value="$id">
        <!--{/if}-->
        <input type="hidden" name="formhash" value="{FORMHASH}">

        <div class="weui-btn-area mbw">
            <button type="submit" name="commentsubmit" value="true"
                    class="weui-btn weui-btn_primary">{lang comment}
            </button>
        </div>
    </form>
</div>
<!--{/if}-->

<!--{subtemplate common/footer}-->