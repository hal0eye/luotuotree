<?php exit('xxxxxx'); ?>
<!--{if $thread[subject] && $thread[attach][0]}-->
<!--{eval $attachcount = count($thread[attach]); }-->
<!--{if is_numeric($thread['lastpost'])}-->
<!--{eval $thread['lastpost'] = dgmdate($thread['lastpost'], 'u'); }-->
<!--{/if}-->

<div class="pubuliu">
    <div class="pubuliu_top">
        <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra" class="pic-warp pic-warp-photo"><img src="template/xigua_touch/xtatic/none.png" class="lazy" data-original="$thread[attach][0]"/></a>

        <!--{if $thread[sorthtml]}--><div class="subtag bgcolor_9 tag_topleft">{$thread[sorthtml]}</div><!--{/if}-->
        <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
        <div class="subtag tag_topright bgcolor_10">
            {echo xtl('zhiding');}
        </div>
        <!--{elseif $thread['digest'] > 0}-->
        <div class="subtag tag_topright bgcolor_10">
            {echo xtl('jinghua');}
        </div>
        <!--{elseif $thread['attachment'] == 2 && $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
        <!--{/if}-->

        <a href="forum.php?mod=forumdisplay&fid={$thread['fid']}&mobile=2" class="subtag tag_bottomleft">$_G['cache']['forums'][$thread['fid']]['name']</a>
        <!--{if $thread[typename]}--><a href="forum.php?mod=forumdisplay&fid=$thread[fid]&filter=typeid&typeid=$thread[typeid]" class="subtag bgcolor_8 tag_bottomright">$thread[typename]</a><!--{/if}-->
    </div>
    <div class="pubuliu_bottom">
        <p>$thread[subject]</p>
        <p class="small">$thread['lastpost']</p>

    </div>
</div>

<!--{/if}-->