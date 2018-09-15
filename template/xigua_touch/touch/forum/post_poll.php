<?php exit('xxxxx'); ?>
<div class="sorttable cl" style="background:transparent;margin-bottom:12px">
    <input type="hidden" name="polls" value="yes"/>
    <input type="hidden" name="fid" value="$_G[fid]"/>

    <!--{if $_GET[action] == 'newthread'}-->
    <input type="hidden" name="tpolloption" value="2"/>
    <div class="weui-cells__title">{lang post_poll_options}:{lang post_poll_comment}</div>
    <div class="weui-cells weui-cells_form mt0">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea name="polloptions" class="weui-textarea" rows="3"/></textarea>
            </div>
        </div>
    </div>

    <div class="weui-cells__title">{lang post_poll_comment_s}</div>


    <!--{else}-->
    <div class="weui-cells">
        <!--{loop $poll['polloption'] $key $option}-->

        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input type="hidden" name="polloptionid[{$poll[polloptionid][$key]}]"
                       value="$poll[polloptionid][$key]"/>
                <input type="text" name="polloption[{$poll[polloptionid][$key]}]" class="weui-input"
                       autocomplete="off" value="$option" {if !$_G['group']['alloweditpoll']}
                readonly="readonly"{/if} />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input type="text" name="displayorder[{$poll[polloptionid][$key]}]" class="weui-input"
                       autocomplete="off" value="$poll[displayorder][$key]"/>
            </div>
        </div>
        <!--{/loop}-->

    </div>
    <!--{/if}-->

    <div class="weui-cells weui-cells_form">

        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">{lang post_poll_allowmultiple}</label>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="maxchoices" id="maxchoices" class="weui-input"
                       value="{if $_GET[action] == 'edit' && $poll[maxchoices]}$poll[maxchoices]{else}1{/if}"/>
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn">{lang post_option}</button>
            </div>
        </div>


        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">{lang post_poll_expiration}</label>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="expiration" id="polldatas" class="weui-input"
                       value="{if $_GET[action] == 'edit'}{if !$poll[expiration]}0{elseif $poll[expiration] < 0}{lang poll_close}{elseif $poll[expiration] < TIMESTAMP}{lang poll_finish}{else}{echo (round(($poll[expiration] - TIMESTAMP) / 86400))}{/if}{/if}"/>
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn">{lang days}</button>
            </div>
        </div>
    </div>

    <div class="weui-cells weui-cells_form">
        <label for="weuiAgree" class="weui-agree">
            <input type="checkbox" name="visibilitypoll" id="visibilitypoll" class="weui-agree__checkbox" value="1" {if
                   $_GET[action]=='edit' && !$poll[visible]} checked{/if} />
            <span class="weui-agree__text">
                {lang poll_after_result}
            </span>
        </label>
        <label for="weuiAgree" class="weui-agree">
            <input type="checkbox" name="overt" id="overt" class="weui-agree__checkbox" value="1" {if $_GET[action]==
            'edit' && $poll[overt]} checked{/if} />
            <span class="weui-agree__text">
                {lang post_poll_overt}
            </span>
        </label>
    </div>
</div>
