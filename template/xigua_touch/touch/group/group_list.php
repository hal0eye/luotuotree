<?php exit('xigua_touch');?>
<!--{if !($_G['forum']['threadtypes']['types']||$_G['forum']['threadsorts']['types']) }-->
<ul id="thread_types" class="ttp  cl">

	<li id="ttp_all" <!--{if $_REQUEST['sortall']==1||(!$_REQUEST['typeid'] && !$_REQUEST['sortid']&& !$_REQUEST['filter'])}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang forum_viewall}</a></li>
	<li <!--{if $_REQUEST['filter']=='lastpost'}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=lastpost&orderby=lastpost&mobile=2">{echo xtl('zuixin');}</a></li>
	<li <!--{if $_REQUEST['filter']=='digest'}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=digest&digest=1&orderby=lastpost&mobile=2">{echo xtl('jinghua');}</a></li>
	<li <!--{if $_REQUEST['filter']=='heat'}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=heat&orderby=heats&mobile=2">{echo xtl('remen');}</a></li>
</ul>
<!--{else}-->
<div class="banner">
	<nav class="weui-flex">
		<a class="<!--{if $_REQUEST['sortall']==1||(!$_REQUEST['typeid'] && !$_REQUEST['sortid']&& !$_REQUEST['filter'])}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang forum_viewall}</a>
		<a class="<!--{if $_REQUEST['filter']=='lastpost'}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=lastpost&orderby=lastpost&mobile=2">{echo xtl('zuixin');}</a>
		<a class="<!--{if $_REQUEST['filter']=='digest'}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=digest&digest=1&orderby=lastpost&mobile=2">{echo xtl('jinghua');}</a>
		<a class="<!--{if $_REQUEST['filter']=='heat'}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=heat&orderby=heats&mobile=2">{echo xtl('remen');}</a>

		<!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
		<a class="<!--{if $_REQUEST['typeid'] == $id}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a>
		<!--{/loop}-->

		<!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
		<a class="<!--{if $_REQUEST['sortid'] == $id}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a>
		<!--{/loop}-->

	</nav>
</div>
<div class="banner_fix cl"></div>
<!--{/if}-->



<div class="threadlist">
	<div class="news-list-wrapper tab-news-content">
		<!--{if $_G['forum_threadlist']}-->
		<!--{eval $threadlist = x_s2($_G['forum_threadlist']);}-->
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
<!--{if $multipage}--><div class="pgbox">$multipage</div><!--{/if}-->
<div class="quick-publish"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]"><i class="iconfont icon-pencil"></i></a></div>
<!--{/if}-->