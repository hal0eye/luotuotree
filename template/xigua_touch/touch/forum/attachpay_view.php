<?php exit('xigua_touch');?>
<!--{eval $backlist=1;}-->
<!--{subtemplate common/header}-->
<div class="ct">
	<div class="pbm ptn">
        <table cellspacing="0" cellpadding="0" class="tfm vt">
			<tr>
				<td>{lang username}</td>
				<td>{lang time}</td>
				<td>{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}</td>
			</tr>
			<!--{if $loglist}-->
				<!--{loop $loglist $log}-->
					<tr>
						<td><a href="home.php?mod=space&uid=$log[uid]">$log[username]</a></td>
						<td>$log[dateline]</td>
						<td>{$log[$extcreditname]} {$_G[setting][extcredits][$_G[setting][creditstransextra][1]][unit]}</td>
					</tr>
				<!--{/loop}-->
			<!--{else}-->
				<tr><td colspan="3"><div class="xg1" style="text-align:center;">{lang attachment_buy_not}</div></td></tr>
			<!--{/if}-->
		</table>
	</div>
</div>

<!--{subtemplate common/footer}-->