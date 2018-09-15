<?php exit('xxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{eval $noclick = 1;}-->

<!--{if $op == 'find'}-->
<!--{eval $etx = lang('home/template', 'people_might_know');}-->
<!--{elseif $op == 'request'}-->
<!--{eval $etx = lang('home/template', 'friend_request');}-->
<!--{elseif $op == 'group'}-->
<!--{eval $etx = lang('home/template', 'set_friend_group');}-->
<!--{elseif $op=='changegroup'}-->
<!--{eval $etx = lang('home/template', 'set_friend_group');}-->
<!--{elseif $op=='add2'}-->
<!--{eval $etx = lang('home/template', 'approval_the_request');}-->
<!--{elseif $op =='ignore'}-->
<!--{eval $etx = lang('home/template', 'lgnore_friend');}-->
<!--{elseif $op=='add'}-->
<!--{eval $etx = lang('home/template', 'add_friend');}-->
<!--{/if}-->
<!--{eval $navtitle= $etx;}-->
<!--{template common/header}-->

<ul id="thread_types" class="ttp  cl">

    <!--{if empty($_G['setting']['sessionclose'])}-->
    <ul class="tab4">
        <li class="{if $a_actives[me]}xw1 a{/if}"><a href="home.php?mod=space&do=friend">{echo xtl('friendall')}</a></li>
        <li class="{if $a_actives[onlinefriend]}xw1 a{/if}"><a href="home.php?mod=space&do=friend&view=online&type=friend">{echo xtl('friendol')}</a></li>
        <li class="{if $a_actives[blacklist]}xw1 a{/if}"><a href="home.php?mod=space&do=friend&view=blacklist">{echo xtl('friendbl')}</a></li>
        <li class="{if $actives[request]}xw1 a{/if}"><a href="home.php?mod=spacecp&ac=friend&op=request">{lang friend_request}</a></li>
    </ul>
    <!--{else}-->
    <ul class="tab3">
        <li class="{if $a_actives[me]}xw1 a{/if}"><a  style="width:33%" href="home.php?mod=space&do=friend">{echo xtl('friendall')}</a></li>
        <li class="{if $a_actives[blacklist]}xw1 a{/if}"><a style="width:33%" href="home.php?mod=space&do=friend&view=blacklist">{echo xtl('friendbl')}</a></li>
        <li class="{if $actives[request]}xw1 a{/if}"><a style="width:33%" href="home.php?mod=spacecp&ac=friend&op=request">{lang friend_request}</a></li>
    </ul>
    <!--{/if}-->
</ul>

		<!--{if $op =='ignore'}-->

            <div class="">
			<div class="weui-cells__title">{lang determine_lgnore_friend}</div>
            <form method="post" autocomplete="off" id="friendform_{$uid}" name="friendform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=ignore&uid=$uid&confirm=1" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="friendsubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="from" value="$_GET[from]" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				
				<div class="weui-btn-area mbw">
					<button type="submit" name="friendsubmit_btn" class="btn_pn weui-btn weui-btn_primary" value="true">{lang determine}</button>
				</div>
			</form>
            </div>
			<script type="text/javascript">
				function succeedhandle_{$_GET[handlekey]}(url, msg, values) {
					if(values['from'] == 'notice') {
						deleteQueryNotice(values['uid'], 'pendingFriend');
					} else if(typeof friend_delete == 'function') {
						friend_delete(values['uid']);
					}
				}
			</script>            
            
		<!--{elseif $op=='changegroup'}-->

			<div class="  box_bg">
            <form method="post" autocomplete="off" id="changegroupform_{$uid}" name="changegroupform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=changegroup&uid=$uid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="changegroupsubmit" value="true" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />


                <div class="weui-cells weui-cells_radio">

                    <!--{loop $groups $key $value}-->
                    <label class="weui-cell weui-check__label" for="x$key">
                        <div class="weui-cell__bd">
                            <p>$value</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="group" value="$key"$groupselect[$key] id="x$key">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <!--{/loop}-->


                </div>

				<div class="weui-btn-area mbw">
					<button type="submit" name="changegroupsubmit_btn" class="btn_pn weui-btn weui-btn_primary" value="true"><strong>{lang determine}</strong></button>
                </div>
			</form>
            </div>
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					friend_changegroup(values['gid']);
				}
			</script>
            		
            
		<!--{elseif $op=='request'}-->

            <!--{if $list}-->
            <div class="weui-cells__title">
                <a href="home.php?mod=spacecp&ac=friend&op=addconfirm&key=$space[key]">{lang confirm_all_applications}</a>
                    |
                <a href="home.php?mod=spacecp&ac=friend&op=ignore&confirm=1&key=$space[key]" onclick="return confirm('{lang determine_ignore_all_friends_application}');">{lang ignore_all_friends_application}</a>
            </div>
            <!--{/if}-->
                
			<!--{if $list}-->

<div class="weui-cells">
    <!--{loop $list $key $value}-->
    <div class="weui-cell">
        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
            <a href="home.php?mod=space&uid=$value[fuid]"><img src="{avatar($value[fuid], middle, true)}" style="width: 50px;display: block"></a>
            <!--{if $ols[$value[fuid]]}--><span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">&nbsp;</span> <!--{/if}-->
        </div>
        <div class="weui-cell__bd">
            <p>$value[fusername]</p>
            <p style="font-size: 13px;color: #888888;" id="friend_$value[fuid]">
                <a class="dialog" href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[fuid]&handlekey=afrfriendhk_{$value[uid]}" id="afr_$value[fuid]"  >{lang confirm_applications}</a>
                <span class="pipe">|</span>
                <a class="dialog" href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$value[fuid]&confirm=1&handlekey=afifriendhk_{$value[uid]}" id="afi_$value[fuid]" >{lang ignore}</a>
            </p>
        </div>
        <div class="weui-cell__ft">
            <!--{date($value[dateline], 'n-j H:i')}-->
        </div>
    </div>
    <!--{/loop}-->
</div>

			<!--{if $multi}-->$multi<!--{/if}-->
			<!--{else}-->

<div class="news-item tpl-1">
    <a class="guide">
        <h2>{lang no_new_friend_application}</h2>
    </a>
</div>
			<!--{/if}-->

		<!--{elseif $op=='add'}-->

			<div class="weui-cells__title">{lang view_note_message}</div>
            <div class=" box_bg mtm">
            <form method="post" autocomplete="off" id="addform_{$tospace[uid]}" name="addform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=friend&op=add&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="addsubmit" value="true" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />


                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <input class="weui-input" name="note" type="text" placeholder="{lang add}{$tospace[username]} {lang add_friend_note}">
                        </div>
                    </div>

                    <div class="weui-cell weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__hd">
                            <label for="" class="weui-label">{lang friend_group}</label>
                        </div>
                        <div class="weui-cell__bd">
                            <select class="weui-select" name="gid" >
                                <!--{loop $groups $key $value}-->
                                <option value="$key" {if empty($space['privacy']['groupname']) && $key==1} selected="selected"{/if}>$value</option>
                                <!--{/loop}-->
                            </select>
                        </div>
                    </div>
                </div>

				<div class="weui-btn-area mbw">
					<button type="submit" name="addsubmit_btn" id="addsubmit_btn" value="true" class="btn_pn weui-btn weui-btn_primary">{lang determine}</button>
				</div>
			</form>
            </div>
		<!--{elseif $op=='add2'}-->
			<div class="weui-cells__title">{lang approval_the_request_group}</div>
            <div class=" box_bg mtm">
            <form method="post" autocomplete="off" id="addratifyform_{$tospace[uid]}" name="addratifyform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=friend&op=add&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="add2submit" value="true" />
				<input type="hidden" name="from" value="$_GET[from]" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />

                <div class="weui-cells weui-cells_radio">

                    <!--{loop $groups $key $value}-->
                    <label class="weui-cell weui-check__label" for="x$key">
                        <div class="weui-cell__bd">
                            <p>$value</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="gid" value="$key"$groupselect[$key] id="x$key">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <!--{/loop}-->


                </div>

				
				<div class="weui-btn-area mbw">
					<button type="submit" name="add2submit_btn" value="true" class="btn_pn weui-btn weui-btn_primary"><strong>{lang approval}</strong></button>
				</div>
                
			</form>
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					if(values['from'] == 'notice') {
						deleteQueryNotice(values['uid'], 'pendingFriend');
					} else {
						myfriend_post(values['uid']);
					}
				}
			</script>
            </div>
		<!--{/if}-->

<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->