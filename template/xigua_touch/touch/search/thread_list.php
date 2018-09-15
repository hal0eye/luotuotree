<?php exit('xxxx');?>
<div class="threadlist">
	<h2 class="thread_tit"><!--{if $keyword}-->{lang search_result_keyword} <!--{if $modfid}--><a href="forum.php?mod=modcp&action=thread&fid=$modfid&keywords=$modkeyword&submit=true&do=search&page=$page" target="_blank">{lang goto_memcp}</a><!--{/if}--><!--{else}-->{lang search_result}<!--{/if}--></h2>
	<div class="news-list-wrapper tab-news-content">
	<!--{if empty($threadlist)}-->

	<div class="news-item tpl-1">
		<a class="guide">
			<h2>{lang search_nomatch}</h2>
		</a>
	</div>
	<!--{else}-->
        <!--{eval $threadlist = x_s2($threadlist);}-->
        <!--{loop $threadlist $thread}-->
        <!--{subtemplate common/thread_list_node}-->
        <!--{/loop}-->

	<!--{/if}-->
	</div>
	$multipage
</div>
