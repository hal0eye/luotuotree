<?php exit;?>
<!--{eval $backlist = 1;}-->
<!--{eval $_G['home_tpl_titles'] = array('{lang remind}');}-->
<!--{subtemplate common/header}-->


<ul id="thread_types" class="ttp  cl">
    <ul class="tab4">
        <!--{eval $t = 1;}-->
        <!--{loop $_G['notice_structure'] $key $type}-->
        <!--{if $t <5}-->
        <li class="{if $actives[$key]}xw1 a{/if}"><a href="home.php?mod=space&do=notice&view=$key"><!--{eval echo lang('template', 'notice_'.$key)}-->
                <!--{if $_G['member']['category_num'][$key]}--><!--{/if}-->
            </a></li>
        <!--{/if}-->
        <!--{eval $t++;}-->
        <!--{/loop}-->
    </ul>
</ul>

<div class="noticebox">

			<!--{if empty($list)}-->
        <div class="news-item tpl-1">
            <!--{if $_GET[isread] != 1}-->
            <a class="guide" href="home.php?mod=space&do=notice&isread=1"><h2>{lang no_new_notice} {lang view_old_notice}</h2></a>
                    <!--{else}-->
            <a class="guide"><h2>{lang no_notice}</h2></a>
                    <!--{/if}-->
        </div>
			<!--{/if}-->

			<!--{if $list}-->

    <div class="weui-cells mt0">

        <!--{loop $list $key $value}-->
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>$value[note]</p>
                <p style="font-size: 13px;color: #888888;">
                    <!--{date($value[dateline], 'u')}-->
                    <!--{if $value[from_num]}-->
                    {lang ignore_same_notice_message}
                    <!--{/if}-->
                </p>
            </div>
            <div class="weui-cell__ft"><a href="home.php?mod=spacecp&ac=common&op=ignore&authorid=$value[authorid]&type=$value[type]&handlekey=addfriendhk_{$value[authorid]}" class="dialog" >{lang shield}</a></div>
        </div>
        <!--{/loop}-->



    </div>
				<!--{if $view!='userapp' && $space[notifications]}-->
    <div class="news-item tpl-1">
        <a class="guide" href="home.php?mod=space&do=notice&ignore=all">
            <h2>{lang ignore_same_notice_message}</h2>
        </a>
    </div>

				<!--{/if}-->

				<!--{if $multi}-->$multi<!--{/if}-->
			<!--{/if}-->

</div>

<!--{subtemplate common/footer}-->