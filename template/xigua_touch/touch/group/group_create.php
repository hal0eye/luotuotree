<?php exit('xigua_touch');?>
<div class="bm bml" id="main_messaqge">
	<div class="weui-cells__title">{lang group_create_new} <!--{if $_G['setting']['groupmod']}-->&nbsp;&nbsp;&nbsp;({lang group_create_mod})<!--{/if}--></div>
	<div class="bm_c">
		<form method="post" autocomplete="off" name="groupform" id="groupform" class="s_clear" onsubmit="checkCategory();ajaxpost('groupform', 'returnmessage4', 'returnmessage4', 'onerror');return false;" action="forum.php?mod=group&action=create">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="referer" value="{echo dreferer()}" />
			<input type="hidden" name="handlekey" value="creategroup" />

			<div class="weui-cells weui-cells_form">
				<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label"><strong class="rq ">*</strong>{lang group_name}:</label></div>
					<div class="weui-cell__bd">
						<input type="text" name="name" id="name" class="weui-input"  tabindex="1" value="" autocomplete="off" onBlur="checkgroupname()" tabindex="1" />
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label"><strong class="rq ">*</strong>{lang group_category}:</label></div>
					<div class="weui-cell__bd">

						<select name="parentid" tabindex="2" class="ps" onchange="ajaxget('forum.php?mod=ajax&action=secondgroup&fupid='+ this.value, 'secondgroup');">
							<option value="0">{lang choose_please}</option>
							$groupselect[first]
						</select>
						<em id="secondgroup"></em>
					</div>
				</div>
				<div class="weui-cell">
					<div class="weui-cell__bd">
						<input class="weui-input" type="text" id="descriptionmessage" name="descriptionnew" placeholder="{lang group_description}">
					</div>
				</div>
			</div>

			<div class="weui-cells__title">{lang group_perm_visit}</div>
			<div class="weui-cells weui-cells_form">

				<div class="weui-cells weui-cells_radio">
					<label class="weui-cell weui-check__label" for="x11">
						<div class="weui-cell__bd">
							<p>{lang group_perm_all_user}</p>
						</div>
						<div class="weui-cell__ft">
							<input type="radio" name="gviewperm" class="weui-check" tabindex="4" value="1" id="x11" checked="checked" />
							<span class="weui-icon-checked"></span>
						</div>
					</label>
					<label class="weui-cell weui-check__label" for="x12">

						<div class="weui-cell__bd">
							<p>{lang group_perm_member_only}</p>
						</div>
						<div class="weui-cell__ft">
							<input type="radio" name="gviewperm" class="weui-check" value="0"  id="x12"/>
							<span class="weui-icon-checked"></span>
						</div>
					</label>
				</div>

			</div>

			<div class="weui-cells__title">{lang group_join_type}</div>
			<div class="weui-cells weui-cells_form">

				<div class="weui-cells weui-cells_radio">
					<label class="weui-cell weui-check__label" for="x13">
						<div class="weui-cell__bd">
							<p>{lang group_join_type_free}</p>
						</div>
						<div class="weui-cell__ft">
							<input type="radio" name="jointype" class="weui-check" tabindex="4" value="0" id="x13" checked="checked" />
							<span class="weui-icon-checked"></span>
						</div>
					</label>
					<label class="weui-cell weui-check__label" for="x14">

						<div class="weui-cell__bd">
							<p>{lang group_join_type_moderate}</p>
						</div>
						<div class="weui-cell__ft">
							<input type="radio" name="jointype" class="weui-check" value="2"  id="x14"/>
							<span class="weui-icon-checked"></span>
						</div>
					</label>
					<label class="weui-cell weui-check__label" for="x15">

						<div class="weui-cell__bd">
							<p>{lang group_join_type_invite}</p>
						</div>
						<div class="weui-cell__ft">
							<input type="radio" name="jointype" class="weui-check" value="1"  id="x15"/>
							<span class="weui-icon-checked"></span>
						</div>
					</label>
				</div>

			</div>
			<div class="weui-btn-area mbw">
				<input type="hidden" name="createsubmit" value="true"><button type="submit" class="btn_pn weui-btn weui-btn_primary" tabindex="6"><strong>{lang create}</strong></button>
			</div>

            <!--{if $_G['group']['buildgroupcredits']}--><div class="weui-cells__tips"><strong class="rq">{lang group_create_buildcredits} $_G['group']['buildgroupcredits'] $_G['setting']['extcredits'][$creditstransextra]['unit']{$_G['setting']['extcredits'][$creditstransextra]['title']}</strong></div><!--{/if}-->

		</form>
	</div>
</div>
<script type="text/javascript">
	function checkgroupname() {
		var groupname = $('#name').val();
		ajaxget('forum.php?mod=ajax&forumcheck=1&infloat=creategroup&handlekey=creategroup&action=checkgroupname&groupname=' + groupname, 'groupnamecheck');
	}
	function checkCategory(){
		var groupcategory = ($('#fup').val());
		if(groupcategory == ''){
			alert('{lang group_create_selete_categroy}');
			return false;
		}
	}
	<!--{if $_GET['fupid']}-->
			ajaxget('forum.php?mod=ajax&action=secondgroup&fupid=$_GET[fupid]<!--{if $_GET[groupid]}-->&groupid=$_GET[groupid]<!--{/if}-->', 'secondgroup');
	<!--{/if}-->
	if($('#name')) {
		$('#name').focus();
	}
</script>