<?php exit('xxxx');?>
<!--{eval $backlist=1;}-->
<!--{template common/header}-->


<!--{eval $_G['forum_threadcount'] = count($list);}-->
<!--{eval $_G['forum_threadlist'] = $list;}-->
<!-- header start -->
<header class="header">
    <div class="nav">
       <a href="home.php?mod=space&uid=1&do=profile&mycenter=1" class="z"><img src="{STATICURL}image/mobile/images/icon_back.png" /></a>
	   <span>{lang mythread}</span>
   </div>
</header>
<!-- header end -->
<!-- main threadlist start -->
<div class="threadlist">
	<div class="news-list-wrapper tab-news-content thread_list_node2_list">
		<!--{if $_G['forum_threadcount']}-->
            <!--{eval $_G['forum_threadlist'] = x_s2($_G['forum_threadlist']);}-->
            <!--{loop $_G['forum_threadlist'] $key $thread}-->
                <!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->
                    {eval continue;}
                <!--{/if}-->
                <!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->
                    {eval $displayorder_thread = 1;}
                <!--{/if}-->

                <!--{if $thread['moved']}-->
                    <!--{eval $thread[tid]=$thread[closed];}-->
                <!--{/if}-->

                <!--{hook/forumdisplay_thread_mobile $key}-->

                <!--{subtemplate common/thread_list_node2}-->

            <!--{/loop}-->
		<!--{else}-->
		<div class="news-item tpl-1">
			<a class="guide">
				<h2>{echo lang('forum/template', 'guide_nothreads');}</h2>
			</a>
		</div>
		<!--{/if}-->
	</div>
	$multi
</div>
<!-- main threadlist end -->
<!--{template common/footer}-->
