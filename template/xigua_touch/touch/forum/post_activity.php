<?php exit('xxxxx');?>
<div class="sorttable cl" style="background:transparent;margin-top:12px">
    <table cellspacing="0" cellpadding="0" class="tfm tfs">
    <tr>
      <th>{lang post_event_time}</th>
      <td><div id="certainstarttime" {if $activity['starttimeto']}style="display: none"{/if}>
          <input type="text" name="starttimefrom[0]" id="starttimefrom_0" class="txt_s  datetime" autocomplete="off" value="$activity[starttimefrom]" tabindex="1" />
        </div>
        <div id="uncertainstarttime" {if !$activity['starttimeto']}style="display: none"{/if}>
          <input type="text" name="starttimefrom[1]" id="starttimefrom_1" class="txt_s  mbn datetime" autocomplete="off" value="$activity[starttimefrom]" tabindex="1" />
          <em> ~ </em>
          <input type="text" autocomplete="off" id="starttimeto" name="starttimeto" class="txt_s  datetime" value="{if $activity['starttimeto']}$activity[starttimeto]{/if}" tabindex="1" />
        </div>
        <span class="cl">
        <label for="activitytime">
          <input type="checkbox" id="activitytime" name="activitytime" class="pc" onclick="if(this.checked) {$('#certainstarttime').hide();$('#uncertainstarttime').show();} else {$('#certainstarttime').show();$('#uncertainstarttime').hide();}" value="1" {if $activity['starttimeto']}checked{/if} tabindex="1" />
          {lang activity_starttime_endtime}</label>
        </span>
		<p class="redc">{echo xtl('datetime_format')}2016-01-25</p>
		</td>
    </tr>
    <tr>
      <th>
        <label for="activityplace">{lang activity_space}:</label></th>
      <td><input type="text" name="activityplace" id="activityplace" class="txt_s " value="$activity[place]" tabindex="1" /></td>
    </tr>

    <!--{if $_GET[action] == 'newthread'}-->
    <tr>
      <th><label for="activitycity">{lang activity_city}:</label></th>
      <td><input name="activitycity" id="activitycity" class="txt_s " type="text" tabindex="1" /></td>
    </tr>

    <!--{/if}-->
    <tr>
      <th>
        <label for="activityclass">{lang activiy_sort}:</label></th>
      <td class="hasd cl"><select id="activityclass" name="activityclass" value="$activity[class]" >
          <!--{if $activitytypelist}-->
          <!--{loop $activitytypelist $type}-->
          <option value="$type">$type</option>
          <!--{/loop}-->
          <!--{/if}-->
        </select></td>
    </tr>
    <tr>
      <th><label for="activitynumber">{lang activity_need_member}:</label></th>
      <td><input type="text" name="activitynumber" id="activitynumber" class="txt_s  z" style="width:55px;" onkeyup="checkvalue(this.value, 'activitynumbermessage')" value="$activity[number]" tabindex="1" />
        <em>
        <select name="gender" id="gender" width="38" class="ps">
          <option value="0" {if !$activity['gender']}selected="selected"{/if}>{lang unlimited}</option>
          <option value="1" {if $activity['gender'] == 1}selected="selected"{/if}>{lang male}</option>
          <option value="2" {if $activity['gender'] == 2}selected="selected"{/if}>{lang female}</option>
        </select>
        </em> <span id="activitynumbermessage"></span></td>
    </tr>

    <!--{if $_G['setting']['activityfield']}-->
    <tr>
      <th>{lang optional_data}:</th>
      <td><ul class="xl2 cl">
          <!--{loop $_G['setting']['activityfield'] $key $val}-->
          <li>
            <label for="userfield_$key">
              <input type="checkbox" name="userfield[]" id="userfield_$key" class="pc" value="$key"{if $activity['ufield']['userfield'] && in_array($key, $activity['ufield']['userfield'])} checked="checked"{/if} />
              $val</label>
          </li>
          <!--{/loop}-->
        </ul></td>
    </tr>

    <!--{/if}-->
    <!--{if $_G['setting']['activityextnum']}-->
    <tr>
      <th><label for="extfield">{lang other_data}:</label></th>
      <td><textarea name="extfield" id="extfield" class="pt" cols="50" style="width: 270px;"><!--{if $activity['ufield']['extfield']}-->$activity[ufield][extfield]<!--{/if}--></textarea>
        <br />
        {lang post_activity_message} $_G['setting']['activityextnum'] {lang post_option} </td>
    </tr>

    <!--{/if}-->

    <!--{if $_G['setting']['activitycredit']}-->
    <tr>
      <th><label for="activitycredit">{lang consumption_credit}:</label></th>
      <td><input type="text" name="activitycredit" id="activitycredit" class="txt_s " value="$activity[credit]" />
        {$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]}
        <p class="xg1">{lang user_consumption_money}</p></td>
    </tr>

    <!--{/if}-->
    <tr>
      <th><label for="cost">{lang activity_payment}:</label></th>
      <td><input type="text" name="cost" id="cost" class="txt_s " onkeyup="checkvalue(this.value, 'costmessage')" value="$activity[cost]" tabindex="1" />
        {lang payment_unit} <span id="costmessage"></span></td>
    </tr>
    <tr>
      <th><label for="activityexpiration">{lang post_closing}:</label></th>
      <td class="hasd cl"><span>
        <input type="text" name="activityexpiration" id="activityexpiration" class="txt_s  datetime" autocomplete="off" value="$activity[expiration]" tabindex="1" />
        </span><p class="redc">{echo xtl('datetime_format')}2016-01-25</p></td>
    </tr>

    <!--{if $allowpostimg}-->
    <tr>
      <th>{lang post_topic_image}:</th>
      <td class="pns">
          <button type="button"  class="button2" onclick="uploadWindow($_G['fid'],function (aid, url){activityaid_upload(aid, url)})"><!--{if $activityattach[attachment]}-->{lang update}<!--{else}-->{lang upload}<!--{/if}--></button>
          <input type="hidden" name="activityaid" id="activityaid" {if $activityattach[attachment]}value="$activityattach[aid]" {/if}/>
          <input type="hidden" name="activityaid_url" id="activityaid_url" />
        <div id="activityattach_image" class="mtn">
          <!--{if $activityattach[attachment]}-->
          <a href="$activityattach[url]/$activityattach[attachment]" target="_blank"><img class="" src="$activityattach[url]/{if $activityattach['thumb']}{eval echo getimgthumbname($activityattach['attachment']);}{else}$activityattach[attachment]{/if}" alt="" /></a>
          <!--{/if}-->
        </div></td>
    </tr>

    <!--{/if}-->
    <!--{hook/post_activity_extra}-->

  </table>
</div>

<script type="text/javascript">
function activityaid_upload(aid, url) {
    console.log(url);
    ATTACHORIMAGE = 1;
	$('#activityaid_url').val(url);
    $('#activityaid').val(aid);
    $('#activityattach_image').html('<img src="{$_G['setting']['attachurl']}forum/' + url + '" />');
}

var  UPLOADWINRECALL1 = null;
function uploadWindow(fid, recall, type) {

    type = 'image';
    UPLOADWINRECALL1 = recall;
    $('#upsportfile').load('./forum.php?mod=misc&action=upload&fid=' + fid + '&type=' + type + 'mobile=2')
}

function uploadWindowload1() {

    var str = $('#uploadattachframe')[0].contentWindow.document.body.innerHTML;
    console.log(str);

    if(str == ''){
        return;
    }
    var arr = str.split('|');
    if(arr[0] == 'DISCUZUPLOAD' && arr[2] == 0) {
        UPLOADWINRECALL1(arr[3], arr[5], arr[6]);
    } else {
        var sizelimit = '';
        if(arr[7] == 'ban') {
            sizelimit = '({echo xtl('fujian');})';
        } else if(arr[7] == 'perday') {
            sizelimit = '({echo xtl('bun');} ' + arr[8] + ' {echo xtl('bit');})';
        } else if(arr[7] > 0) {
            sizelimit = '({echo xtl('bun');} ' + arr[7] + ' {echo xtl('bit');})';
        }
        $('#upfileinput1').remove();
        alert(STATUSMSG[arr[2]] + sizelimit);
    }
}
</script>

<div id="upsportfile" style="padding:6px 15px"></div>