<?php exit('xxxx');?>
<!--{if $thread[subject]}-->
<!--{if $_G['cache']['plugin']['xigua_th']['mainlist']==2}-->
<!--{subtemplate common/thread_list_node2}-->
<!--{elseif $_G['forum']['picstyle']}-->
<!--{subtemplate common/thread_list_node3}-->
<!--{else}-->

<!--{eval $attachcount = count($thread[attach]); }-->

<div class="mod-post-list-item">
    <div class="mod-post-list-item-header">
        <a href="home.php?mod=space&uid={$thread[authorid]}&do=profile" class="mod-hot-post-header">
            <img src="template/xigua_touch/xtatic/none.png" data-original="{avatar($thread[authorid], 'middle', true)}" class="usr-face lazy">
            <span class="usr-name">$thread[author]</span>
        </a>

        <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
        <div class="mod-lv is-star">
            <span>{echo xtl('zhiding');}</span>
        </div>
        <!--{elseif $thread['digest'] > 0}-->
        <div class="mod-lv is-star">
            <span>{echo xtl('jinghua');}</span>
        </div>
        <!--{elseif $thread['attachment'] == 2 && $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
        <!--{/if}-->

        <!--{if $thread[iconid]}-->
        <div class="mod-lv user-level bgcolor_{echo usergroup_iconid($thread[groupid])}">
            <span class="mod-lv-icon color_{echo usergroup_iconid($thread[groupid])}"><i class="iconfont icon-<!--{if $thread[gender]==1}-->nan<!--{elseif $thread[gender]==2}-->nv<!--{else}-->biaoxing<!--{/if}-->"></i></span>
            <span>{$_G['cache']['usergroups'][$thread['groupid']]['grouptitle']}</span>
        </div>
        <!--{/if}-->

        <!--{if $thread[sorthtml]}-->
        <span class="mod-cricle-headertypes essence">
            {$thread[sorthtml]}
        </span>
        <!--{elseif $thread[typename]}-->
        <a href="forum.php?mod=forumdisplay&fid=$thread[fid]&filter=typeid&typeid=$thread[typeid]" class="circle-name hot-post-circle">$thread[typename]</a>
        <!--{else}-->
            <!--{if !$_G[fid]}-->
        <a href="forum.php?mod=forumdisplay&fid={$thread['fid']}&mobile=2" class="circle-name hot-post-circle">$_G['cache']['forums'][$thread['fid']]['name']</a>
            <!--{/if}-->
        <!--{/if}-->

    </div>
    <div class="mod-post-list-item-content">
        <div class="text">
            <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra" $thread[highlight]>
                <!--{if $thread[folder] == 'lock'}-->
                <img src="{IMGDIR}/folder_lock.gif" />
                <!--{elseif $thread['special'] == 1}-->
                <img src="{IMGDIR}/pollsmall.gif" alt="{lang poll}" />
                <!--{elseif $thread['special'] == 2}-->
                <img src="{IMGDIR}/tradesmall.gif" alt="{lang trade}" />
                <!--{elseif $thread['special'] == 3}-->
                <img src="{IMGDIR}/rewardsmall.gif" alt="{lang reward}" />
                <!--{elseif $thread['special'] == 4}-->
                <img src="{IMGDIR}/activitysmall.gif" alt="{lang activity}" />
                <!--{elseif $thread['special'] == 5}-->
                <img src="{IMGDIR}/debatesmall.gif" alt="{lang debate}" />
                <!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                <!--{else}-->
                <!--{/if}-->
                $thread[subject]</a>
            <!--{eval
                global $_G;
                if($_G['cache']['plugin']['xigua_media'] && 0):
                $posttableid = table_forum_post::get_tablename('tid:' . $thread['tid']);
                $pid = DB::result_first( 'SELECT pid FROM %t WHERE tid=%d AND first=1 LIMIT 1', array($posttableid, $thread['tid']));
                $message = DB::result_first( 'SELECT message FROM %t WHERE pid=%d LIMIT 1', array($posttableid, $pid));
                if(strpos($message, '[/media]') !== FALSE || strpos($message, '[/flash]') !== FALSE) :
                    $height = $_G['cache']['plugin']['xigua_media']['height'];
                    preg_match("/\[(media|flash)\=?([\w,]*)\]\s*(.*?)\s*\[\/(media|flash)\]/ies", $message, $match);
                    $attr = $match[2];
                    $url = $match[3];
                    $link = $_G['siteurl']. 'plugin.php?id='.urlencode('xigua_media:fetchid').'&param='. urlencode(base64_encode(http_build_query(array(
                            'attr' => $attr,
                            'url'  => $url,
                            'formhash' => FORMHASH
                        ))));
                    echo '<iframe style="width:100%;height:'.$height.'px" frameborder="0" scrolling="no" allowfullscreen="true" src="'.$link.'"></iframe>';
                    $thread[attach] = array();
                endif;
                endif;
                }-->
        </div>
        <!--{if $thread[attach]}-->
        <div <!--{if $attachcount==1&&$thread[attach_size][0]>300}-->class="photo is-one"<!--{elseif $attachcount==2}-->class="photo is-two"<!--{elseif $attachcount==1&&$thread[attach_size][0]<=300}-->class="photo is-three ml0 mr0"<!--{else}-->class="photo is-three"<!--{/if}-->>
            <!--{loop $thread[attach] $att}-->
            <!--{if $att}-->
            <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra" class="pic-warp pic-warp-photo"><img src="template/xigua_touch/xtatic/none.png" class="lazy" data-original="$att"/></a>
            <!--{/if}-->
            <!--{/loop}-->
        </div>
        <!--{/if}-->
    </div>
    <div class="mod-post-list-item-footer">
        <div class="footer-text">
            <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
                <span>
                    <em class="mr5">{$thread[views]} {echo xtl('liulan');}</em>
                    <em>$thread['lastpost']</em>
                </span>
            </a>
        </div>
        <div class="footer-opt">
            <span class="opt-item item-comment"><a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><i class="iconfont icon-comiisluntan"></i> {$thread[replies]}</a></span>
            <a <!--{if $_G[uid]}-->href="forum.php?mod=misc&action=recommend&handlekey=recommend_add&do=add&tid={$thread[tid]}&hash={FORMHASH}"<!--{else}-->href="member.php?mod=logging&action=login"<!--{/if}--> class="add_praise"><span class="opt-item item-praise"><i class="iconfont icon-good"></i> <i class="praise_num">{$thread[recommend_add]}</i></span></a>
        </div>
    </div>
    <!--{hook/forumdisplay_thread_mobile $key}-->
</div>
<!--{/if}-->
<!--{/if}-->