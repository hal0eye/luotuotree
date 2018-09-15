<?php exit('xxxx');?>
<div class="m-15">
    <div class="weui-cells__title">$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</div>
    <div class="weui-cells">

        <!--{loop $threadsortshow['optionlist'] $option}-->
        <!--{if $option['type'] != 'info'}-->
        <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>$option[title]</p>
                </div>

            <div class="weui-cell__ft">
                <!--{if $option['value']}-->
                <!--{if $option['type'] == 'image' && strpos($option[value], '=')===false}--><img src='$option[value]' /><!--{else}-->$option[value]<!--{/if}--> $option[unit]
                <!--{else}-->
                <span class="xg1">--</span>
                <!--{/if}-->
            </div>
        </div>
        <!--{/if}-->
        <!--{/loop}-->
    </div>
</div>