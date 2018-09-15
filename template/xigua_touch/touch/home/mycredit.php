<?php exit('xxxxx'); ?>

<div class="user_box">

    <!--{if $_REQUEST[view]}-->
    <div class="weui-cells">

        <a class="weui-cell" href="javascript:;">
            <div class="weui-cell__bd">
                {lang credits}
            </div>
            <div class="weui-cell__ft">$space[credits]</div>
        </a>

        <!--{loop $_G[setting][extcredits] $key $value}-->
        <!--{if $value[title]}-->
        <a class="weui-cell">
            <div class="weui-cell__bd">
                $value[title]
            </div>
            <div class="weui-cell__ft">{$space["extcredits$key"]} $value[unit]</div>
        </a>
        <!--{/if}-->
        <!--{/loop}-->

    </div>
    <!--{else}-->
    <div class="weui-cells">

        <!--{if $_G[uid]==$space[uid]}-->
        <a class="weui-cell weui-cell_access" href="home.php?mod=spacecp">
            <div class="weui-cell__bd">
                <p>{echo xtl('xiu');}</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <!--{/if}-->

        <!--{if helper_access::check_module('wall')}-->
        <a class="weui-cell weui-cell_access" href="home.php?mod=space&uid=$space[uid]&do=wall&from=space">
            <div class="weui-cell__bd">
                <p>taµƒ¡Ù—‘∞Â</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <!--{/if}-->

        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>UID</p>
            </div>
            <div class="weui-cell__ft">$space[uid]</div>
        </div>

        <!--{if $_G[uid]!=$space[uid]}-->

        <a class="weui-cell weui-cell_access" href="home.php?mod=space&uid={$space[uid]}&do=thread">
            <div class="weui-cell__bd">
                <p>{echo lang('forum/template', 'posts');}</p>
            </div>
            <div class="weui-cell__ft"> </div>
        </a>
        <!--{/if}-->


        <!--{if in_array($_G[adminid], array(1, 2))}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>Email</p>
            </div>
            <div class="weui-cell__ft">$space[email]</div>
        </div>
        <!--{/if}-->

        <!--{loop $profiles $value}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>$value[title]</p>
            </div>
            <div class="weui-cell__ft">$value[value]</div>
        </div>
        <!--{/loop}-->


        <!--{if $space[adminid]}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>{lang management_team}</p>
            </div>
            <div class="weui-cell__ft">{$space[admingroup][grouptitle]} {$space[admingroup][icon]}</div>
        </div>
        <!--{/if}-->

        <!--{if $space[extgroupids]}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                {lang group_expiry_type_ext}
            </div>
            <div class="weui-cell__ft">$space[extgroupids]</div>
        </div>
        <!--{/if}-->

    </div>
    <div class="weui-cells">



        <a class="weui-cell weui-cell_access"  href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=adduserhk_{$space[uid]}" id="a_friend_$space[uid]" title="{lang add_friend}">
            <div class="weui-cell__bd">
                <p>{lang add_friend}</p>
            </div>
            <div class="weui-cell__ft"> </div>
        </a>

        <div class="weui-cell">
            <div class="weui-cell__bd">
                {lang online_time}
            </div>
            <div class="weui-cell__ft">$space[oltime] {lang hours}</div>
        </div>


        <div class="weui-cell">
            <div class="weui-cell__bd">{lang last_visit}</div>
            <div class="weui-cell__ft">$space[lastvisit]</div>
        </div>
        <!--{if $space[uid] == $_G[uid]}-->
        <!--{if $_G[uid] == $space[uid] || $_G[group][allowviewip]}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">{lang register_ip}</div>
            <div class="weui-cell__ft">$space[regip] - $space[regip_loc]</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">{lang last_visit_ip}</div>
            <div class="weui-cell__ft">$space[lastip] - $space[lastip_loc]</div>
        </div>
        <!--{/if}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">{lang last_activity_time}</div>
            <div class="weui-cell__ft">$space[lastactivity]</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">{lang last_post_time}</div>
            <div class="weui-cell__ft">$space[lastpost]</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">{lang last_send_email}</div>
            <div class="weui-cell__ft">$space[lastsendmail]</div>
        </div>

        <!--{eval $timeoffset = array({lang timezone});}-->
        <div class="weui-cell">
            <div class="weui-cell__bd"> {lang time_offset}</div>
            <div class="weui-cell__ft"> $timeoffset[$space[timeoffset]]</div>
        </div>
        <!--{/if}-->
    </div>
    <!--{/if}-->




</div>
