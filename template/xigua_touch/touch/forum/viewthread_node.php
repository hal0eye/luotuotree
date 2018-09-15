<?php exit('xxxx'); ?>
<!--{eval include_once DISCUZ_ROOT.TPLDIR.'/php/discuz.php';}-->
<!-- main postlist start -->

<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
<div class="plc cl postitem" id="pid$post[pid]">
    <!--{hook/viewthread_posttop_mobile $postcount}-->
    <!--{if !$post[first]}-->
    <span class="avatar"><img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, small, true)}--><!--{else}--><!--{avatar($post[authorid], small, true)}--><!--{/if}-->" style="width:32px;height:32px;" /></span>
    <ul class="authi">
        <li class="grey">

            <!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
            <a href="home.php?mod=space&uid=$post[authorid]" class="blue">$post[author]</a>

            <div class="mod-lv user-level bgcolor_{echo usergroup_iconid($post[groupid])}">
                <span class="mod-lv-icon color_{echo usergroup_iconid($post[groupid])}"><i class="iconfont icon-<!--{if $post[gender]==1}-->nan<!--{elseif $post[gender]==2}-->nv<!--{else}-->biaoxing<!--{/if}-->"></i></span>
                <span>$_G['cache']['usergroups'][$post['groupid']]['grouptitle']</span>
            </div>

            <!--{else}-->
            <!--{if !$post['authorid']}-->
            <a href="javascript:;">{lang guest} <em>$post[useip]{if $post[port]}:$post[port]{/if}</em></a>
            <!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
            <!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]" target="_blank">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
            <!--{else}-->
            $post[author] <em>{lang member_deleted}</em>
            <!--{/if}-->
            <!--{/if}-->

            <!--{if !$post[first]}-->
            <div id="replybtn_$post[pid]" class="replybtn y">
        <!--{if $_G[uid] && $allowpostreply}-->
                <!--{if $_G['forum']['ismoderator']}-->
                <!-- manage start -->
                <em><a href="#moption_$post[pid]" class="popup blue">{lang manage}</a></em>
                <div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">
                    <div class="weui-skin_android animated fadeIn">
                        <div class="weui-actionsheet">
                            <div class="weui-actionsheet__menu">
                                <div class="weui-actionsheet__cell">
                                    <a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page" class="redirect">{lang edit}</a>
                                </div>
                                <!--{if $_G['group']['allowdelpost']}-->
                                <div class="weui-actionsheet__cell">
                                    <a class="dialog" href="forum.php?mod=topicadmin&action=delpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}">{lang modmenu_deletepost}</a></div>
                                <!--{/if}-->

                                <!--{if $_G['group']['allowbanpost']}-->
                                <div class="weui-actionsheet__cell">
                                    <a href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}" class="dialog">{lang modmenu_banpost}</a>
                                </div>
                                <!--{/if}-->
                                <!--{if $_G['group']['allowwarnpost']}-->
                                <div class="weui-actionsheet__cell">
                                    <a href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}" class="dialog">{lang modmenu_warn}</a>
                                </div>
                                <!--{/if}-->

                                <!--{if $_G['forum_thread']['special'] == 3 && ($_G['forum']['ismoderator'] && (!$_G['setting']['rewardexpiration'] || $_G['setting']['rewardexpiration'] > 0 && ($_G[timestamp] - $_G['forum_thread']['dateline']) / 86400 > $_G['setting']['rewardexpiration']) || $_G['forum_thread']['authorid'] == $_G['uid']) && $post['authorid'] != $_G['forum_thread']['authorid'] && $post['first'] == 0 && $_G['uid'] != $post['authorid'] && $_G['forum_thread']['price'] > 0}-->
                                <div class="weui-actionsheet__cell">
                                    <a onclick="setanswer($post['tid'], $post['pid'], '$_GET[from]')" href="javascript:;">{lang reward_set_bestanswer}</a>
                                </div>
                                <!--{/if}-->

                            </div>
                        </div>
                    </div>

                </div>
                <!-- manage end -->
                <!--{elseif ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit))}-->
                <em><a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]<!--{if $_G[forum_thread][sortid]}--><!--{if $post[first]}-->&sortid={$_G[forum_thread][sortid]}<!--{/if}--><!--{/if}-->{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page" class="redirect blue">{lang edit}</a></em>
                <!--{/if}-->

        <!--{/if}-->

                <a href="forum.php?mod=misc&action=postreview&do=support&tid=$_G[tid]&pid={$post[pid]}&hash={FORMHASH}&handlekey=recommend_add" class="add_praise"><i class=" iconfont icon-good<!--{if $recommenduid}--><!--{/if}-->"></i> <i class="praise_num">{$post[postreview][support]}</i></a>
                <a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page" title="{lang reply}"><i class="iconfont icon-comiisluntan"></i></a>

            </div>
            <!--{/if}-->

        </li>
        <li class="grey rela f12">
            <a>
                <!--{if isset($post[isstick])}-->
                <i class="iconfont icon-zhiding" title="{lang replystick}" ></i>{lang from} {$post[number]}{$postnostick}
                <!--{elseif $post[number] == -1}-->
                {lang recommend_post}
                <!--{else}-->
                <!--{if !empty($postno[$post[number]])}-->$postno[$post[number]]<!--{else}-->{$post[number]}{$postno[0]}<!--{/if}-->
                <!--{/if}-->
            </a>

            $post[dateline]

        </li>
    </ul>
    <!--{/if}-->
    <div class="display pi postmessage1" href="#replybtn_$post[pid]">
        <div class="message">
            <!--{if $post['warned']}-->
            <span class="grey quote">{lang warn_get}</span>
            <!--{/if}-->
            <!--{if !$post['first'] && !empty($post[subject])}-->
            <h2><strong>$post[subject]</strong></h2>
            <!--{/if}-->
            <!--{if $_G['adminid'] != 1 && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || $post['status'] == -1 || $post['memberstatus'])}-->
            <div class="grey quote">{lang message_banned}</div>
            <!--{elseif $_G['adminid'] != 1 && $post['status'] & 1}-->
            <div class="grey quote">{lang message_single_banned}</div>
            <!--{elseif $needhiddenreply}-->
            <div class="grey quote">{lang message_ishidden_hiddenreplies}</div>
            <!--{elseif $post['first'] && $_G['forum_threadpay']}-->
            <!--{template forum/viewthread_pay}-->
            <!--{else}-->

            <!--{if $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))}-->
            <div class="grey quote">{lang admin_message_banned}</div>
            <!--{elseif $post['status'] & 1}-->
            <div class="grey quote">{lang admin_message_single_banned}</div>
            <!--{/if}-->

            <!--{if $post['first'] && $threadsort && $threadsortshow}-->
            <!--{if $threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']}-->
            <!--{if $threadsortshow['optionlist'] == 'expire'}-->
            {lang has_expired}
            <!--{else}-->
            <div class="box_ex2 viewsort">
                <h4>$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</h4>
                <!--{loop $threadsortshow['optionlist'] $option}-->
                <!--{if $option['type'] != 'info'}-->
                $option[title]: <!--{if $option['value']}-->$option[value] $option[unit]<!--{else}--><span class="grey">--</span><!--{/if}--><br />
                <!--{/if}-->
                <!--{/loop}-->
            </div>
            <!--{/if}-->
            <!--{/if}-->
            <!--{/if}-->
            <!--{if $post['first']}-->
            <!--{if !$_G[forum_thread][special]}-->
            $post[message]
            <!--{elseif $_G[forum_thread][special] == 1}-->
            <!--{template forum/viewthread_poll}-->
            <!--{elseif $_G[forum_thread][special] == 2}-->
            <!--{template forum/viewthread_trade}-->
            <!--{elseif $_G[forum_thread][special] == 3}-->
            <!--{template forum/viewthread_reward}-->
            <!--{elseif $_G[forum_thread][special] == 4}-->
            <!--{template forum/viewthread_activity}-->
            <!--{elseif $_G[forum_thread][special] == 5}-->
            <!--{template forum/viewthread_debate}-->
            <!--{elseif $threadplughtml}-->
            $threadplughtml
            $post[message]
            <!--{else}-->
            $post[message]
            <!--{/if}-->
            <!--{else}-->
            $post[message]
            <!--{/if}-->

            <!--{/if}-->
        </div>
        <!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
        <!--{if $post['attachment']}-->
        <div class="grey quote">
            {lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em>
        </div>
        <!--{elseif $post['imagelist'] || $post['attachlist']}-->
        <!--{if $post['imagelist']}-->
        <!--{if count($post['imagelist']) == 1}-->
        <ul class="img_one">{echo showattach($post, 1)}</ul>
        <!--{else}-->
        <ul class="img_list cl vm">{echo showattach($post, 1)}</ul>
        <!--{/if}-->
        <!--{/if}-->
        <!--{if $post['attachlist']}-->
        <ul>{echo showattach($post)}</ul>
        <!--{/if}-->
        <!--{/if}-->
        <!--{/if}-->

        <!--{hook/viewthread_postbottom_mobile $postcount}-->
        <!--{eval $postcount++;}-->
    </div>
</div>

<!-- main postlist end -->
