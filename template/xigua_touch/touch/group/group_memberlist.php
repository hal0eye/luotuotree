<?php exit('xigua_touch');?>
<!--{if $op == 'alluser'}-->
	<!--{if $adminuserlist}-->
	<div class="bm">
		<div class="weui-cells__title">{lang group_admin_member}</div>
		<div class="weui-cells">

			<!--{loop $adminuserlist $user}-->
			<div class="weui-cell">
				<div class="weui-cell__hd"><a href="home.php?mod=space&uid=$user[uid]"><img src="<!--{echo avatar($user[uid], 'small', true)}-->" alt="" style="width:20px;margin-right:5px;display:block"></a></div>
				<div class="weui-cell__bd">
					<p style="font-size:14px;"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
				</div>
			</div>
			<!--{/loop}-->
		</div>
	</div>
	<!--{/if}-->
	<!--{if $staruserlist || $alluserlist}-->
	<div class="bm">
		<div class="weui-cells__title">{lang member}</div>
		<div class="weui-cells">
			<!--{eval $ulist = array_merge($staruserlist, $alluserlist);}-->
			<!--{loop $staruserlist $user}-->
			<div class="weui-cell">
				<div class="weui-cell__hd"><a href="home.php?mod=space&uid=$user[uid]"><img src="<!--{echo avatar($user[uid], 'small', true)}-->" alt="" style="width:20px;margin-right:5px;display:block"></a></div>
				<div class="weui-cell__bd">
					<p style="font-size:14px;"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
				</div>
			</div>
			<!--{/loop}-->
		</div>
	</div>
	<!--{/if}-->
	<!--{if $multipage}--><div class="pgbox">$multipage</div><!--{/if}-->
<!--{/if}-->