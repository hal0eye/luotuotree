<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<form id="searchform" class="searchform" method="post" autocomplete="off" action="search.php?mod=forum&mobile=2">
			<input type="hidden" name="formhash" value="{FORMHASH}" />

			<!--{subtemplate search/pubsearch}-->

			<!--{eval $policymsgs = $p = '';}-->
			<!--{loop $_G['setting']['creditspolicy']['search'] $id $policy}-->
			<!--{block policymsg}--><!--{if $_G['setting']['extcredits'][$id][img]}-->$_G['setting']['extcredits'][$id][img] <!--{/if}-->$_G['setting']['extcredits'][$id][title] $policy $_G['setting']['extcredits'][$id][unit]<!--{/block}-->
			<!--{eval $policymsgs .= $p.$policymsg;$p = ', ';}-->
			<!--{/loop}-->
			<!--{if $policymsgs}--><div class="weui-cells__title">{lang search_credit_msg}</div><!--{/if}-->
</form>

<!--{if $_G['setting']['srchhotkeywords']}-->
<div class="hot_search mbm xg_taglist cl">
	<!--{loop $_G['setting']['srchhotkeywords'] $val}-->
	<!--{if $val=trim($val)}-->
	<!--{eval $valenc=rawurlencode($val);}-->
    <!--{eval $mt = mt_rand(1,10);}-->
	<!--{block srchhotkeywords[]}-->
	<!--{if !empty($searchparams[url])}-->
	<a class="bcolor_{$mt}"  href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}">$val</a>
	<!--{else}-->
	<a class="bcolor_{$mt}" href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch">$val</a>
	<!--{/if}-->
	<!--{/block}-->
	<!--{/if}-->
	<!--{/loop}-->
	<!--{echo implode('', $srchhotkeywords);}-->
</div>
<!--{/if}-->

<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{subtemplate search/thread_list}-->
<!--{/if}-->
<!--{template common/footer}-->
