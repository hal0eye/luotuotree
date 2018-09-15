<?php exit('xxx'); ?>
<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>

<div class="bt pd2">
<form id="poll" name="poll" method="post" autocomplete="off" action="forum.php?mod=misc&action=votepoll&fid=$_G[fid]&tid=$_G[tid]&pollsubmit=yes{if $_GET[from]}&from=$_GET[from]{/if}&quickforward=yes&mobile=2" >
	<input type="hidden" name="formhash" value="{FORMHASH}" />
    <div class="weui-cells__title">
		<!--{if $multiple}--><strong>{lang poll_multiple}{lang thread_poll}</strong><!--{if $maxchoices}-->: ( {lang poll_more_than} )<!--{/if}--><!--{else}--><strong>{lang poll_single}{lang thread_poll}</strong><!--{/if}--><!--{if $visiblepoll && $_G['group']['allowvote']}--> , {lang poll_after_result}<!--{/if}-->, {lang poll_voterscount}
	</div>

	<!--{if $_G[forum_thread][remaintime]}-->
    <div class="weui-cells__title">
		{lang poll_count_down}:
		<span class="xg1">
		<!--{if $_G[forum_thread][remaintime][0]}-->$_G[forum_thread][remaintime][0] {lang days}<!--{/if}-->
		<!--{if $_G[forum_thread][remaintime][1]}-->$_G[forum_thread][remaintime][1] {lang poll_hour}<!--{/if}-->
		$_G[forum_thread][remaintime][2] {lang poll_minute}
		</span>
    </div>
	<!--{elseif $expiration && $expirations < TIMESTAMP}-->
    <div class="weui-cells__title"><strong>{lang poll_end}</strong>    </div>
	<!--{/if}-->

	<div class="weui-cells weui-cells_checkbox">
		<!--{loop $polloptions $key $option}-->
		<label class="weui-cell weui-check__label" for="option_$key">
			<div class="weui-cell__hd">
				<!--{if $_G['group']['allowvote']}-->
				<input type="$optiontype" class="weui-check" id="option_$key" name="pollanswers[]" value="$option[polloptionid]" {if $_G['forum_thread']['is_archived']}disabled="disabled"{/if}  />
				<i class="weui-icon-checked"></i>
				<!--{/if}-->
                <span>$key.$option[polloption]</span>
			</div>
            <div class="weui-cell__bd">
            </div>

			<div class="weui-cell__ft">
                <!--{if !$visiblepoll}-->
                <span>$option[percent]% <em style="color:#$option[color]">($option[votes])</em></span>
                <!--{/if}-->
			</div>
		</label>
		<!--{/loop}-->

		<!--{if $overt}-->
		<label class="weui-agree">
			<span class="weui-agree__text">
                <a href="javascript:void(0);">{lang poll_msg_overt}</a>
            </span>
		</label>
		<!--{/if}-->


		<!--{if $_G['group']['allowvote'] && !$_G['forum_thread']['is_archived']}-->

		<div class="weui-btn-area">
			<input type="submit" class="weui-btn weui-btn_primary" name="pollsubmit" id="pollsubmit" value="{lang submit}" />
		</div>

		<!--{elseif !$allwvoteusergroup}-->
			<!--{if !$_G['uid']}-->

		<label class="weui-agree">
			<span class="weui-agree__text">
                <a href="javascript:void(0);">{lang poll_msg_allwvote_user}</a>
            </span>
		</label>
			<!--{else}-->

		<label class="weui-agree">
			<span class="weui-agree__text">
                <a href="javascript:void(0);">{lang poll_msg_allwvoteusergroup}</a>
            </span>
		</label>
			<!--{/if}-->
		<!--{elseif !$allowvotepolled}-->

		<label class="weui-agree">
			<span class="weui-agree__text">
                <a href="javascript:void(0);">{lang poll_msg_allowvotepolled}</a>
            </span>
		</label>
		<!--{elseif !$allowvotethread}-->

		<label class="weui-agree">
			<span class="weui-agree__text">
                <a href="javascript:void(0);">{lang poll_msg_allowvotethread}</a>
            </span>
		</label>
		<!--{/if}-->
	</div>

	<div>

	</div>
</form>
</div>
