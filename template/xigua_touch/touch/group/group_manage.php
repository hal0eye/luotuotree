<?php exit('xigua_touch');?>
<div class="banner">
	<nav class="weui-flex">
		<a href="forum.php?mod=group&action=manage&op=group&fid=$_G[fid]"{if $_GET['op'] == 'group'} class="active"{/if}>{lang group_setup}</a>
		<!--{if !empty($groupmanagers[$_G[uid]]) || $_G['adminid'] == 1}-->
		<a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]"{if $_GET['op'] == 'checkuser'} class="active"{/if}>{lang group_member_moderate}</a>
		<a href="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]"{if $_GET['op'] == 'manageuser'} class="active"{/if}>{lang group_member_management}</a>
		<!--{/if}-->
		<!--{if $_G['forum']['founderuid'] == $_G['uid'] || $_G['adminid'] == 1}-->
		<a href="forum.php?mod=group&action=manage&op=threadtype&fid=$_G[fid]"{if $_GET['op'] == 'threadtype'} class="active"{/if}>{lang group_threadtype}</a>
		<a href="forum.php?mod=group&action=manage&op=demise&fid=$_G[fid]"{if $_GET['op'] == 'demise'} class="active"{/if}>{lang group_demise}</a>
		<!--{/if}-->
		<!--{if in_array($_G['adminid'], array(1,2))}-->
		<a  href="forum.php?mod=group&action=recommend&fid=$_G[fid]">{lang group_push_to_forum}</a>
		<!--{/if}-->
	</nav>
</div>
<div class="banner_fix cl"></div>


<!--{if $_GET['op'] == 'group'}-->
	<div class="bm bw0">
		<form enctype="multipart/form-data" action="forum.php?mod=group&action=manage&op=group&fid=$_G[fid]" name="manage" method="post" autocomplete="off">
			<input type="hidden" value="{FORMHASH}" name="formhash" />
            <div class="weui-cells weui-cells_form">

            <!--{if !empty($specialswitch['allowchangename']) && ($_G['uid'] == $_G['forum']['founderuid'] || $_G['adminid'] == 1)}-->
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><strong class="rq ">*</strong>{lang group_name}:</label></div>
                <div class="weui-cell__bd">
                    <input type="text" name="name" id="name" class="weui-input"  tabindex="1" value="$_G[forum][name]" autocomplete="off" tabindex="1" />
                </div>
            </div>
            <!--{/if}-->
					<!--{if !empty($specialswitch['allowchangetype']) && ($_G['uid'] == $_G['forum']['founderuid'] || $_G['adminid'] == 1)}-->
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><strong class="rq ">*</strong>{lang group_category}:</label></div>
                    <div class="weui-cell__bd">

                        <select name="parentid" tabindex="2" class="ps" onchange="ajaxget('forum.php?mod=ajax&action=secondgroup&fupid='+ this.value, 'secondgroup');">
                            <option value="0">{lang choose_please}</option>
                            $groupselect[first]
                        </select>
                        <em id="secondgroup"><!--{if $groupselect['second']}--><select id="fup" name="fup" class="ps" >$groupselect[second]</select><!--{/if}--></em>
                    </div>
                </div>

					<!--{/if}-->

                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" id="descriptionmessage" name="descriptionnew" placeholder="{lang group_description}" value="$_G[forum][descriptionnew]">
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
                            <input type="radio" name="gviewperm" class="weui-check" tabindex="4" value="1" id="x11" $gviewpermselect[1] />
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x12">

                        <div class="weui-cell__bd">
                            <p>{lang group_perm_member_only}</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="gviewperm" class="weui-check" value="0"  id="x12" $gviewpermselect[0]/>
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
                            <input type="radio" name="jointype" class="weui-check" tabindex="4" value="0" id="x13" $jointypeselect[0] />
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x14">

                        <div class="weui-cell__bd">
                            <p>{lang group_join_type_moderate}</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="jointype" class="weui-check" value="2"  id="x14" $jointypeselect[2]/>
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label" for="x15">

                        <div class="weui-cell__bd">
                            <p>{lang group_join_type_invite}</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="jointype" class="weui-check" value="1"  id="x15" $jointypeselect[1]/>
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>


                    <label class="weui-cell weui-check__label" for="x16">

                        <div class="weui-cell__bd">
                            <p>{lang group_close_notice}</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="jointype" class="weui-check" value="-1"  id="x16" $jointypeselect[-1]/>
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>


                </div>
            </div>

                <!--{if $_G['setting']['allowgroupdomain'] && !empty($_G['setting']['domain']['root']['group']) && $domainlength}-->
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label"><strong class="rq ">*</strong>{lang subdomain}:</label></div>
                    <div class="weui-cell__bd">
                        <input type="text" name="domain" id="domain" class="weui-input"  tabindex="1" value="$_G[forum][domain]" autocomplete="off" tabindex="1" />
                    </div>
                </div>
                <div class="weui-cells__tips">{lang group_domain_message}  <!--{if $_G[forum][domain] && $consume}-->{lang group_edit_domain_message}<!--{/if}--></div>
            </div>
                <!--{/if}-->

					<!--{if !empty($_G['group']['allowupbanner']) || $_G['adminid'] == 1}-->

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">{lang group_image}:</label></div>
            <div class="weui-cell__bd">
                <input type="file" name="bannernew" id="bannernew" class="pf" size="25" />

            </div>
        </div>
        <div class="weui-cells__tips"><!--{if $_G['forum']['banner']}-->
            <img style="max-height:80px;max-width:100%" src="$_G[forum][banner]?{TIMESTAMP}" /><br>
            <!--{/if}-->

            <!--{if $_G[setting][group_imgsizelimit]}-->
            {lang group_image_filesize_limit} &nbsp;
            <!--{/if}-->
            {lang group_image_filesize_advise}
        </div>
    </div>
					<!--{/if}-->


    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">{lang group_icon}:</label></div>
            <div class="weui-cell__bd">
                <input type="file" id="iconnew" class="pf vm" size="25" name="iconnew" />
            </div>
        </div>
        <div class="weui-cells__tips">

            <!--{if $_G['forum']['icon']}-->
            <img width="48" height="48" alt="" class="vm" style="margin-right: 1em;" src="$_G[forum][icon]?{TIMESTAMP}" /><br>
            <!--{/if}-->

            {lang group_icon_resize} &nbsp;
            <!--{if $_G[setting][group_imgsizelimit]}-->
            {lang group_image_filesize_limit}
            <!--{/if}-->
        </div>
    </div>

    <div class="weui-btn-area mbw">
        <button type="submit" class="btn_pn weui-btn weui-btn_primary" name="groupmanage" value="1"><strong>{lang submit}</strong></button>
    </div>
		</form>
	</div>
<!--{elseif $_GET['op'] == 'checkuser'}-->
	<!--{if $checkusers}-->
		<p class="tbmu cl none" >
			<span class="y">
				<a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&checkall=2">{lang ignore_all}</a>
				<a href="forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&checkall=1">{lang pass_all}</a>
			</span>
		</p>

<div class="weui-cells">

    <!--{loop $checkusers $uid $user}-->
    <div class="weui-cell">
        <div class="weui-cell__hd"><img src="<!--{echo avatar($user[uid], 'small', true)}-->" style="width:20px;margin-right:5px;display:block" /> </div>
        <div class="weui-cell__bd">
            <p style="font-size:14px;"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a> <span class="xw0">($user['joindateline'])</span></p>
        </div>
        <div class="weui-cell__ft">
            <button type="submit" name="checkusertrue" class="button" value="true" onclick="location.href='forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&uid=$user[uid]&checktype=1'"><em>{lang pass}</em></button>
            <button type="submit" name="checkuserfalse" class="button" value="true" onclick="location.href='forum.php?mod=group&action=manage&op=checkuser&fid=$_G[fid]&uid=$user[uid]&checktype=2'"><em>{lang ignore}</em></button>
        </div>
    </div>
    <!--{/loop}-->
</div>
		<!--{if $multipage}--><div class="pgbox">$multipage</div><!--{/if}-->
	<!--{else}-->
        <div class="weui-cells__title">{lang group_no_member_moderated}</div>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'manageuser'}-->
	<script type="text/javascript">
		function groupManageUser(targetlevel_val) {
			$('#targetlevel').val(targetlevel_val);
			$('#manageuser').submit();
		}
	</script>
	<!--{if $_G['forum']['membernum'] > 1}-->
<form action="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]" method="post">
<div class="search weui-flex">
    <div class="weui-flex__item">
        <input type="text" value="{if $_GET['srchuser']}$_GET[srchuser]{/if}" placeholder="{lang enter_member_user}" size="15" class="input" id="groupsearch" name="srchuser">&nbsp;
    </div>
    <div>
        <button class="button2" type="submit"><span>{lang search}</span></button>
    </div>
</div>
</form>
	<!--{/if}-->
	<form action="forum.php?mod=group&action=manage&op=manageuser&fid=$_G[fid]&manageuser=true" name="manageuser" id="manageuser" method="post" autocomplete="off" class="ptm">
		<input type="hidden" value="{FORMHASH}" name="formhash" />
        <input type="hidden" value="0" name="targetlevel" id="targetlevel" />
		<!--{if $adminuserlist}-->
			<div class="bm">
                <div class="weui-cells__title">{lang group_admin_member}</div>
                <div class="weui-cells">

                    <!--{loop $adminuserlist $user}-->
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><a href="home.php?mod=space&uid=$user[uid]"><img src="<!--{echo avatar($user[uid], 'small', true)}-->" alt="" style="width:20px;margin-right:5px;display:block"></a></div>
                        <div class="weui-cell__bd">
                            <p style="font-size:14px;"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
                        </div>
                        <div class="weui-cell__ft">
                            <!--{if $_G['adminid'] == 1 || ($_G['uid'] != $user['uid'] && ($_G['uid'] == $_G['forum']['founderuid'] || $user['level'] > $groupuser['level']))}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}-->
                        </div>
                    </div>
                    <!--{/loop}-->
                </div>
			</div>
		<!--{/if}-->
		<!--{if $staruserlist || $userlist}-->
			<div class="bm">
                <div class="weui-cells__title">{lang member}</div>
                <div class="weui-cells">
                    <!--{eval $ulist = array_merge($staruserlist, $userlist);}-->
                    <!--{loop $staruserlist $user}-->
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><a href="home.php?mod=space&uid=$user[uid]"><img src="<!--{echo avatar($user[uid], 'small', true)}-->" alt="" style="width:20px;margin-right:5px;display:block"></a></div>
                        <div class="weui-cell__bd">
                            <p style="font-size:14px;"><a href="home.php?mod=space&uid=$user[uid]">$user[username]</a></p>
                        </div>
                        <div class="weui-cell__ft">
                            <!--{if $_G['adminid'] == 1 || $user['level'] > $groupuser['level']}--><input type="checkbox" class="pc" name="muid[{$user[uid]}]" value="$user[level]" /><!--{/if}-->
                        </div>
                    </div>
                    <!--{/loop}-->
                </div>
			</div>
		<!--{/if}-->
		<!--{if $multipage}--><div class="pgbox">$multipage</div><!--{/if}-->
		<div class="cl">
			<!--{loop $mtype $key $name}-->
            	<!--{if $_G['forum']['founderuid'] == $_G['uid'] || $key > $groupuser['level'] || $_G['adminid'] == 1}-->
                <div style="margin:5px 15px;" class="z cl"><button type="button" name="manageuser" value="true" class="button" onclick="groupManageUser('{$key}')"><span>$name</span></button></div>
                <!--{/if}-->
            <!--{/loop}-->
		</div>
	</form>
<!--{elseif $_GET['op'] == 'threadtype'}-->
	<div class="bm bw0">
		<!--{if empty($specialswitch['allowthreadtype'])}-->
        <div class="weui-cells__title">{lang group_level_cannot_do}</div>
		<!--{else}-->
		<script type="text/JavaScript">
			var rowtypedata = [
				[
					[1,'<input type="checkbox" class="pc" disabled="disabled" />', ''],
					[1,'<input type="checkbox" class="pc" name="newenable[]" checked="checked" value="1" />', ''],
					[1,'<input class="px" type="text" size="2" name="newdisplayorder[]" value="0" />'],
					[1,'<input class="px" type="text" size="5" name="newname[]" />']
				],
			];
			var addrowdirect = 0;
			var typenumlimit = $typenumlimit;
			function addrow(obj, type) {
				var table = obj.parentNode.parentNode.parentNode.parentNode;
				if(typenumlimit <= obj.parentNode.parentNode.parentNode.rowIndex - 1) {
					alert('{lang group_threadtype_limit_1}'+typenumlimit+'{lang group_threadtype_limit_2}');
					return false;
				}
				if(!addrowdirect) {
					var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex);
				} else {
					var row = table.insertRow(obj.parentNode.parentNode.parentNode.rowIndex + 1);
				}

				var typedata = rowtypedata[type];
				for(var i = 0; i <= typedata.length - 1; i++) {
					var cell = row.insertCell(i);
					cell.colSpan = typedata[i][0];
					var tmp = typedata[i][1];
					if(typedata[i][2]) {
						cell.className = typedata[i][2];
					}
					tmp = tmp.replace(/\{(\d+)\}/g, function($1, $2) {return addrow.arguments[parseInt($2) + 1];});
					cell.innerHTML = tmp;
				}
				addrowdirect = 0;
			}
		</script>
		<div id="threadtypes">
			<form id="threadtypeform" action="forum.php?mod=group&action=manage&op=threadtype&fid=$_G[fid]" autocomplete="off" method="post" name="threadtypeform">
				<input type="hidden" value="{FORMHASH}" name="formhash" />
				<table cellspacing="0" cellpadding="0" class="tfm vt">
					<tr>
						<th>{lang threadtype_turn_on}:</th>
						<td>
							<label class="lb"><input type="radio" name="threadtypesnew[status]" class="pr" value="1" onclick="$('threadtypes_config').style.display = '';$('threadtypes_manage').style.display = '';" $checkeds[status][1] />{lang yes}</label>
							<label class="lb"><input type="radio" name="threadtypesnew[status]" class="pr" value="0" onclick="$('threadtypes_config').style.display = 'none';$('threadtypes_manage').style.display = 'none';"  $checkeds[status][0] />{lang no}</label>
							<p class="d">{lang threadtype_turn_on_comment}</p>
						</td>
					</tr>
					<tbody id="threadtypes_config" style="display: $display">
						<tr>
							<th>{lang threadtype_required}:</th>
							<td>
								<label class="lb"><input type="radio" name="threadtypesnew[required]" class="pr" value="1" $checkeds[required][1] />{lang yes}</label>
								<label class="lb"><input type="radio" name="threadtypesnew[required]" class="pr" value="0" $checkeds[required][0] />{lang no}</label>
								<p class="d">{lang threadtype_required_force}</p>
							</td>
						</tr>
						<tr>
							<th>{lang threadtype_prefix}:</th>
							<td>
								<label class="lb"><input type="radio" name="threadtypesnew[prefix]" class="pr" value="0" $checkeds[prefix][0] />{lang threadtype_prefix_off}</label>
								<label class="lb"><input type="radio" name="threadtypesnew[prefix]" class="pr" value="1" $checkeds[prefix][1] />{lang threadtype_prefix_on}</label>
								<p class="d">{lang threadtype_prefix_comment}</p>
							</td>
						</tr>
					</tbody>
				</table>
				<div id="threadtypes_manage" style="display: $display">
                    <div class="weui-cells__title">{lang threadtype}</div>
					<table cellspacing="0" cellpadding="0" class="tfm">
						<thead>
							<tr>
								<th>{lang delete}</th>
								<th>{lang enable}</th>
								<th>{lang displayorder}</th>
								<th>{lang threadtype_name}</th>
							</tr>
						</thead>
						<!--{if $threadtypes}-->
							<!--{loop $threadtypes $val}-->
							<tbody>
								<tr>
									<th><input type="checkbox" class="pc" name="threadtypesnew[options][delete][]" value="{$val[typeid]}" /></th>
									<th><input type="checkbox" class="pc" name="threadtypesnew[options][enable][{$val[typeid]}]" value="1" class="pc" $val[enablechecked] /></th>
									<th><input type="text" name="threadtypesnew[options][displayorder][{$val[typeid]}]" class="px" size="2" value="$val[displayorder]" /></th>
									<th><input type="text" name="threadtypesnew[options][name][{$val[typeid]}]" class="px" size="5" value="$val[name]" /></th>
								</tr>
							</tbody>
							<!--{/loop}-->
						<!--{/if}-->
						<tr>
							<th colspan="4"><a href="javascript:;" class="button" onclick="addrow(this, 0)">{lang threadtype_add}</a></th>
						</tr>
					</table>
				</div>
                <div class="weui-btn-area mbw">
				<button type="submit" class="btn_pn weui-btn weui-btn_primary" name="groupthreadtype" value="1"><strong>{lang submit}</strong></button>
                </div>
			</form>
		</div>
		<!--{/if}-->
	</div>
<!--{elseif $_GET['op'] == 'demise'}-->
	<div class="bm bw0">
		<!--{if $groupmanagers}-->
        <div class="weui-cells__title">{lang group_demise_comment}</div>
        <div class="weui-cells__title">{lang group_demise_notice}</div>

			<form action="forum.php?mod=group&action=manage&op=demise&fid=$_G[fid]" name="groupdemise" method="post" class="exfm">
				<input type="hidden" value="{FORMHASH}" name="formhash" />
				<table cellspacing="0" cellpadding="0" class="tfm vt">
					<tr>
						<th>{lang transfer_group_to}:</th>
						<td>
							<ul class="ml mls cl">
								<!--{loop $groupmanagers $user}-->
								<li style="margin:5px 0" class="cl">
                                    <img src="<!--{echo avatar($user[uid], 'small', true)}-->" class="vm" style="margin-right:5px" />
                                    $user[username]
                                    <!--{if $user['uid'] != $_G['uid']}--><input type="radio" class=" pr vm" name="suid" value="$user[uid]" /><!--{/if}-->
								</li>
								<!--{/loop}-->
							</ul>
						</td>
					</tr>
					<tr>
						<th>{lang group_input_password}</th>
						<td><input type="password" name="grouppwd" class="px p_fre" /></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<button type="submit" name="groupdemise" class="pn pnc button" value="1"><strong>{lang submit}</strong></button>
						</td>
					</tr>
				</table>
			</form>
		<!--{else}-->
			<p class="emp">{lang group_no_admin_member}</p>
		<!--{/if}-->
	</div>
<!--{/if}-->