<?php exit('xxxx');?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<!--{eval $postpage = 1;}-->
<div class="wp">
    <div class="selectforum">
        <div class="weui-grids">
            <!--{eval $showinpost = unserialize($_G['cache']['plugin']['xigua_th']['showinpost']);}-->
            {eval

            include_once libfile('function/forumlist');
                $forum_fields = DB::fetch_all("SELECT fid,icon FROM %t WHERE fid IN(%n)", array('forum_forumfield', array_keys($_G['cache'][forums])), 'fid');
                foreach($forum_fields as $k => $v) :
                    if($v['icon']):
                        $ic = get_forumimg($v['icon']);
                        if(!in_array(strtolower(substr($ic, 0, 6)), array('http:/', 'https:', 'ftp://'))):
                            $ic = $_G['siteurl'] . $ic;
                        endif;
                    endif;
                    $icons[ $k ] = $ic;
                endforeach;

            $oforumlist = forumselect(false, 1);
            foreach ($oforumlist as $index => $item) :
            $forumlist[$index] = $item['name'];
            if($item['sub']):
            foreach ($item['sub'] as $iiii => $vvvv) :
            $forumlist[$iiii] = $vvvv['name'];
            endforeach;
            endif;
            endforeach;

            }

            <!--{loop $_G['cache'][forums] $forum}-->
            <!--{if $forum[type]!='group' && $forum['status']=='1'&& $forumlist[$forum['fid']] && !in_array($forum['fid'], $showinpost)}-->
            <a href="forum.php?mod=post&action=newthread&fid=$forum['fid']" class="weui-grid">
                <div class="weui-grid__icon">
                    <!--{if $icons[$forum[fid]]}-->
                    <img src="$icons[$forum[fid]]" alt="$forum[name]" />
                    <!--{eval unset($icons[$forum[fid]]);}-->
                    <!--{else}-->
                    <img src="{IMGDIR}/forum{if $forum[folder]}_new{/if}.gif" alt="$forum[name]" />
                    <!--{/if}-->
                </div>
                <p class="weui-grid__label">$forum['name']</p>
            </a>
            <!--{/if}-->
            <!--{/loop}-->
        </div>
    </div>
</div><!--{template common/footer}-->