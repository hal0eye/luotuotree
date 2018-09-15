<?php exit('xxxxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{eval $navtitle = '';}-->
<!--{subtemplate common/header}-->

<div class="cl">
    <!--{if $_GET['op'] == 'edit'}-->
    <div class="weui-cells__title">{lang comment_edit_content}</div>

    <form id="editcommentform_{$cid}" name="editcommentform_{$cid}" method="post" autocomplete="off"
          action="portal.php?mod=portalcp&ac=comment&op=edit&cid=$cid{if $_GET[modarticlecommentkey]}&modarticlecommentkey=$_GET[modarticlecommentkey]{/if}">
        <input type="hidden" name="referer" value="{echo dreferer()}"/>
        <input type="hidden" name="editsubmit" value="true"/>
        <!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]"/><!--{/if}-->
        <input type="hidden" name="formhash" value="{FORMHASH}"/>

        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" id="message_{$cid}" name="message" rows="3" id="message">$comment[message]</textarea>
                </div>
            </div>
        </div>
        <div class="weui-btn-area mbw">
            <button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true"
                    class="weui-btn weui-btn_primary">{lang submit}
            </button>
        </div>
    </form>


    <!--{elseif $_GET['op'] == 'delete'}-->
    <form id="deletecommentform_{$cid}" name="deletecommentform_{$cid}" method="post" autocomplete="off"
          action="portal.php?mod=portalcp&ac=comment&op=delete&cid=$cid">
        <input type="hidden" name="referer" value="{echo dreferer()}"/>
        <input type="hidden" name="deletesubmit" value="true"/>
        <input type="hidden" name="formhash" value="{FORMHASH}"/>
        <!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]"/><!--{/if}-->
        <div class="weui-cells__title">{lang comment_delete_confirm}</div>
        <div class="weui-btn-area mbw">
            <button type="submit" name="deletesubmitbtn" value="true"
                    class="weui-btn weui-btn_primary">{lang confirms}
            </button>
        </div>

    </form>

    <!--{/if}-->

</div>

<!--{subtemplate common/footer}-->