<?php exit('xigua_touch');?>
<!--{if $status != 2}-->
<div class="threadlist">
	<div class="news-list-wrapper tab-news-content">
		<!--{if $newthreadlist['dateline']['data']}-->
				<!--{eval $threadlist = x_s2($newthreadlist['dateline']['data']);}-->
				<!--{loop $threadlist $thread}-->
					<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->
					{eval continue;}
					<!--{/if}-->
					<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->
					{eval $displayorder_thread = 1;}
					<!--{/if}-->
					<!--{if $thread['moved']}-->
					<!--{eval $thread[tid]=$thread[closed];}-->
					<!--{/if}-->
					<!--{subtemplate common/thread_list_node}-->
				<!--{/loop}-->
				<!--{if $_G['forum']['threads'] > 10}-->
		<div class="weui-btn-area mbw">
					<a style="margin: 0 auto;display: block;" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]#groupnav" class="button">{lang click_to_readmore}</a>
		</div>
				<!--{/if}-->
		<!--{else}-->
			<div class="news-item tpl-1">
				<a class="guide">
					<h2>{lang forum_nothreads}</h2>
				</a>
			</div>
		<!--{/if}-->
		</div>
</div>

<!--{if helper_access::check_module('group')}-->
<div class="quick-publish"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]"><i class="iconfont icon-pencil"></i></a></div>
<!--{/if}-->
<!--{/if}-->
