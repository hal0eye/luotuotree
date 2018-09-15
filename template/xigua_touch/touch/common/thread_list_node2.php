<?php exit('xxxxxx'); ?>
<!--{if $thread[subject]}-->
<!--{eval $attachcount = count($thread[attach]); }-->
<!--{if is_numeric($thread['lastpost'])}-->
<!--{eval $thread['lastpost'] = dgmdate($thread['lastpost'], 'u'); }-->
<!--{/if}-->

<!--{if $attachcount>=3}-->
<section class="m_photoset m_article cl">

        <div class="m_photoset_title">
            <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$thread[subject]</a>
        </div>
        <div class="m_photoset_pic">
            <div class="m_photoset_pic_wrap cl">
                <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
                <!--{loop $thread[attach] $att}-->
                <!--{if $att}-->
                <img src="template/xigua_touch/xtatic/none.png" class="lazy" data-original="$att"/>
                <!--{/if}-->
                <!--{/loop}-->
                </a>
            </div>
        </div>
        <div class="m_photoset_info">
            <div class="m_article_desc cl">
                <div class="m_article_desc_l">
                    <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                        <span class="m_article_channel">{echo xtl('zhiding');}</span>
                    <!--{elseif $thread['digest'] > 0}-->
                        <span class="m_article_channel">{echo xtl('jinghua');}</span>
                    <!--{/if}-->

                    <!--{if $thread[sorthtml]}-->
                    <span class="m_article_channel">{$thread[sorthtml]}</span>
                    <!--{elseif $thread[typename]}-->
                    <a href="forum.php?mod=forumdisplay&fid=$thread[fid]&filter=typeid&typeid=$thread[typeid]" class="m_article_channel">$thread[typename]</a>
                    <!--{else}-->
                    <!--{if !$_G[fid]}-->
                    <a href="forum.php?mod=forumdisplay&fid={$thread['fid']}&mobile=2" class="m_article_channel">$_G['cache']['forums'][$thread['fid']]['name']</a>
                    <!--{/if}-->
                    <!--{/if}-->

                    <span class="m_article_time">{$thread['lastpost']}</span>
                </div>
                <div class="m_article_desc_r">
                    <div class="left_hands_desc">
                        <i class="iconfont icon-browse"></i> {$thread[views]} {echo xtl('liulan');}
                    </div>
                </div>
            </div>
        </div>
</section>
<!--{else}-->
<section class="m_article cl">
        <!--{if $thread[attach][0]}-->
        <div class="m_article_img"><a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
            <img src="template/xigua_touch/xtatic/none.png" class="lazy" data-original="$thread[attach][0]"/>
            </a>
        </div>
        <!--{/if}-->
        <div class="m_article_info">
            <div class="m_article_title">
                <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><span>$thread[subject]</span></a>
            </div>
            <div class="m_article_desc cl">
                <div class="m_article_desc_l">

                    <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                    <span class="m_article_channel">{echo xtl('zhiding');}</span>
                    <!--{elseif $thread['digest'] > 0}-->
                    <span class="m_article_channel">{echo xtl('jinghua');}</span>
                    <!--{/if}-->


                    <!--{if $thread[sorthtml]}-->
                    <span class="m_article_channel">{$thread[sorthtml]}</span>
                    <!--{elseif $thread[typename]}-->
                    <a href="forum.php?mod=forumdisplay&fid=$thread[fid]&filter=typeid&typeid=$thread[typeid]" class="m_article_channel">$thread[typename]</a>
                    <!--{else}-->
                    <!--{if !$_G[fid]}-->
                    <a href="forum.php?mod=forumdisplay&fid={$thread['fid']}&mobile=2" class="m_article_channel">$_G['cache']['forums'][$thread['fid']]['name']</a>
                    <!--{/if}-->
                    <!--{/if}-->

                    <span class="m_article_time">{$thread['lastpost']}</span>
                </div>
                <div class="m_article_desc_r">
                    <div class="left_hands_desc">
                        <i class="iconfont icon-browse"></i> {$thread[views]} {echo xtl('liulan');}
                    </div>
                </div>
            </div>
        </div>
</section>
<!--{/if}-->
<!--{/if}-->