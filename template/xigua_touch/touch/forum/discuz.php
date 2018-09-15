<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->

<!--{if $_G['cache']['plugin']['xigua_th']['default_index'] && $_REQUEST['forumlist'] != 1}-->
<!--{eval dheader("location: ".urldecode($_G['cache']['plugin']['xigua_th']['default_index']));exit; }-->
<!--{/if}-->

<!--{if $_G['setting']['mobile']['mobilehotthread'] && $_GET['forumlist'] != 1}-->
	<!--{eval dheader('Location:forum.php?mod=guide&view=hot');exit;}-->
<!--{/if}-->
<!--{template common/header}-->

<!--{hook/index_top_mobile}-->
<!-- main forumlist start -->
<!--{eval include_once libfile('function/forumlist');}-->
<!--{eval include_once libfile('function/cache');}-->

<!--{if $_G['cache']['plugin']['xigua_th']['discuz1']}-->
<!--{template forum/discuz1}-->
<!--{else}-->
<div class="wp forumlist" id="wp">
	<!--{loop $catlist $key $cat}-->

	<ul class="nav_forum">
		<li class="">
			<div class="weui-flex js_category">
				<p class="weui-flex__item">$cat[name]</p>
                <span class="morefilter animated"><i class="iconfont icon-xiangxiajiantou"></i></span>
			</div>
			<div class="page__category js_categoryInner" data-height="220" style="">
				<div class="weui-cells page__category-content">
					<!--{loop $cat[forums] $forumid}-->
					<!--{eval $forum=$forumlist[$forumid];}-->
					<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->

                    <a class="weui-cell weui-cell_access" href="{if $forum[redirect]} $forum[redirect]{else}$forumurl{/if}">
                        <div class="weui-cell__hd forumlogo">
                            <!--{if $forum[icon]}-->
                            {echo strip_tags($forum[icon], '<img>');}
                            <!--{else}--><img src="{IMGDIR}/forum{if $forum[folder]}_new{/if}.gif" alt="$forum[name]" />
                            <!--{/if}-->
                            <!--{if $forum[todayposts] > 0}--><span class="weui-badge">{$forum[todayposts]}</span><!--{/if}-->
                        </div>
                        <div class="weui-cell__bd">
                            <p>{$forum[name]}</p>
                            <p class="forumdesc"><!--{if $forum[description]}-->{echo strip_tags($forum[description]);}<!--{else}-->{echo xtl('zanwu');}<!--{/if}--></p>
                        </div>
                        <div class="weui-cell__ft"><!--{if empty($forum[redirect])}--><span><!--{echo dnumber($forum[threads])}--></span>/<span><!--{echo dnumber($forum[posts])}--></span><!--{/if}--></div>
                    </a>
                    <!--{eval $subforums = C::t('forum_forum')->fetch_all_subforum_by_fup(intval($forum['fid']));}-->
                    <!--{eval
                    if($subforums){
                    $subfids = array();
                    if($subforums):
                        foreach($subforums as $subforum):
                            $subfids[] = $subforum[fid];
                        endforeach;
                    endif;
                    $favforumlist_fields = C::t('forum_forumfield')->fetch_all($subfids);
                    foreach($subforums as $id => $forum) :
                        if($favforumlist_fields[$forum['fid']]['fid']) :
                            $subforums[$id] = array_merge($forum, $favforumlist_fields[$forum['fid']]);
                        endif;
                        if($subforums[$id]['icon']) :
                            $subforums[$id]['icon'] = get_forumimg($subforums[$id]['icon']);
                        endif;
                    endforeach;
                    }-->
                    <!--{eval
                        }
                    }-->
                    <!--{loop $subforums $forum}-->
                    <!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
                    <a class="weui-cell weui-cell_access" href="{if $forum[redirect]} $forum[redirect]{else}$forumurl{/if}">
                        <div class="weui-cell__hd forumlogo">
                            <!--{if $forum[icon]}-->
                            <img src="$forum[icon]">
                            <!--{else}--><img src="{IMGDIR}/forum{if $forum[folder]}_new{/if}.gif" alt="$forum[name]" />
                            <!--{/if}-->
                            <!--{if $forum[todayposts] > 0}--><span class="weui-badge">{$forum[todayposts]}</span><!--{/if}-->
                        </div>
                        <div class="weui-cell__bd">
                            <p>{$forum[name]}</p>
                            <p class="forumdesc"><!--{if $forum[description]}-->{echo strip_tags($forum[description]);}<!--{else}-->{echo xtl('zanwu');}<!--{/if}--></p>
                        </div>
                        <div class="weui-cell__ft"><!--{if empty($forum[redirect])}--><span><!--{echo dnumber($forum[threads])}--></span>/<span><!--{echo dnumber($forum[posts])}--></span><!--{/if}--></div>
                    </a>
                    <!--{/loop}-->

					<!--{/loop}-->
				</div>
			</div>
		</li>
	</ul>
	<!--{/loop}-->
</div>
<!--{if !$_G[setting][mobile][mobileforumview]}-->
<script>setTimeout(function () {
        $('.nav_forum>li').addClass('js_show');
        $('.morefilter').addClass('expanded');
    }, 300);</script>
<!--{/if}-->

<!--{/if}-->
<!-- main forumlist end -->
<!--{hook/index_middle_mobile}-->

<!--{template common/footer}-->
