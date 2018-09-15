<?php exit('xxxxx'); ?>
{eval
function tpl_hide_credits_hidden($creditsrequire) {
global $_G;
}
<!--{block return}--><div class="locked"><!--{if $_G[uid]}-->{$_G[username]}<!--{else}-->{lang guest}<!--{/if}-->{lang post_hide_credits_hidden}</div><!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function tpl_hide_credits($creditsrequire, $message) {
}
<!--{block return}--><div class="locked">{lang post_hide_credits}</div>
$message<br /><br />
<!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function tpl_codedisp($code) {
}
<!--{block return}--><div class="blockcode"><div><ol><li>$code</ol></div></div><!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function tpl_quote() {
}
<!--{block return}--><div class="grey quote"><blockquote>{lang e_quote}: \\1</blockquote></div><!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function tpl_free() {
}
<!--{block return}--><div class="grey quote"><blockquote>\\1</blockquote></div><!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function tpl_hide_reply() {
global $_G;
}
<!--{block return}--><div class="showhide"><h4>{lang post_hide}</h4>\\1</div>
<!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function tpl_hide_reply_hidden() {
global $_G;
}
<!--{block return}--><div class="locked"><!--{if $_G[uid]}-->{$_G[username]}<!--{else}-->{lang guest}<!--{/if}-->{lang post_hide_reply_hidden}</div><!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function attachlist($attach) {
global $_G;
$attach['refcheck'] = (!$attach['remote'] && $_G['setting']['attachrefcheck']) || ($attach['remote'] && ($_G['setting']['ftp']['hideurl'] || ($attach['isimage'] && $_G['setting']['attachimgpost'] && strtolower(substr($_G['setting']['ftp']['attachurl'], 0, 3)) == 'ftp')));
$aidencode = packaids($attach);
$is_archive = $_G['forum_thread']['is_archived'] ? "&fid=".$_G['fid']."&archiveid=".$_G[forum_thread][archiveid] : '';
}
<!--{block return}-->
<!--{if !$attach['price'] || $attach['payed']}-->
<li class="weui-cell" style="padding: 0">
    <!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}--><div class="weui-cell__hd">$attach[attachicon]</div><!--{/if}-->
    <div class="weui-cell__bd">
        <p>
            <!--{if !$attach['price'] || $attach['payed']}-->
            <a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode" id="aid$attach[aid]" target="_blank">$attach[filename]</a><br>
            <!--{else}-->
            <a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]">$attach[filename]</a><br>
            <!--{/if}-->
            <span class="xg1">($attach[dateline] {lang upload})</span>
        </p>
    </div>
    <div class="weui-cell__ft">
        <p class="xg1">$attach[attachsize]<!--{if $attach['readperm']}-->, {lang readperm}: <strong>$attach[readperm]</strong><!--{/if}-->, {lang downloads}: $attach[downloads]<!--{if !$attach['attachimg'] && $_G['getattachcredits']}-->, {lang attachcredits}: $_G[getattachcredits]<!--{/if}--></p>
        <!--{if $attach['description']}--><p class="xg2">{$attach[description]}</p><!--{/if}-->
        <a href="forum.php?mod=misc&action=viewattachpayments&aid=$attach[aid]" onclick="showWindow('attachpay', this.href)" target="_blank" class="button">{lang pay_view}</a>
    </div>
</li>

<!--{/if}-->

<!--{if $attach['price']}-->
<!--{if !$attach['payed']}-->

    <li class="weui-cell" style="padding: 0">
        <div class="weui-cell__bd">
            <p>
                <a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]">$attach[filename]</a><br>
                {lang price}: $attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}
            </p>
        </div>
        <div class="weui-cell__ft">
            <a href="forum.php?mod=misc&action=viewattachpayments&aid=$attach[aid]" onclick="showWindow('attachpay', this.href)" target="_blank" class="button">{lang pay_view}</a>
            <a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]" onclick="showWindow('attachpay', this.href)" target="_blank" class="button">{lang attachment_buy}</a>
        </div>
    </li>
<!--{/if}-->
<!--{/if}-->

<!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function imagelist($attach) {
global $_G, $post;
$width = '999';
$height = '9999';
$fixtype = 'fixnone';
$attach['refcheck'] = (!$attach['remote'] && $_G['setting']['attachrefcheck']) || ($attach['remote'] && ($_G['setting']['ftp']['hideurl'] || ($attach['isimage'] && $_G['setting']['attachimgpost'] && strtolower(substr($_G['setting']['ftp']['attachurl'], 0, 3)) == 'ftp')));
$mobilethumburl = $attach['attachimg'] && $_G['setting']['showimages'] && (!$attach['price'] || $attach['payed']) && ($_G['group']['allowgetimage'] || $_G['uid'] == $attach['uid']) ? $attach[url].$attach[attachment] : '' ;
$aidencode = packaids($attach);
$is_archive = $_G['forum_thread']['is_archived'] ? "&fid=".$_G['fid']."&archiveid=".$_G[forum_thread][archiveid] : '';
}
<!--{block return}-->
	<!--{if $attach['attachimg'] && $_G['setting']['showimages'] && ($_G['group']['allowgetimage'] || $_G['uid'] == $attach['uid']) && (!$attach['price'] || $attach['payed'])}-->
			<!--{if !$attach['price'] || $attach['payed']}-->
				<!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
				<li><div class="showpic"><div onclick="window.location.href='forum.php?mod=viewthread&tid=$attach[tid]&aid=$attach[aid]&from=album&page=$_G[page]'">
							<img id="aimg_$attach[aid]" src="<!--{if $GLOBALS[lazynone]}-->template/xigua_touch/xtatic/none.png<!--{else}-->$mobilethumburl<!--{/if}-->" class="lazy" data-original="$mobilethumburl" alt="$attach[imgalt]" title="$attach[imgalt]" />
						</div></div></li>
<!--{eval $GLOBALS[lazynone] = 1;}-->
				<!--{/if}-->
			<!--{/if}-->
	<!--{/if}-->
<!--{/block}-->
<!--{eval return $return;}-->
{eval
}

function attachinpost($attach) {
global $_G;
$attach['refcheck'] = (!$attach['remote'] && $_G['setting']['attachrefcheck']) || ($attach['remote'] && ($_G['setting']['ftp']['hideurl'] || ($attach['isimage'] && $_G['setting']['attachimgpost'] && strtolower(substr($_G['setting']['ftp']['attachurl'], 0, 3)) == 'ftp')));
$mobilethumburl = $attach['attachimg'] && $_G['setting']['showimages'] && (!$attach['price'] || $attach['payed']) && ($_G['group']['allowgetimage'] || $_G['uid'] == $attach['uid']) ? $attach[url].$attach[attachment] : '' ;
$aidencode = packaids($attach);
$is_archive = $_G['forum_thread']['is_archived'] ? '&fid='.$_G['fid'].'&archiveid='.$_G[forum_thread][archiveid] : '';
}
<!--{block return}-->
	<!--{if $attach['attachimg'] && $_G['setting']['showimages'] && (!$attach['price'] || $attach['payed']) && ($_G['group']['allowgetimage'] || $_G['uid'] == $attach['uid'])}-->
		<!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
		<div class="showpic"><div onclick="window.location.href='forum.php?mod=viewthread&tid=$attach[tid]&aid=$attach[aid]&from=album&page=$_G[page]'"><img id="aimg_$attach[aid]" src="<!--{if $GLOBALS[lazynone]}-->template/xigua_touch/xtatic/none.png<!--{else}-->$mobilethumburl<!--{/if}-->" class="lazy" data-original="$mobilethumburl" alt="$attach[imgalt]" title="$attach[imgalt]" /></div></div>
<!--{eval $GLOBALS[lazynone] = 1;}-->
		<!--{/if}-->
	<!--{else}-->
    <!--{if !$attach['price'] || $attach['payed']}-->
    <div class="files bo_b cl">
      <a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode">
			<!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
			$attach[attachicon]
			<!--{/if}-->
      <h4>$attach[filename]<span class="cg">($attach[attachsize])</span></h4>
      <p class="cg">{lang downloads}: $attach[downloads]</p>
      </a>
    </div>
    <!--{/if}-->
	<!--{/if}-->
<!--{/block}-->
<!--{eval return $return;}-->
<!--{eval
}

}-->
