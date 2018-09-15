<?php exit;?>
<!--{if $thread['freemessage']}-->
	<div id="postmessage_$pid" class="t_f">$thread[freemessage]</div>
<!--{/if}-->
<!--{if empty($_GET['archiver'])}-->
	<div class="locked mtm">

				<a href="forum.php?mod=misc&action=pay&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET['from'])}&from=$_GET['from']{/if}" class="dialog y viewpay button2" title="{lang pay}">{lang pay}</a>

			<div class="right">
				<!--{if $thread[payers]}-->{lang have} $thread[payers] {lang people_buy}&nbsp; <!--{/if}-->
			</div>
			<!--{if $_G[forum_thread][price] > 0}-->{lang pay_comment}<!--{/if}-->
			<!--{if $thread[endtime]}--><br />{lang pay_free_time}<!--{/if}-->
	</div>

<!--{else}-->
	<div class="locked mtm">
	<!--{if $thread[payers]}-->{lang have} $thread[payers] {lang people_buy}&nbsp; <!--{/if}-->
	<!--{if $_G[forum_thread][price] > 0}-->{lang pay_comment}<!--{/if}-->
	<!--{if $thread[endtime]}--><br />{lang pay_free_time}<!--{/if}-->
	</div>
<!--{/if}-->