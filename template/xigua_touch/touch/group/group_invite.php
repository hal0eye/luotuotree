<?php exit('xigua_touch');?>

<div class="cl">
<form method="post" autocomplete="off" name="groupform" id="groupform" class="s_clear" action="forum.php?mod=group&action=invite">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="fid" value="$_G[fid]" />
		<input type="hidden" name="referer" value="{echo dreferer()}" />
	<div class="weui-cells weui-cells_form">
		<!--{loop $friendarray $uid $member}-->
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<input type="checkbox" name="inviteuid[]" value="$uid">$member[username] $member[avatar]
				</div>
			</div>
		<!--{/loop}-->
	</div>
	<div class="weui-cells__title">{lang group_choose_friend_to_invite}</div>

	<div class="weui-cells weui-cells_form">
	<div class="weui-cells">
		<div class="weui-cell">
			<div class="weui-cell__bd">
				<input class="weui-input" type="text" name="invitemsg" placeholder="{lang group_invite_list}">
			</div>
		</div>
	</div>
	</div>

	<div class="weui-btn-area mbw">
		<button class="btn_pn weui-btn weui-btn_primary" type="submit" name="invitesubmit" value="true" tabindex="1"><strong>{lang finished}</strong></button>
	</div>
</form>
</div>