<?php exit('xxxxx');?>
<div class="sorttable cl" style="background:transparent;margin-bottom:12px">
	<!--{if $_GET[action] == 'newthread'}-->

    <div class="weui-cells__title">{lang reward_price}</div>
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input type="text" name="rewardprice" id="rewardprice" class="weui-input" value="{$_G['group']['minrewardprice']}" tabindex="1" />
            </div>
        </div>
    </div>
    <label class="weui-agree">
        <span class="weui-agree__text">
			{lang reward_price_min} {$_G['group']['minrewardprice']} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}
            <!--{if $_G['group']['maxrewardprice'] > 0}-->, {lang reward_price_max} {$_G['group']['maxrewardprice']} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}<!--{/if}-->
			, {lang you_have} <!--{echo getuserprofile('extcredits'.$_G['setting']['creditstransextra'][2]);}--> {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
        </span>
    </label>



	<!--{elseif $_GET[action] == 'edit'}-->
		<!--{if $isorigauthor}-->
			<!--{if $thread['price'] > 0}-->

                <div class="weui-cells__title">{lang reward_price}</div>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input type="text" name="rewardprice" id="rewardprice" class="weui-input" onkeyup="getrealprice(this.value)" value="$rewardprice" tabindex="1" />
            </div>
            <div class="weui-cell__ft">
                {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
                , {lang reward_tax_add} <strong id="realprice">0</strong> {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
            </div>
        </div>
    </div>



    <label class="weui-agree">
        <span class="weui-agree__text">{lang reward_price_min} {$_G['group']['minrewardprice']} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}
            <!--{if $_G['group']['maxrewardprice'] > 0}-->, {lang reward_price_max} {$_G['group']['maxrewardprice']} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}<!--{/if}-->
					, {lang you_have} <!--{echo getuserprofile('extcredits'.$_G['setting']['creditstransextra'][2]);}--> {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
        </span>
    </label>

			<!--{else}-->
                <div class="weui-cells__title">{lang post_reward_resolved}</div>
				<input type="hidden" name="rewardprice" value="$rewardprice" tabindex="1" />
			<!--{/if}-->
		<!--{else}-->
			<!--{if $thread['price'] > 0}-->
    <div class="weui-cells__title">{lang reward_price}: $rewardprice {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}</div>

			<!--{else}-->
    <div class="weui-cells__title">{lang post_reward_resolved}</div>
			<!--{/if}-->
		<!--{/if}-->
	<!--{/if}-->
	<!--{hook/post_reward_extra}-->
<script>
    function getrealprice(price){
        if(!price.search(/^\d+$/) ) {
            n = Math.ceil(parseInt(price) + price * $_G['setting']['creditstax']);
            if(price > 32767) {
                $('#realprice')[0].innerHTML = '<b>{lang reward_price_overflow}</b>';
            }<!--{if $_GET[action] == 'edit'}-->	else if(price < $rewardprice) {
                $('#realprice')[0].innerHTML = '<b>{lang reward_cant_fall}</b>';
            }<!--{/if}--> else if(price < $_G['group']['minrewardprice'] || ($_G['group']['maxrewardprice'] > 0 && price > $_G['group']['maxrewardprice'])) {
                $('#realprice')[0].innerHTML = '<b>{lang reward_price_bound}</b>';
            } else {
                $('#realprice')[0].innerHTML = n;
            }
        }else{
            $('#realprice')[0].innerHTML = '<b>{lang input_invalid}</b>';
        }
    }
</script>
</div>