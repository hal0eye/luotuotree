<?php exit('xxxxx'); ?>
<div class="yd-classify-wrapper">
    <div class="classify-names">
        <!--{loop $catlist $key $cat}-->
        <a href="javascript:" onclick="return the_click(this, $key);" <!--{if $key==0}-->class="active"<!--{/if}-->>$cat[name]</a>
        <!--{/loop}-->
    </div>
    <div class="classify-item">

    <!--{loop $catlist $key $cat}-->
        <div class="t-recommend" id="thelist_$key" style="display:none">

            <!--{loop $cat[forums] $forumid}-->
            <!--{eval $forum=$forumlist[$forumid];}-->
            <!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
            <div class="item">
                <a href="{if $forum[redirect]} $forum[redirect]{else}$forumurl{/if}" class="t-bottom">
                    <span class="icon">
                        <!--{if $forum[icon]}-->
                            {echo strip_tags($forum[icon], '<img>');}
                        <!--{else}--><img src="{IMGDIR}/forum{if $forum[folder]}_new{/if}.gif" alt="$forum[name]" />
                        <!--{/if}-->
                    </span>
                    <div class="t-right">
                        <div class="mid">
                            <span class="name">{$forum[name]} <!--{if $forum[todayposts] > 0}--><span class="weui-badge">{$forum[todayposts]}</span><!--{/if}--></span>
                            <div class="text elps-line2"><!--{if $forum[description]}-->{echo strip_tags($forum[description]);}<!--{else}-->{echo xtl('zanwu');}<!--{/if}--></div>
                            <div class="other">
                                <!--{if empty($forum[redirect])}-->
                                <span><!--{echo dnumber($forum[threads])}-->{lang modcp_posts_thread}</span>
                                <span><!--{echo dnumber($forum[posts])}-->{lang posts}</span>
                                <!--{else}-->
                                {echo strip_tags($forum[description]);}
                                <!--{/if}-->
                            </div>
                        </div>
                    </div>
                </a>
                <!--{if empty($forum[redirect])}-->
                <a href="forum.php?mod=post&action=newthread&fid=$forum[fid]" class="btn _ajax_btn_follow">{lang send_threads}</a>
                <!--{/if}-->
            </div>


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
            <div class="item">
                <a href="{if $forum[redirect]} $forum[redirect]{else}$forumurl{/if}" class="t-bottom">
                    <span class="icon">
                        <!--{if $forum[icon]}-->
                            {echo strip_tags($forum[icon], '<img>');}
                        <!--{else}--><img src="{IMGDIR}/forum{if $forum[folder]}_new{/if}.gif" alt="$forum[name]" />
                        <!--{/if}-->
                    </span>
                    <div class="t-right">
                        <div class="mid">
                            <span class="name">{$forum[name]} <!--{if $forum[todayposts] > 0}--><span class="weui-badge">{$forum[todayposts]}</span><!--{/if}--></span>
                            <div class="text elps-line2"><!--{if $forum[description]}-->{echo strip_tags($forum[description]);}<!--{else}-->{echo xtl('zanwu');}<!--{/if}--></div>
                            <div class="other">
                                <!--{if empty($forum[redirect])}-->
                                <span><!--{echo dnumber($forum[threads])}-->{lang modcp_posts_thread}</span>
                                <span><!--{echo dnumber($forum[posts])}-->{lang posts}</span>
                                <!--{else}-->
                                {echo strip_tags($forum[description]);}
                                <!--{/if}-->
                            </div>
                        </div>
                    </div>
                </a>
                <!--{if empty($forum[redirect])}-->
                <a href="forum.php?mod=post&action=newthread&fid=$forum[fid]" class="btn _ajax_btn_follow">{lang send_threads}</a>
                <!--{/if}-->
            </div>
            <!--{/loop}-->


            <!--{/loop}-->

        </div>
    <!--{/loop}-->

    </div>
</div>
<script>
    function the_click(obj, id) {
        $('.classify-names a').removeClass('active');
        $(obj).addClass('active');
        $('.t-recommend').hide();
        $('#thelist_'+id).show();
    }
    $('.classify-names a:first-child').trigger('click');
</script>