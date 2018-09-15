<?php exit('xxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{eval $_G['home_tpl_titles'] = array('{lang pm}');}-->

<!--{if in_array($_GET[subop], array('view'))}--><!--{if $membernum >= 2 && $subject}-->
<!--{eval $navtitle = $membernum.lang('template', 'pm_members_message'). cutstr($subject,4);}-->
<!--{elseif $tousername}-->
<!--{eval $navtitle = lang('template', 'pm_with').$tousername. lang('template', 'pm_totail');}-->
<!--{/if}-->
<!--{else}-->
<!--{eval $navtitle = lang('template', 'mypm');}-->
<!--{/if}-->

<!--{template common/header}-->
<ul id="thread_types" class="ttp  cl">
    <li class="{if $_GET[do]}xw1 a{/if}"><a style="width:50%" href="home.php?mod=space&do=pm">{lang pm}</a></li>
    <li class="{if $_GET[ac]}xw1 a{/if}"><a style="width:50%" href="home.php?mod=spacecp&ac=pm">{lang send_pm}</a></li>
</ul>


<!--{if in_array($filter, array('privatepm')) || in_array($_GET[subop], array('view'))}-->

	<!--{if in_array($filter, array('privatepm'))}-->

	<!-- main pmlist start -->
	<div class="pmbox">
        <!--{if $list}-->

        <div class="weui-cells mt0">
            <!--{loop $list $key $value}-->
            <a class="weui-cell" href="{if $value[touid]}home.php?mod=space&do=pm&subop=view&touid=$value[touid]{else}home.php?mod=space&do=pm&subop=view&plid={$value['plid']}&type=1{/if}">
                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                    <img src="<!--{if $value[pmtype] == 2}-->{STATICURL}image/common/grouppm.png<!--{else}--><!--{avatar($value[touid] ? $value[touid] : ($value[lastauthorid] ? $value[lastauthorid] : $value[authorid]), big, true)}--><!--{/if}-->" style="width: 50px;display: block">
                    <!--{if $value[new]}--><span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">$value[pmnum]</span><!--{/if}-->
                </div>
                <div class="weui-cell__bd">
                    <p><!--{if $value[touid]}-->
                        <!--{if $value[msgfromid] == $_G[uid]}-->
                        {lang me}{lang you_to} {$value[tousername]}{lang say}:
                        <!--{else}-->
                        {$value[tousername]} {lang you_to}{lang me}{lang say}:
                        <!--{/if}-->
                        <!--{elseif $value['pmtype'] == 2}-->
                        {lang chatpm_author}:$value['firstauthor']
                        <!--{/if}-->
                    </p>
                    <p style="font-size: 13px;color: #888888;">
                        <!--{if $value['pmtype'] == 2}-->[{lang chatpm}]<!--{if $value[subject]}-->$value[subject]<br><!--{/if}--><!--{/if}--><!--{if $value['pmtype'] == 2 && $value['lastauthor']}-->......<br>$value['lastauthor'] : $value[message]<!--{else}-->$value[message]<!--{/if}-->
                        <br>
                        <!--{date($value[dateline], 'u')}-->
                    </p>
                </div>
            </a>
            <!--{/loop}-->
        </div>

        <!--{else}-->
        <div class="news-item tpl-1">
            <a class="guide">
                <h2>{echo lang('space', 'block_doing_no_content')}</h2>
            </a>
        </div>
        <!--{/if}-->
	</div>
	<!-- main pmlist end -->

	<!--{elseif in_array($_GET[subop], array('view'))}-->

	<!-- main viewmsg_box start -->
	<div class="wp">
		<div class="msgbox b_m">
			<!--{if !$list}-->
				{lang no_corresponding_pm}
			<!--{else}-->
				<!--{loop $list $key $value}-->
					<!--{subtemplate home/space_pm_node}-->
				<!--{/loop}-->
				$multi
			<!--{/if}-->
		</div>
		<!--{if $list}-->
            <form id="pmform" class="pmform" name="pmform" method="post" action="home.php?mod=spacecp&ac=pm&op=send&pmid=$pmid&daterange=$daterange&pmsubmit=yes&mobile=2" >
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<!--{if !$touid}-->
			<input type="hidden" name="plid" value="$plid" />
			<!--{else}-->
			<input type="hidden" name="touid" value="$touid" />
			<!--{/if}-->
			<div class="reply b_m"><input type="text" value="" class="px" autocomplete="off" id="replymessage" name="message"></div>
			<div class="reply b_m"><input type="button" name="pmsubmit" id="pmsubmit" class="formdialog button2" value="{lang reply}" /></div>
            </form>

		<!--{/if}-->
	</div>
	<!-- main viewmsg_box end -->

	<!--{/if}-->

<!--{else}-->
<div class="news-item tpl-1">
    <a class="guide">
        <h2>{lang user_mobile_pm_error}</h2>
    </a>
</div>
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
