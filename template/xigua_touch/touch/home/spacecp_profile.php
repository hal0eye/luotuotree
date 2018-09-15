<?php exit('xxxxx'); ?>

<!--{eval $backlist=1;}-->
<!--{template common/header}-->
<style>#td_timeoffset select,p.d {max-width:120px;}.p select{width:50px;margin-right:10px}.tfm{overflow: hidden;display: block;}.tfm th{min-width:90px}input,select{max-width:120px}.tfm td {width: 33%;}td.p {display: none;}</style>
<!--{if $validate}-->
<p class="tbmu mbm">{lang validator_comment}</p>
<form action="member.php?mod=regverify" method="post" autocomplete="off">
    <input type="hidden" value="{FORMHASH}" name="formhash" />
    <table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="tfm">
        <tr>
            <th>{lang validator_remark}</th>
            <td>$validate[remark]</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <th>{lang validator_message}</th>
            <td><input type="text" class="px" name="regmessagenew" value="" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td colspan="2">
                <button type="submit" name="verifysubmit" value="true" class="pn pnc" /><strong>{lang validator_submit}</strong></button>
            </td>
        </tr>
    </table>
    </div></div>
    <div class="appl">
    </div>
    <!--{else}-->
    <!--{if $operation == 'password'}-->
    <script type="text/javascript" src="{$_G[setting][jspath]}register.js?{VERHASH}"></script>
    <div class="weui-cells__title">
        <!--{if !$_G['member']['freeze']}-->
        <!--{if !$_G['setting']['connect']['allow'] || !$conisregister}-->{lang old_password_comment}<!--{elseif $wechatuser}-->{lang wechat_config_newpassword_comment}<!--{else}-->{lang connect_config_newpassword_comment}<!--{/if}-->
        <!--{elseif $_G['member']['freeze'] == 1}-->
        <strong class="xi1">{lang freeze_pw_tips}</strong>
        <!--{elseif $_G['member']['freeze'] == 2}-->
        <strong class="xi1">{lang freeze_email_tips}</strong>
        <!--{/if}-->
    </div>
    <form action="home.php?mod=spacecp&ac=profile" method="post" autocomplete="off">
        <input type="hidden" value="{FORMHASH}" name="formhash" />
        <table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="tfm">
            <!--{if !$_G['setting']['connect']['allow'] || !$conisregister}-->
            <tr>
                <th><span class="rq" title="{lang required}">*</span>{lang old_password}</th>
                <td><input type="password" name="oldpassword" id="oldpassword" class="px" /></td>
            </tr>
            <!--{/if}-->
            <tr>
                <th>{lang new_password}</th>
                <td>
                    <input type="password" name="newpassword" id="newpassword" class="px" />
                    <p class="d" id="chk_newpassword">{lang memcp_profile_passwd_comment}</p>
                </td>
            </tr>
            <tr>
                <th>{lang new_password_confirm}</th>
                <td>
                    <input type="password" name="newpassword2" id="newpassword2"class="px" />
                    <p class="d" id="chk_newpassword2">{lang memcp_profile_passwd_comment}</p>
                </td>
            </tr>
            <tr id="contact"{if $_GET[from] == 'contact'} style="background-color: {$_G['style']['specialbg']};"{/if}>
            <th>{lang email}</th>
            <td>
                <input type="text" name="emailnew" id="emailnew" value="$space[email]" class="px" />
                <p class="d">
                    <!--{if empty($space['newemail'])}-->
                    {lang email_been_active}
                    <!--{else}-->
                    $acitvemessage
                    <!--{/if}-->
                </p>
                <!--{if $_G['setting']['regverify'] == 1 && (($_G['group']['grouptype'] == 'member' && $_G['adminid'] == 0) || $_G['groupid'] == 8) || $_G['member']['freeze']}--><p class="d">{lang memcp_profile_email_comment}</p><!--{/if}-->
            </td>
            </tr>

            <!--{if $_G['member']['freeze'] == 2}-->
            <tr>
                <th>{lang freeze_reason}</th>
                <td>
                    <textarea rows="3" cols="80" name="freezereson" class="pt">$space[freezereson]</textarea>
                    <p class="d" id="chk_newpassword2">{lang freeze_reason_comment}</p>
                </td>
            </tr>
            <!--{/if}-->

            <tr>
                <th>{lang security_question}</th>
                <td>
                    <select name="questionidnew" id="questionidnew">
                        <option value="" selected>{lang memcp_profile_security_keep}</option>
                        <option value="0">{lang security_question_0}</option>
                        <option value="1">{lang security_question_1}</option>
                        <option value="2">{lang security_question_2}</option>
                        <option value="3">{lang security_question_3}</option>
                        <option value="4">{lang security_question_4}</option>
                        <option value="5">{lang security_question_5}</option>
                        <option value="6">{lang security_question_6}</option>
                        <option value="7">{lang security_question_7}</option>
                    </select>
                    <p class="d">{lang memcp_profile_security_comment}</p>
                </td>
            </tr>

            <tr>
                <th>{lang security_answer}</th>
                <td>
                    <input type="text" name="answernew" id="answernew" class="px" />
                    <p class="d">{lang memcp_profile_security_answer_comment}</p>
                </td>
            </tr>
            <!--{if $secqaacheck || $seccodecheck}-->
        </table>
        <!--{eval $sectpl = '<table cellspacing="0" cellpadding="0" class="tfm"><tr><th><sec></th><td><sec><p class="d"><sec></p></td></tr></table>';}-->
        <!--{subtemplate common/seccheck}-->
        <table summary="{lang memcp_profile}" cellspacing="0" cellpadding="0" class="tfm">
            <!--{/if}-->
            <tr>
                <th>&nbsp;</th>
                <td><button type="submit" name="pwdsubmit" value="true" class="pn pnc button" /><strong>{lang save}</strong></button></td>
            </tr>
        </table>
        <input type="hidden" name="passwordsubmit" value="true" />
    </form>
    <script type="text/javascript">
        var strongpw = new Array();
        <!--{if $_G['setting']['strongpw']}-->
        <!--{loop $_G['setting']['strongpw'] $key $val}-->
        strongpw[$key] = $val;
        <!--{/loop}-->
        <!--{/if}-->
        var pwlength = <!--{if $_G['setting']['pwlength']}-->$_G['setting']['pwlength']<!--{else}-->0<!--{/if}-->;
        checkPwdComplexity($('newpassword'), $('newpassword2'), true);
    </script>
    <!--{else}-->
    <!--{hook/spacecp_profile_top}-->
    <ul id="thread_types" class="ttp cl">
        <!--{if $operation != 'verify'}-->
        <!--{loop $profilegroup $key $value}-->
        <!--{if $value[available]}-->
        <li $opactives[$key]><a href="home.php?mod=spacecp&ac=profile&op=$key">$value[title]</a></li>
        <!--{/if}-->
        <!--{/loop}-->
        <!--{if $_G['setting']['allowspacedomain'] && $_G['setting']['domain']['root']['home'] && checkperm('domainlength')}-->
        <li $opactives[domain]><a href="home.php?mod=spacecp&ac=domain">{lang space_domain}</a></li>
        <!--{/if}-->
        <!--{else}-->
        <!--{if $_G[setting][verify]}-->
        <!--{loop $_G['setting']['verify'] $vid $verify}-->
        <!--{if $verify['available'] && (empty($verify['groupid']) || in_array($_G['groupid'], $verify['groupid']))}-->
        <!--{if $vid != 7}-->
        <li $opactives['verify'.$vid]><a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid">$verify['title']</a></li>
        <!--{elseif $_G['setting']['my_app_status'] && $vid == 7}-->
        <li $opactives[videophoto]><a href="home.php?mod=spacecp&ac=videophoto">{lang video_certification}</a></li>
        <!--{/if}-->
        <!--{/if}-->
        <!--{/loop}-->
        <!--{/if}-->
        <!--{/if}-->
        <!--{if $op != 'verify' && !empty($_G['setting']['plugins']['spacecp_profile'])}-->
        <!--{loop $_G['setting']['plugins']['spacecp_profile'] $id $module}-->
        <!--{if !$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])}--><li{if $_GET[id] == $id} class="xw1 a"{/if}><a href="home.php?mod=spacecp&ac=plugin&op=profile&id=$id">$module[name]</a></li><!--{/if}-->
        <!--{/loop}-->
        <!--{/if}-->
    </ul>

    <!--{if $vid}-->

    <div class="weui-cells__title"><!--{if $showbtn}-->{lang spacecp_profile_message1}<!--{else}-->{lang spacecp_profile_message2}<!--{/if}--></div>

    <!--{/if}-->
    <iframe id="frame_profile" name="frame_profile" style="display: none"></iframe>
    <form action="{if $operation != 'plugin'}home.php?mod=spacecp&ac=profile&op=$operation{else}home.php?mod=spacecp&ac=plugin&op=profile&id=$_GET[id]{/if}" method="post" enctype="multipart/form-data" autocomplete="off"{if $operation != 'plugin'} target="frame_profile"{/if} onsubmit="clearErrorInfo();">
    <input type="hidden" value="{FORMHASH}" name="formhash" />
    <!--{if $_GET[vid]}-->
    <input type="hidden" value="$_GET[vid]" name="vid" />
    <!--{/if}-->
    <table cellspacing="0" cellpadding="0" class="tfm" id="profilelist">
        <tr>
            <th>{lang username}</th>
            <td>$_G[member][username]</td>
            <td>&nbsp;</td>
        </tr>
        <!--{loop $settings $key $value}-->
        <!--{if $value[available]}-->
        <tr id="tr_$key">
            <th id="th_$key"><!--{if $value[required]}--><span class="rq" title="{lang required}">*</span><!--{/if}-->$value[title]</th>
            <td id="td_$key">
                $htmls[$key]
            </td>
            <td class="p">
                <!--{if $vid}-->
                <input type="hidden" name="privacy[$key]" value="3" />
                <!--{else}-->
                <select name="privacy[$key]">
                    <option value="0"{if $privacy[$key] == "0"} selected="selected"{/if}>{lang open_privacy}</option>
                    <option value="1"{if $privacy[$key] == "1"} selected="selected"{/if}>{lang friend_privacy}</option>
                    <option value="3"{if $privacy[$key] == "3"} selected="selected"{/if}>{lang secrecy}</option>
                </select>
                <!--{/if}-->
            </td>
        </tr>
        <!--{/if}-->
        <!--{/loop}-->
        <!--{if $allowcstatus && in_array('customstatus', $allowitems)}-->
        <tr>
            <th id="th_customstatus">{lang permission_basic_status}</th>
            <td id="td_customstatus">
                <input type="text" value="$space[customstatus]" name="customstatus" id="customstatus" class="px" />
                <div class="rq mtn" id="showerror_customstatus"></div>
            </td>
            <td>&nbsp;</td>
        </tr>
        <!--{/if}-->
        <!--{if $_G['group']['maxsigsize'] && in_array('sightml', $allowitems)}-->
        <tr>
            <th id="th_sightml">{lang personal_signature}</th>
            <td id="td_sightml">
                <div class="tedt">
                    <div class="area">
                        <textarea rows="3" cols="80" name="sightml" id="sightmlmessage" class="pt" onkeydown="ctrlEnter(event, 'profilesubmitbtn');">$space[sightml]</textarea>
                    </div>
                </div>
                <div id="signhtmlpreview"></div>
                <div id="showerror_sightml" class="rq mtn"></div>
                <script type="text/javascript" src="{$_G[setting][jspath]}bbcode.js?{VERHASH}"></script>
                <script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = 0,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
            </td>
            <td>&nbsp;</td>
        </tr>
        <!--{/if}-->
        <!--{if in_array('timeoffset', $allowitems)}-->
        <tr>
            <th id="th_timeoffset">{lang time_zone}</th>
            <td id="td_timeoffset">
                <!--{eval $timeoffset = array({lang timezone});}-->
                <select name="timeoffset">
                    <!--{loop $timeoffset $key $desc}-->
                    <option value="$key"{if $key==$space[timeoffset]} selected="selected"{/if}>$desc</option>
                    <!--{/loop}-->
                </select>
                <p class="mtn">{lang current_time} : <!--{date($_G[timestamp])}--></p>
                <p class="d">{lang time_zone_message}</p>
            </td>
            <td>&nbsp;</td>
        </tr>
        <!--{/if}-->

        <!--{if $operation == 'contact'}-->
        <tr>
            <th id="th_sightml">Email</th>
            <td id="td_sightml">$space[email]&nbsp;(<a href="home.php?mod=spacecp&ac=profile&op=password&from=contact#contact">{lang modify}</a>)</td>
            <td>&nbsp;</td>
        </tr>
        <!--{/if}-->

        <!--{hook/spacecp_profile_extra}-->
        <!--{if $showbtn}-->
        <tr>
            <th>&nbsp;</th>
            <td colspan="2">
                <input type="hidden" name="profilesubmit" value="true" />
                <button type="submit" name="profilesubmitbtn" id="profilesubmitbtn" value="true" class="pn pnc button" /><strong>{lang save}</strong></button>
                <span id="submit_result" class="rq"></span>
            </td>
        </tr>
        <!--{/if}-->
    </table>
    <!--{hook/spacecp_profile_bottom}-->
</form>
<script type="text/javascript">
    function show_error(fieldid, extrainfo) {
        var elem = __('th_'+fieldid);
        if(elem) {
            elem.className = "rq";
            fieldname = elem.innerHTML;
            extrainfo = (typeof extrainfo == "string") ? extrainfo : "";
            __('showerror_'+fieldid).innerHTML = "{lang check_date_item} " + extrainfo;
            __(fieldid).focus();
        }
    }
    function show_success(message) {
        message = message == '' ? '{lang update_date_success}' : message;
        alert(message);
        top.window.location.href = top.window.location.href;
    }
    function clearErrorInfo() {
        var spanObj = __('profilelist').getElementsByTagName("div");
        for(var i in spanObj) {
            if(typeof spanObj[i].id != "undefined" && spanObj[i].id.indexOf("_")) {
                var ids = explode('_', spanObj[i].id);
                if(ids[0] == "showerror") {
                    spanObj[i].innerHTML = '';
                    __('th_'+ids[1]).className = '';
                }
            }
        }
    }
    function explode(sep, string) {
        return string.split(sep);
    }
</script>
<!--{/if}-->
</div>
</div>
<div class="appl">
</div>
<!--{/if}-->
</div>

<!--{template common/footer}-->
