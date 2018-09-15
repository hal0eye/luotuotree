<?php exit('xigua_touch');?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<style>.dofixed{position: absolute!important;top: auto!important;}</style>

	<div id="ct" class="ct2 wp cl">
		<div class="mn">
			<!--{if $action != 'create'}-->
				<div class="bm">
					<!--{if $_G['forum']['banner']}-->
					<img class="cl" src="$_G['forum']['banner']" style="width:100%;max-height:80px;display:block" />
					<!--{/if}-->
					<div class="mod-guide weui-flex bm cl" style="height:auto!important;">
						<div class="mod-guide-thumb">
							<img src="$_G[forum][icon]" alt="$_G[forum][name]" width="48" height="48" />
						</div>
						<div class="mod-guide-main" style="height:auto!important;">
							<p class="title">$_G[forum][name]</p>
							<p>
								<!--{if $_G[forum][description]}--><span>$_G[forum][description]</span><!--{/if}-->
							</p>
							<p>
								<span><a href="home.php?mod=spacecp&ac=favorite&type=group&id={$_G[forum][fid]}&handlekey=sharealbumhk_{$_G[forum][fid]}&formhash={FORMHASH}"
								   id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);"
								   title="{lang favorite}" class="fa_fav">{lang favorite}</a></span>
								<!--{if $status == 'isgroupuser' && helper_access::check_module('group')}--><span><a href="javascript:;" onclick="showWindow('invite','misc.php?mod=invite&action=group&id=$_G[fid]')" class="fa_ivt"><strong class="xi2">{lang my_buddylist_invite}</strong></a></span><!--{/if}-->
							</p>
							<p>
								<!--{if $_G['current_grouplevel']['icon']}--><span><img src="$_G[current_grouplevel][icon]" title="{lang group_level}: $_G[current_grouplevel][leveltitle]" class="vm"></span><!--{/if}-->
								<span>{lang credits}: $_G[forum][commoncredits]{lang group_moderator_title}: <!--{eval $i = 1;}--><!--{loop $groupmanagers $manage}--><!--{if $i <= 0}-->, <!--{/if}--><!--{eval $i--;}--><a href="home.php?mod=space&uid=$manage[uid]" target="_blank" class="xi2">$manage[username]</a> <!--{/loop}--></span>
							</p>

							<!--{if $action == 'index' && ($status == 2 || $status == 3 || $status == 5)}-->
							<p>
								<!--{if $_G['forum']['jointype'] == 1}-->
								<span>{lang group_join_type_invite}</span>
								<!--{elseif $_G['forum']['jointype'] == 2}-->
								<span>{lang group_join_type_moderate}</span>
								<!--{else}-->
								<span>{lang group_join_type_free}</span>
								<!--{/if}-->
								<span><!--{if $_G['forum']['gviewperm'] == 0}-->{lang group_perm_member_only}<!--{else}-->{lang group_perm_all_user}<!--{/if}--></span>
							</p>
							<!--{/if}-->
						</div>

						<!--{if $status == 3 || $status == 5 ||  $status == 'isgroupuser'}-->
						<a  class="mod-guide-btn weui-btn weui-btn_mini weui-btn_default ">{lang group_has_joined}</a>
						<!--{elseif helper_access::check_module('group') && $status != 'isgroupuser'}-->
						<a  class="mod-guide-btn button2 " href="forum.php?mod=group&action=join&fid=$_G[fid]">{lang group_join_group}</a>
						<!--{/if}-->
						<!--{if $status != 2 && $status != 3 && $status != 5}-->
						<!--{if helper_access::check_module('group') && $status != 'isgroupuser'}-->
						<a  class="mod-guide-btn button2" href="forum.php?mod=group&action=join&fid=$_G[fid]">{lang group_join_group}</a>
						<!--{/if}-->
						<!--{/if}-->

					</div>

				</div>
				<!--{if $status != 2 && $status != 3}-->
				<!--{eval $ct = 3;}-->
				<!--{if $_G['forum']['ismoderator']}-->
				<!--{eval $ct = 4;}-->
				<!--{/if}-->
				<!--{eval $ctwidth = 100/$ct;}-->
				<ul id="thread_types" class="ttp  cl">
					<ul class="tab4">

						<li {if $action == 'index'}class="xw1 a"{/if}><a style="width:{$ctwidth}%" href="forum.php?mod=group&fid=$_G[fid]#groupnav" title="">{lang home}</a></li>
						<li {if $action == 'list'}class="xw1 a"{/if}><a  style="width:{$ctwidth}%" href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]#groupnav" title="">{lang group_discuss_area}</a></li>
						<li {if $action == 'memberlist' || $action == 'invite'}class="xw1 a"{/if}><a style="width:{$ctwidth}%" href="forum.php?mod=group&action=memberlist&fid=$_G[fid]#groupnav" title="">{lang group_member_list}</a></li>
						<!--{if $_G['forum']['ismoderator']}-->
						<li {if $action == 'manage'}class="xw1 a"{/if}><a style="width:{$ctwidth}%" href="forum.php?mod=group&action=manage&fid=$_G[fid]#groupnav">{lang group_admin}</a></li>
						<!--{/if}-->
					</ul>
				</ul>
				<!--{/if}-->


			<!--{/if}-->
			<!--{if $action == 'index' && $status != 2 && $status != 3}-->
				<!--{subtemplate group/group_index}-->
			<!--{elseif $action == 'list'}-->
				<!--{subtemplate group/group_list}-->
			<!--{elseif $action == 'memberlist'}-->
				<!--{subtemplate group/group_memberlist}-->
			<!--{elseif $action == 'create'}-->
				<!--{subtemplate group/group_create}-->
			<!--{elseif $action == 'invite'}-->
				<!--{subtemplate group/group_invite}-->
			<!--{elseif $action == 'manage'}-->
				<!--{subtemplate group/group_manage}-->
			<!--{/if}-->

		</div>
	</div>


<!--{template common/footer}-->