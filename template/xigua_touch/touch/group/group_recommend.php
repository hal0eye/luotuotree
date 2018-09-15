<?php exit('xigua_touch');?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<div class="weui-cells__title">{lang group_push_to_forum}</div>
<form method="post" autocomplete="off" id="form_$_GET[handlekey]" name="form_$_GET[handlekey]" action="forum.php?mod=group&action=recommend&fid=$_G[fid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'form_$_GET[handlekey]');"{/if}>
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="grouprecommend" value="true" />
	<input type="hidden" name="inajax" value="$_G[inajax]" />
	<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="c" id="return_$_GET[handlekey]">
	</div>
<div class="weui-cells">
    <div class="weui-cell weui-cell_select">
        <div class="weui-cell__bd">
            <select id="recommend" name="recommend" class="weui-select">
                <option value="0">{lang group_do_not_push}</option>
                $forumselect
            </select>
        </div>
    </div>

</div>

<div class="weui-btn-area mbw">
    <button type="submit" value="true" class="btn_pn weui-btn weui-btn_primary"><strong>{lang confirms}</strong></button>
</div>
</form>
<!--{template common/footer}-->