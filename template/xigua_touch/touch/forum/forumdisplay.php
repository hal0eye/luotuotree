<?php exit('xxxx');?>
<!--{eval $backlist = 1;}-->
<!--{eval $shownavtitle = '<a href="javascript:;" class="morefilter_a"><span class="spantit">'.$navtitle.'</span><span class="morefilter animated"><i class="iconfont icon-xiangxiajiantou"></i></span></a>';}-->
<!--{template common/header}-->

<!--{hook/forumdisplay_top_mobile}-->
<!-- main threadlist start -->

<!--{if !($_G['forum']['threadtypes']['types']||$_G['forum']['threadsorts']['types']) }-->
<ul id="thread_types" class="ttp  cl">

    <li id="ttp_all" <!--{if $_REQUEST['sortall']==1||(!$_REQUEST['typeid'] && !$_REQUEST['sortid']&& !$_REQUEST['filter'])}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang forum_viewall}</a></li>
    <li <!--{if $_REQUEST['filter']=='lastpost'}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost&mobile=2">{echo xtl('zuixin');}</a></li>
    <li <!--{if $_REQUEST['filter']=='digest'}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=digest&digest=1&orderby=lastpost&mobile=2">{echo xtl('jinghua');}</a></li>
    <li <!--{if $_REQUEST['filter']=='heat'}-->class="xw1 a"<!--{/if}-->><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats&mobile=2">{echo xtl('remen');}</a></li>
</ul>
<!--{else}-->
<div class="banner">
    <nav class="weui-flex">
        <a class="<!--{if $_REQUEST['sortall']==1||(!$_REQUEST['typeid'] && !$_REQUEST['sortid']&& !$_REQUEST['filter'])}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang forum_viewall}</a>
        <a class="<!--{if $_REQUEST['filter']=='lastpost'}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost&mobile=2">{echo xtl('zuixin');}</a>
        <a class="<!--{if $_REQUEST['filter']=='digest'}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=digest&digest=1&orderby=lastpost&mobile=2">{echo xtl('jinghua');}</a>
        <a class="<!--{if $_REQUEST['filter']=='heat'}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats&mobile=2">{echo xtl('remen');}</a>

        <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
        <a class="<!--{if $_REQUEST['typeid'] == $id}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a>
        <!--{/loop}-->

        <!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
        <a class="<!--{if $_REQUEST['sortid'] == $id}-->active<!--{/if}-->" href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a>
        <!--{/loop}-->

    </nav>
</div>
<div class="banner_fix cl"></div>
<!--{/if}-->

<!--{if $quicksearchlist && !$_GET['archiveid']}-->
<!--{subtemplate forum/search_sortoption}-->
<!--{/if}-->

<div class="nav_expand_panel">

    <nav class="fastpost_title weui-flex">
        <a>&nbsp;</a>
        <div class="weui-flex__item">{echo xtl('gengduocaozuo');}</div>
        <a id="nav_expand_panel_hide" href="javascript:;"><i class="iconfont icon-close"></i></a>
    </nav>

    <!--{if $_G['forum']['threadtypes']['types']}-->
    <div class="weui-panel weui-panel_access mt0">
        <div class="weui-panel__hd">{echo xtl('zhutifenlei');}</div>
        <div class="weui-panel__bd">

            <ul class="nor xg_taglist cl">
                <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
                <!--{if $_GET['typeid'] == $id}-->
                <li><a class="bgcolor_10" href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['sortid']}&filter=sortid&sortid=$_GET['sortid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><!--{if $_G[forum][threadtypes][icons][$id] && $_G['forum']['threadtypes']['prefix'] == 2}--><img class="vm" src="$_G[forum][threadtypes][icons][$id]" alt="" /> <!--{/if}-->$name</a></li>
                <!--{else}-->
                <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><!--{if $_G[forum][threadtypes][icons][$id] && $_G['forum']['threadtypes']['prefix'] == 2}--><img class="vm" src="$_G[forum][threadtypes][icons][$id]" alt="" /> <!--{/if}-->$name</a></li>
                <!--{/if}-->
                <!--{/loop}-->

                <!--{hook/forumdisplay_threadtype_inner}-->
            </ul>
        </div>
    </div>
    <!--{/if}-->

    <!--{if $_G['forum']['threadsorts']['types']}-->
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">{echo xtl('frnlei');}</div>
        <div class="weui-panel__bd">

            <ul class="nor xg_taglist cl">
                <!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
                <!--{if $_GET['sortid'] == $id}-->
                <li><a class="bgcolor_10" href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid=$_GET['typeid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a></li>
                <!--{else}-->
                <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a></li>
                <!--{/if}-->
                <!--{/loop}-->
            </ul>
        </div>
    </div>
    <!--{/if}-->


    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">{echo xtl('gaoji');}</div>
        <div class="weui-panel__bd">
            <ul class="nor xg_taglist cl">
                <li><a class="nobg">{echo xtl('paixu');} </a></li>
                <li><a <!--{if $_GET['orderby']=='replies'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=replies&mobile=2" >{echo xtl('huicha');}</a></li>
                <li><a <!--{if $_GET['filter']=='author'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline&mobile=2" >{echo xtl('fatieshijian');}</a></li>
                <li><a <!--{if $_GET['orderby']=='views'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=views&mobile=2" >{echo xtl('chakan');}</a></li>
            </ul>
            <ul class="nor xg_taglist cl">
                <li><a class="nobg">{echo xtl('shjian');}: </a></li>
                <li><a <!--{if $_GET['orderby']=='lastpost'&& $_GET['filter']=='dateline'&&!$_GET['dateline']}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&mobile=2">{echo xtl('shijian1');}</a></li>
                <li><a <!--{if $_GET['dateline']=='86400'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&dateline=86400&mobile=2" >{echo xtl('shijian2');}</a></li>
                <li><a <!--{if $_GET['dateline']=='172800'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&dateline=172800&mobile=2" >{echo xtl('shijian3');}</a></li>
                <li><a <!--{if $_GET['dateline']=='604800'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&dateline=604800&mobile=2" >{echo xtl('shijian4');}</a></li>
                <li><a <!--{if $_GET['dateline']=='2592000'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&dateline=2592000&mobile=2" >{echo xtl('shijian5');}</a></li>
                <li><a <!--{if $_GET['dateline']=='7948800'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&dateline=7948800&mobile=2" >{echo xtl('shijian6');}</a></li>
                <li><a <!--{if $_GET['dateline']=='31536000'}-->class="bgcolor_10"<!--{/if}--> href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=lastpost&filter=dateline&dateline=31536000&mobile=2" >{echo xtl('shijian7');}</a></li>
            </ul>
        </div>
    </div>

    <!--{hook/forumdisplay_filter_extra}-->
</div>

<div class="mod-guide weui-flex bm cl">
    <div class="mod-guide-thumb">

        <!--{if $_G['forum'][icon]}-->
        <!--{eval $_G['forum'][icon] =  get_forumimg($_G['forum']['icon']);}-->
        <img src="$_G['forum'][icon]" alt="$_G['forum']['name']" />
        <!--{else}-->
        <img src="{IMGDIR}/forum{if $forum[folder]}_new{/if}.gif" alt="$forum[name]" />
        <!--{/if}-->
    </div>
    <div class="mod-guide-main">
        <p class="title">$_G['forum']['name']</p>
        <p>
            <span>{echo xtl('jinri');}:{$_G[forum][todayposts]}</span>
            <span>{echo xtl('tiezi');}:{$_G[forum][posts]}</span>
            <span>{echo xtl('guanzhu');}:{$_G[forum][favtimes]}</span>
        </p>
    </div>
    <!--{if $_G[uid]}-->
        <!--{eval $guanstat = C::t('home_favorite')->fetch_by_id_idtype($_G['fid'], 'fid', $_G['uid']);}-->
        <!--{if $guanstat}-->
            <a class="mod-guide-btn weui-btn weui-btn_mini weui-btn_default dialog" href="home.php?mod=spacecp&ac=favorite&op=delete&type=forum&formhash={FORMHASH}&favid={$guanstat[favid]}&mobile=2&handlekey=fav_forum">{echo xtl('guanzhu1');}</a>
            <script> function succeedhandle_favoriteform_{$guanstat[favid]}(){ window.location.reload(); } </script>
        <!--{else}-->
        <a class="mod-guide-btn button2 dialog" href="home.php?mod=spacecp&ac=favorite&type=forum&id=$_G[fid]&formhash={FORMHASH}&mobile=2&handlekey=fav_forum">+ {echo xtl('guanzhu');}</a>
        <!--{/if}-->
    <!--{else}-->
        <a class="mod-guide-btn button2 dialog" href="home.php?mod=spacecp&ac=favorite&type=forum&id=$_G[fid]&formhash={FORMHASH}&mobile=2&handlekey=fav_forum">+ {echo xtl('guanzhu');}</a>
    <!--{/if}-->
</div>

<!--{eval $displaythreads = array();}-->
<!--{loop $_G['forum_threadlist'] $k $thread}-->
<!--{if $thread['displayorder']>0}-->
<!--{eval $displaythreads[] = $thread; unset($_G['forum_threadlist'][ $k ]);}-->
<!--{/if}-->
<!--{/loop}-->
<!--{if $displaythreads}-->
<div class="stick bm">
    <ul>
        <!--{loop $displaythreads $k $thread}-->
        <li>
            <i class="ico-laba">{echo xtl('zhiding1');}</i>
            <a class="txt" href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$thread[subject]</a>
        </li>
        <!--{/loop}-->
    </ul>
</div>
<!--{/if}-->



<!--{if !$subforumonly}-->
<div class="threadlist">
	<div class="news-list-wrapper tab-news-content">
        <!--{if $_G['forum_threadcount']}-->

            <!--{eval $threadlist = x_s2($_G['forum_threadlist']);}-->
            <!--{loop $threadlist $key $thread}-->
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
				<h2>{lang guide_nothreads}</h2>
			</a>
		</div>
			<!--{/if}-->
	</div>
</div>
$multipage
<!--{/if}-->
<!-- main threadlist end -->
<!--{hook/forumdisplay_bottom_mobile}-->
<div class="pullrefresh" style="display:none;"></div>

<div class="quick-publish"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]"><i class="iconfont icon-pencil"></i></a></div>
<!--{template common/footer}-->
