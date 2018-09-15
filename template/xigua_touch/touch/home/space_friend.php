<?php exit('xxx'); ?>
<!--{eval $backlist = 1;}-->
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


<!--{if $space[self]}-->
<!--{if $_GET['view']=='blacklist'}-->
<div class="ftfm box_bg mbm">
    <form method="post" autocomplete="off" name="blackform" action="home.php?mod=spacecp&ac=friend&op=blacklist&start=$_GET[start]">

        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input class="weui-input" name="username" type="text" placeholder="{lang username}">
                </div>
            </div>
        </div>
        <div class="weui-cells myprofile nobg">
            <div class="weui-btn-area mbw">
                <button type="submit" name="blacklistsubmit_btn" id="moodsubmit_btn" value="true" class="btn_pn weui-btn weui-btn_primary"><em>{lang add}</em></button>
            </div>
        </div>

        <input type="hidden" name="blacklistsubmit" value="true" />
        <input type="hidden" name="formhash" value="{FORMHASH}" />
    </form>
</div>
<!--{/if}-->
<!--{/if}-->

<!--{if $list}-->
<div id="friend_ul">


    <div class="weui-cells mt0">
        <!--{loop $list $key $value}-->
        <div class="weui-cell">
            <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                <!--{if $value[username] == ''}-->
                    <img src="{STATICURL}image/magic/hidden.gif" alt="{lang anonymity}" style="width: 50px;display: block" />
                <!--{else}-->
                    <img src="{avatar($value[uid], middle, true)}" style="width: 50px;display: block" />
                    <!--{if $ols[$value[uid]]}--><span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">&nbsp;</span><!--{/if}-->
                <!--{/if}-->
            </div>
            <div class="weui-cell__bd">
                <p>
                    <!--{if $value[username]==''}-->
                    {lang anonymity}
                    <!--{else}-->
                    $value[username]
                    <!--{/if}-->
                </p>
                <p style="font-size: 13px;color: #888888;">
                    <!--{if isset($value['follow']) && $key != $_G['uid'] && $value[username] != ''}-->
                    <a  href="home.php?mod=spacecp&ac=follow&op={if $value['follow']}del{else}add{/if}&fuid=$value[uid]&hash={FORMHASH}&from=a_followmod_" id="a_followmod_$key"><!--{if $value['follow']}-->{lang follow_del}<!--{else}-->{lang follow_add}TA<!--{/if}--></a>
                    <!--{/if}-->
                    <!--{if $value[uid] != $_G['uid'] && $value[username] != ''}-->
                    <span class="pipe">|</span> <a   href="home.php?mod=space&uid=$value[uid]&do=profile">{echo xtl('friendprofile')}</a>
                    <span class="pipe">|</span> <a   href="home.php?mod=space&do=pm&subop=view&touid=$value[uid]">{lang send_pm}</a>
                    <!--{/if}-->
                    <!--{if !$value[isfriend] && $value[username] != ''}-->
                    <span class="pipe">|</span><a   href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=adduserhk_{$value[uid]}" id="a_friend_$key" title="{lang add_friend}">{lang add_friend}</a>
                    <!--{elseif !in_array($_GET['view'], array('blacklist', 'visitor', 'trace', 'online'))}-->
                    <span class="pipe">|</span> <a   href="home.php?mod=spacecp&ac=friend&op=changegroup&uid=$value[uid]&handlekey=editgrouphk_{$value[uid]}">{echo xtl('friendgroup')}</a>
                    <span class="pipe">|</span> <a   href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$value[uid]&handlekey=delfriendhk_{$value[uid]}">{lang delete}</a>
                    <!--{/if}-->

                </p>
            </div>

            <div class="weui-cell__ft">
                <!--{if $_GET['view'] == 'blacklist'}-->
                <a   href="home.php?mod=spacecp&ac=friend&op=blacklist&subop=delete&uid=$value[uid]&start=$_GET[start]">{lang delete_blacklist}</a>
                <!--{elseif $_GET['view'] == 'online'}-->
                <!--{date($ols[$value[uid]], 'H:i')}-->
                <!--{else}-->
                <!--{if $value[num]}-->{lang hot}(<span id="spannum_$value[uid]">$value[num]</span>)<!--{/if}-->
                <!--{/if}-->
            </div>

        </div>
        <!--{/loop}-->



    </div>

</div>
<!--{if $multi}-->$multi<!--{/if}-->

<script type="text/javascript">
    function succeedhandle_followmod(url, msg, values) {
        var fObj = $(values['from']+values['fuid']);
        if(values['type'] == 'add') {
            fObj.innerHTML = '{lang follow_del}';
            fObj.className = 'flw_btn_unfo';
            fObj.href = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+values['fuid']+'&from='+values['from'];
        } else if(values['type'] == 'del') {
            fObj.innerHTML = '{lang follow_add}TA';
            fObj.className = 'flw_btn_fo';
            fObj.href = 'home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid='+values['fuid']+'&from='+values['from'];
        }
    }
</script>

<!--{else}-->
<div class="news-item tpl-1">
    <a class="guide">
        <h2>{lang count_member}</h2>
    </a>
</div>

<!--{/if}-->

<!--{if $online_list}-->
<div id="friend_ul">
    <div class="weui-cells__title">{lang online_member}</div>
    <div class="weui-cells mt0">
        <!--{loop $online_list $key $value}-->
        <div class="weui-cell">
            <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                <!--{if $value[username] == ''}-->
                <img src="{STATICURL}image/magic/hidden.gif" alt="{lang anonymity}" style="width: 50px;display: block" />
                <!--{else}-->
                <img src="{avatar($value[uid], middle, true)}" style="width: 50px;display: block" />
                <!--{if $ols[$value[uid]]}--><span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">&nbsp;</span><!--{/if}-->
                <!--{/if}-->
            </div>
            <div class="weui-cell__bd">
                <p>
                    <!--{if $value[username]==''}-->
                    {lang anonymity}
                    <!--{else}-->
                    $value[username]
                    <!--{/if}-->
                </p>
                <p style="font-size: 13px;color: #888888;">
                    <!--{if isset($value['follow']) && $key != $_G['uid'] && $value[username] != ''}-->
                    <a  href="home.php?mod=spacecp&ac=follow&op={if $value['follow']}del{else}add{/if}&fuid=$value[uid]&hash={FORMHASH}&from=a_followmod_" id="a_followmod_$key"><!--{if $value['follow']}-->{lang follow_del}<!--{else}-->{lang follow_add}TA<!--{/if}--></a>
                    <!--{/if}-->
                    <!--{if $value[uid] != $_G['uid'] && $value[username] != ''}-->
                    <span class="pipe">|</span> <a   href="home.php?mod=space&uid=$value[uid]&do=profile">{echo xtl('friendprofile')}</a>
                    <span class="pipe">|</span> <a   href="home.php?mod=space&do=pm&subop=view&touid=$value[uid]">{lang send_pm}</a>
                    <!--{/if}-->
                    <!--{if !$value[isfriend] && $value[username] != ''}-->
                    <span class="pipe">|</span><a   href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=adduserhk_{$value[uid]}" id="a_friend_$key" title="{lang add_friend}">{lang add_friend}</a>
                    <!--{elseif !in_array($_GET['view'], array('blacklist', 'visitor', 'trace', 'online'))}-->
                    <span class="pipe">|</span> <a   href="home.php?mod=spacecp&ac=friend&op=changegroup&uid=$value[uid]&handlekey=editgrouphk_{$value[uid]}">{echo xtl('friendgroup')}</a>
                    <span class="pipe">|</span> <a   href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$value[uid]&handlekey=delfriendhk_{$value[uid]}">{lang delete}</a>
                    <!--{/if}-->

                </p>
            </div>

            <div class="weui-cell__ft">
                <!--{if $_GET['view'] == 'blacklist'}-->
                <a   href="home.php?mod=spacecp&ac=friend&op=blacklist&subop=delete&uid=$value[uid]&start=$_GET[start]">{lang delete_blacklist}</a>
                <!--{elseif $_GET['view'] == 'online'}-->
                <!--{date($ols[$value[uid]], 'H:i')}-->
                <!--{else}-->
                <!--{if $value[num]}-->{lang hot}(<span id="spannum_$value[uid]">$value[num]</span>)<!--{/if}-->
                <!--{/if}-->
            </div>

        </div>
        <!--{/loop}-->
    </div>
</div>
<!--{/if}-->




<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
