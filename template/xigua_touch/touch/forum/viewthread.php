<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->
<style>.x_header{display:none}</style>
<!--{template common/header}-->

<!--{if $_G['cache']['plugin']['xigua_th']['jiange']==2}-->
<style>.plc .pi .message img, .plc .pi .img_one img{margin: 0!important}</style>
<!--{elseif $_G['cache']['plugin']['xigua_th']['jiange']==3}-->
<style>.plc .pi .message img, .plc .pi .img_one img{margin: 0!important}.plc .pi .message br{display:none}</style>
<!--{/if}-->

<!--{eval
$recommenduid = 0;
if($_G['uid']):
$recommenduid = C::t('forum_memberrecommend')->fetch_by_recommenduid_tid($_G['uid'], $_G['tid']);
endif;
}-->

<!--{if is_array($extra)}-->
<!--{eval $extra = urlencode(http_build_query($extra));}-->
<!--{/if}-->
<!--{eval $zans = $_G['forum_thread']['recommend_add'];}-->
<!--{hook/viewthread_top_mobile}-->
<!-- main postlist start -->
<div class="postlist cl">
	<div class="headtitle">
        <a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$extra&mobile=2">
		<h2>
			<!--{if $_G['forum_thread']['typeid'] && $_G['forum']['threadtypes']['types'][$_G['forum_thread']['typeid']]}-->
			[{$_G['forum']['threadtypes']['types'][$_G['forum_thread']['typeid']]}]
			<!--{/if}-->
			<!--{if $threadsorts && $_G['forum_thread']['sortid']}-->
			[{$_G['forum']['threadsorts']['types'][$_G['forum_thread']['sortid']]}]
			<!--{/if}-->
			$_G[forum_thread][subject]
			<!--{if $_G['forum_thread'][displayorder] == -2}--> <span>({lang moderating})</span>
			<!--{elseif $_G['forum_thread'][displayorder] == -3}--> <span>({lang have_ignored})</span>
			<!--{elseif $_G['forum_thread'][displayorder] == -4}--> <span>({lang draft})</span>
			<!--{/if}-->
		</h2>
        </a>
        <!--{loop $postlist $post}-->
        <!--{if $post['first']}-->


        <!--{block authorverifys}-->
        <!--{loop $post['verifyicon'] $vid}-->
        <a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid" target="_blank"><!--{if $_G['setting']['verify'][$vid]['icon']}--><img src="$_G['setting']['verify'][$vid]['icon']" class="vm verifycode" alt="$_G['setting']['verify'][$vid][title]" title="$_G['setting']['verify'][$vid][title]" /><!--{else}-->$_G['setting']['verify'][$vid]['title']<!--{/if}--></a>
        <!--{/loop}-->
        <!--{loop $post['unverifyicon'] $vid}-->
        <a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid" target="_blank"><img src="$_G['setting']['verify'][$vid]['unverifyicon']" class="vm verifycode" alt="$_G['setting']['verify'][$vid][title]" title="$_G['setting']['verify'][$vid][title]" /></a>
        <!--{/loop}-->
        <!--{/block}-->


        <div class="article-header">

                <figure class="x-user x-avatar">
                    <a>
                        <img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, small, true)}--><!--{else}--><!--{avatar($post[authorid], small, true)}--><!--{/if}-->" />
                    </a>
                </figure>

                <div class="texts">
                    <div class="x-user usr-name">

                        <!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
                            <a href="home.php?mod=space&uid=$post[authorid]" class="blue vm">$post[author]</a>
                            $authorverifys
                            <div class="mod-lv user-level bgcolor_{echo usergroup_iconid($post[groupid])}">
                                <span class="mod-lv-icon color_{echo usergroup_iconid($post[groupid])}"><i class="iconfont icon-<!--{if $post[gender]==1}-->nan<!--{elseif $post[gender]==2}-->nv<!--{else}-->biaoxing<!--{/if}-->"></i></span>
                                <span>{$_G['cache']['usergroups'][$post['groupid']]['grouptitle']}</span>
                            </div>
                        <!--{else}-->
                        <!--{if !$post['authorid']}-->
                        <a href="javascript:;" class="blue vm">{lang guest} <em>$post[useip]{if $post[port]}:$post[port]{/if}</em></a>
                        <!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
                        <!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]"  class="blue vm">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
                        <!--{else}-->
                        <em class="vm">$post[author] {lang member_deleted}</em>
                        <!--{/if}-->
                        <!--{/if}-->

                    </div>

                    <em class="vm grey f12">$post[dateline]</em>

                    <!--{if $_G['cache']['plugin']['xigua_th']['guanzhu']}-->
                        <a class="favuserbtn" href="{$_G['cache']['plugin']['xigua_th']['guanzhu']}">+ {echo xtl('guanzhu');}</a>
                    <!--{else}-->
                        <!--{eval
                        $followed = 0;
                        if($_G['uid']):
                            $followed = C::t('home_follow')->fetch_by_uid_followuid($_G['uid'], $post['authorid']);
                        endif;
                        }-->
                        <!--{if $followed}-->
                        <a class="favuserbtn dialog favuserbtn_have" href="home.php?mod=spacecp&ac=follow&op=del&hash={FORMHASH}&fuid=$post[authorid]">{echo xtl('guanzhu1');}</a>
                        <!--{else}-->
                        <a class="favuserbtn dialog" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$post[authorid]">+{echo xtl('guanzhu');}</a>
                        <!--{/if}-->
                    <!--{/if}-->
                </div>
        </div>


        <!--{eval break;}-->
        <!--{/if}-->
        <!--{/loop}-->
	</div>

    <!--{eval $postcount = 0;}-->

	<!--{loop $postlist $post}-->
    <!--{if $post[first]}-->

    <!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
       <div class="plc cl postitem" id="pid$post[pid]">
           <!--{hook/viewthread_posttop_mobile $postcount}-->
           <div class="display pi" href="#replybtn_$post[pid]">
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
                            <!--{if $_G['forum_thread']['price'] > 0 && $_G['forum_thread']['special'] == 0}-->
                                {lang pay_threads}: <strong>$_G[forum_thread][price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} </strong> <a href="forum.php?mod=misc&action=viewpayments&tid=$_G[tid]" >{lang pay_view}</a>
                            <!--{/if}-->

                            <!--{if $post['first'] && $threadsort && $threadsortshow}-->
                                <!--{if $threadsortshow['optionlist'] && !($post['status'] & 1) && !$_G['forum_threadpay']}-->
                                    <!--{if $threadsortshow['optionlist'] == 'expire'}-->
                                        {lang has_expired}
                                    <!--{else}-->
                                        <!--{template forum/viewthread_sort}-->
                                    <!--{/if}-->
                                <!--{/if}-->
                            <!--{/if}-->
                            <!--{if $post['first']}-->

                    <!--{if $_G['forum_discuzcode']['passwordlock'][$post[pid]]}-->
                    <div class="locked">{lang message_password_exists} {lang pleaseinputpw}<input type="text" id="postpw_$post[pid]" class="input" style="line-height:28px;border: 1px solid #FF9A9A;padding: 0 10px;width: 100%;margin:6px 0 8px;" />
                        <button class="button2" type="button" onclick="submitpostpw($post[pid]{if $_GET['from'] == 'preview'},{$post[tid]}{else}{/if})"><strong>{lang submit}</strong></button></div>
                    <script src="{$_G[setting][jspath]}md5.js?{VERHASH}"></script>
                    <script>
                        function submitpostpw(pid, tid) {
                            var obj = document.getElementById('postpw_' + pid);
                            safescript('md5_js', function () {
                                setcookie('postpw_' + pid, hex_md5(obj.value));
                                if(!tid) {
                                    location.href = location.href;
                                } else {
                                    location.href = 'forum.php?mod=viewthread&tid='+tid;
                                }
                            }, 100, 50);
                        }
                        function safescript(id, call, seconds, times, timeoutcall, endcall, index) {
                            seconds = seconds || 1000;
                            times = times || 0;
                            var checked = true;
                            try {
                                if(typeof call == 'function') {
                                    call();
                                } else {
                                    eval(call);
                                }
                            } catch(e) {
                                checked = false;
                            }
                            if(!checked) {
                                if(!safescripts[id] || !index) {
                                    safescripts[id] = safescripts[id] || [];
                                    safescripts[id].push({
                                        'times':0,
                                        'si':setInterval(function () {
                                            safescript(id, call, seconds, times, timeoutcall, endcall, safescripts[id].length);
                                        }, seconds)
                                    });
                                } else {
                                    index = (index || 1) - 1;
                                    safescripts[id][index]['times']++;
                                    if(safescripts[id][index]['times'] >= times) {
                                        clearInterval(safescripts[id][index]['si']);
                                        if(typeof timeoutcall == 'function') {
                                            timeoutcall();
                                        } else {
                                            eval(timeoutcall);
                                        }
                                    }
                                }
                            } else {
                                try {
                                    index = (index || 1) - 1;
                                    if(safescripts[id][index]['si']) {
                                        clearInterval(safescripts[id][index]['si']);
                                    }
                                    if(typeof endcall == 'function') {
                                        endcall();
                                    } else {
                                        eval(endcall);
                                    }
                                } catch(e) {}
                            }
                        }
                    </script>
                    <!--{/if}-->

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
           </div>

           <div class="funcbar">
               <ul class="weui-flex">
                   <li>
                       <!--{if !IS_ROBOT && !$_GET['authorid'] && !$_G['forum_thread']['archiveid']}-->
                       <a href="forum.php?mod=viewthread&tid=$_G[tid]&page=$page&authorid=$_G[forum_thread][authorid]" rel="nofollow" class="">{lang viewonlyauthorid}</a>
                       <!--{elseif !$_G['forum_thread']['archiveid']}-->
                       <a href="forum.php?mod=viewthread&tid=$_G[tid]&page=$page" rel="nofollow" class="">{lang thread_show_all}</a>
                       <!--{/if}-->
                   </li>
                   <li>
                       <a onclick="return showFastform();" href="javascript:;"><i class="iconfont icon-comiisluntan"></i> {$_G['forum_thread'][replies]}</a>
                   </li>
                   <li><a href="forum.php?mod=misc&action=recommend&handlekey=recommend_add&do=add&tid={$_G[tid]}&hash={FORMHASH}&mobile=2" class="praise_link add_praise <!--{if $recommenduid}-->zan<!--{/if}-->"><i class="iconfont icon-good"></i>
                           <i class="praise_num">{$zans}</i>
                       </a>
                   </li>
               </ul>
           </div>


           <div class="view-mode weui-flex cl">
               <div><i class="iconfont icon-browse"></i> {echo xtl('liulan');} {$_G['forum_thread'][views]}</div>
               <div><i class="iconfont icon-comiisluntan"></i> {echo xtl('hui');} {$_G['forum_thread'][replies]}</div>
               <!--{if $_G['forum']['ismoderator']}-->
               <!-- manage start -->
               <div class="weui-flex__item">
                   <!--{if $post[first]}-->
                   <a href="#moption_$post[pid]" class="popup blue">{lang manage}</a>
                   <div id="moption_$post[pid]" popup="true" class="manage" style="display:none;">


                       <div class="weui-skin_android animated fadeIn">
                           <div class="weui-actionsheet">
                               <div class="weui-actionsheet__menu">
                                   <div class="weui-actionsheet__cell">
                                       <a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]<!--{if $_G[forum_thread][sortid]}--><!--{if $post[first]}-->&sortid={$_G[forum_thread][sortid]}<!--{/if}--><!--{/if}-->{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page" class="redirect">{lang edit}</a>
                                   </div>

                                   <div class="weui-actionsheet__cell">
                                       <a class="dialog" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&operation=delete&optgroup=3&from={$_G[tid]}">{lang delete}</a>
                                   </div>

                                   <div class="weui-actionsheet__cell">
                                       <a class="dialog" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=4">{lang close}</a>
                                   </div>

                                   <div class="weui-actionsheet__cell">
                                       <a class="dialog" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang admin_banpost}</a>
                                   </div>

                                   <div class="weui-actionsheet__cell">
                                       <a class="dialog" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang topicadmin_warn_add}</a>
                                   </div>

                               </div>
                           </div>
                       </div>


                   </div>
                   <!--{/if}-->
               </div>
               <!-- manage end -->

               <!--{elseif ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit))}-->
               <div class="weui-flex__item">
                   <a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]<!--{if $_G[forum_thread][sortid]}--><!--{if $post[first]}-->&sortid={$_G[forum_thread][sortid]}<!--{/if}--><!--{/if}-->{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page" class="redirect blue">{lang edit}</a>
               </div>
               <!--{/if}-->

           </div>

           <!--{hook/viewthread_postbottom_mobile $postcount}-->
           <!--{eval $postcount++;}-->

           <!--{if $post['first'] && ($post[tags] || $relatedkeywords) && $_GET['from'] != 'preview'}-->
           <div class="post-tags">
               <!--{if $post[tags]}-->
               <!--{eval $tagi = 0;}-->
               <!--{loop $post[tags] $var}-->
               <a title="$var[1]" class="weui-btn weui-btn_mini weui-btn_default" href="misc.php?mod=tag&id=$var[0]" target="_blank">$var[1]</a>
               <!--{eval $tagi++;}-->
               <!--{/loop}-->
               <!--{/if}-->
               <!--{if $relatedkeywords}--><a class="weui-btn weui-btn_mini weui-btn_default">$relatedkeywords</a><!--{/if}-->
           </div>
           <!--{/if}-->

       </div>
    <!--{eval break;}-->
    <!--{/if}-->
    <!--{/loop}-->

    <!-- first floor end -->



    <!--{if $post['first']}-->
        <!--{if $post['relateitem']}-->
        <!--relateitem start-->
        <!--{eval $post['relateitem'] = x_s2($post['relateitem']);}-->
        <div class="comment-title">
            <h3>{lang related_thread}</h3><span class="subline"></span>
        </div>
        <div class="relateitems">
            <div class="news-list-wrapper tab-news-content">
                <!--{loop $post['relateitem'] $key $thread}-->
                <!--{subtemplate common/thread_list_node2}-->
                <!--{/loop}-->
            </div>
        </div>
        <!--relateitem end-->
        <!--{/if}-->

        <div class="m_article backtoforum">
            <a class="blue" href="forum.php?mod=forumdisplay&fid=$_G[fid]&mobile=2">{echo xtl('jin');} "$_G[forum][name]"&nbsp;<i class="iconfont icon-xiangyoujiantou"></i></a>
        </div>
    <!--{/if}-->



    <div class="comment-title">
        <h3>{echo xtl('ping');}</h3><span></span>

        <a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&page={$_GET[page]}&ordertype=2&mobile=2#post_ascview" name="post_ascview"  id="post_ascview" <!--{if $_GET['ordertype']!=1}-->class="show"<!--{/if}-->>{echo xtl('zheng');}</a>
        <em>/</em>
        <a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&page={$_GET[page]}&ordertype=1&mobile=2#post_descview" name="post_descview" id="post_descview" <!--{if $_GET['ordertype']==1}-->class="show"<!--{/if}-->>{echo xtl('dao');}</a>

    </div>
    <!--{if (count($postlist) <1&& $_GET[page]>1)|| (count($postlist) <2&& $_GET[page]<=1)}-->
    <a class="kongzhuangtai" href="javascript:;" onclick="return showFastform();">
        <i class="iconfont icon-007zanwuneirong"></i>
        <p>{echo xtl('kuai');}</p>
    </a>
    <!--{/if}-->


    <!--{loop $postlist $post}-->
    <!--{if $post[first]}-->
    <!--{eval continue;}-->
    <!--{/if}-->
    <!--{subtemplate forum/viewthread_node}-->
    <!--{/loop}-->

    <div id="post_new"></div>
</div>

<!--{subtemplate forum/forumdisplay_fastpost}-->
<!-- main postlist end -->

$multipage

<!--{hook/viewthread_bottom_mobile}-->

<script type="text/javascript">
	$('.favbtn').on('click', function() {
		var obj = $(this);
		$.ajax({
			type:'POST',
			url:obj.attr('href') + '&handlekey=favbtn&inajax=1',
			data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
			dataType:'xml'
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			window.location.href = obj.attr('href');
			popup.close();
		});
		return false;
	});
</script>

<a href="javascript:;" class="caidantop sidectrl bottom"><i class="iconfont icon-caidan"></i></a>
<!--{eval $noxb = 1;}-->
<!--{eval $hasfav = $_G['uid'] ? C::t('home_favorite')->fetch_by_id_idtype($_G['tid'], 'tid', $_G['uid']) : '';}-->
<!--{eval $countfav = C::t('home_favorite')->count_by_id_idtype($_G['tid'], 'tid');}-->
<div class="viewthread_foot">
    <ul class="weui-flex">
        <li class="weui-flex__item"><a href="<!--{if $_SERVER['HTTP_REFERER']&&strpos($_SERVER['HTTP_REFERER'],'tid=')===false}-->{$_SERVER['HTTP_REFERER']}<!--{else}-->forum.php?mod=forumdisplay&fid={$_G[fid]}<!--{/if}-->"><i class="icon iconfont icon-xiangzuojiantou"></i></a></li>
        <li class="weui-flex__item fainput"><a href="javascript:;" onclick="return showFastform();" class="bg_f f_c b_ok ooo_openrebox"><em>{echo xtl('xie');}</em></a></li>
        <li class="weui-flex__item"><a href="forum.php?mod=misc&action=recommend&handlekey=recommend_add&do=add&tid={$_G[tid]}&hash={FORMHASH}&mobile=2" class="praise_link add_praise <!--{if $recommenduid}-->zan<!--{/if}-->"><i class=" iconfont icon-good"></i><em class="innernum"><i class="praise_num">{$zans}</i></em></a></li>
        <li class="weui-flex__item"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id={$_G[tid]}&handlekey=favorite_thread&mobile=2" class="dialog <!--{if $hasfav}-->zan<!--{/if}-->"><i class="icon iconfont icon-shoucang1"></i><em class="innernum"><i>{$countfav}</i></em></a></li>
        <li class="weui-flex__item"><a id="showIOSActionSheet" href="javascript:;" class="ooo_recommend_addkey ooo_recommend_new"><i class="iconfont icon-fenxiang5"></i></a></li>
    </ul>
</div>

<!--BEGIN actionSheet-->
<div>
    <div class="touch_weuimask" id="iosMask" style="display: none"></div>
    <!--{if stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false}-->
    <div class="weui-actionsheet" id="touch_iosActionsheet" data-id="weui_actionsheet_toggle1">
        <div id="xg_wechatguider"></div>
    </div>
        <!--{else}-->
    <div class="weui-actionsheet" id="touch_iosActionsheet" data-id="weui_actionsheet_toggle2">
        <div id="xg_otherguider"></div>
    </div>
        <!--{/if}-->
    </div>
</div>
<!--END actionSheet-->

<script>
    function setanswer(tid, pid, from){
        if(confirm('{echo xtl('setanswer')}')){
            document.getElementById('modactions').action='forum.php?mod=misc&action=bestanswer&tid=' + tid + '&pid=' + pid + '&from=' + from + '&bestanswersubmit=yes';
            document.getElementById('modactions').submit();
        }
    }
</script>
<form style="display:none" method="post" autocomplete="off" name="modactions" id="modactions">
    <input type="hidden" name="formhash" value="{FORMHASH}" />
    <input type="hidden" name="optgroup" />
    <input type="hidden" name="operation" />
    <input type="hidden" name="listextra" value="$_GET[extra]" />
    <input type="hidden" name="page" value="$page" />
</form>
<!--{template common/footer}-->
