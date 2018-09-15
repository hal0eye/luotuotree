<?php exit('xxxx');?>

<script type="text/javascript">
    var allowpostattach = parseInt('{$_G['group']['allowpostattach']}');
    var allowpostimg = parseInt('$allowpostimg');
    var pid = parseInt('$pid');
    var tid = parseInt('$_G[tid]');
    var extensions = '{$_G['group']['attachextensions']}';
    var imgexts = '$imgexts';
    var postminchars = parseInt('$_G['setting']['minpostsize']');
    var postmaxchars = parseInt('$_G['setting']['maxpostsize']');
    var disablepostctrl = parseInt('{$_G['group']['disablepostctrl']}');
    var seccodecheck = parseInt('<!--{if $seccodecheck}-->1<!--{else}-->0<!--{/if}-->');
    var secqaacheck = parseInt('<!--{if $secqaacheck}-->1<!--{else}-->0<!--{/if}-->');
    var typerequired = parseInt('{$_G[forum][threadtypes][required]}');
    var sortrequired = parseInt('{$_G[forum][threadsorts][required]}');
    var special = parseInt('$special');
    var isfirstpost = <!--{if $isfirstpost}-->1<!--{else}-->0<!--{/if}-->;
    var allowposttrade = parseInt('{$_G['group']['allowposttrade']}');
    var allowpostreward = parseInt('{$_G['group']['allowpostreward']}');
    var allowpostactivity = parseInt('{$_G['group']['allowpostactivity']}');
    var sortid = parseInt('$sortid');
    var special = parseInt('$special');
    var fid = $_G['fid'];
    var postaction = '{$_GET['action']}';
    var ispicstyleforum = <!--{if $_G['forum']['picstyle']}-->1<!--{else}-->0<!--{/if}-->;
</script>
<!--{if $_GET[action] == 'edit'}--><!--{eval $editor[value] = $postinfo[message];}--><!--{else}--><!--{eval $editor[value] = $message;}--><!--{/if}-->

<script type="text/javascript">
    var forum_optionlist = <!--{if $forum_optionlist}-->'$forum_optionlist'<!--{else}-->''<!--{/if}-->;
</script>
<!--{template common/threadsort_js}-->

<input type="hidden" name="selectsortid" size="45" value="$_G['forum_selectsortid']" />

<div class="page__bd">
    <!--{if $_G['forum']['threadsorts']['description'][$_G['forum_selectsortid']]}-->
    <div class="weui-cells__title">$_G[forum][threadsorts][description][$_G[forum_selectsortid]]</div>
    <!--{/if}-->

    <div class="weui-cells">

        <!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">{lang valid_before}</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" name="typeexpiration" tabindex="1" id="typeexpiration">
                    <option value="259200">{lang three_days}</option>
                    <option value="432000">{lang five_days}</option>
                    <option value="604800">{lang seven_days}</option>
                    <option value="2592000">{lang one_month}</option>
                    <option value="7776000">{lang three_months}</option>
                    <option value="15552000">{lang half_year}</option>
                    <option value="31536000">{lang one_year}</option>
                </select>
            </div>
        </div>
        <!--{/if}-->

    </div>

</div>


<!--{if $_G['forum_typetemplate']}-->
{$_G[forum_typetemplate]}
<!--{else}-->
<div class="sorttable" style="margin-bottom:12px">
<table cellspacing="0" cellpadding="0" class="tfm tfs">
    <!--{loop $_G['forum_optionlist'] $optionid $option}-->
    <tr>
        <th class="ptm pbm ">$option[title]<!--{if $option['required']}--><span class="rq">*</span><!--{/if}--></th>
        <td class="ptm pbm ">
            <div id="select_$option[identifier]">
                <!--{if in_array($option['type'], array('number', 'text', 'email', 'calendar', 'image', 'url', 'range', 'upload', 'range'))}-->
                <!--{if $option['type'] == 'calendar'}-->
                <input type="date" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" tabindex="1" size="$option[inputsize]" value="$option[value]" $option[unchangeable] class="px"/>
                <!--{elseif $option['type'] == 'image'}-->
                <!--{if !($option[unchangeable] && $option['value'])}-->
                <button type="button" class="button2" onclick="uploadWindow($_G['fid'],function (aid, url){sortaid_{$option[identifier]}_upload(aid, url)})"><em><!--{if $option['value']}-->{lang update}<!--{else}-->{lang upload}<!--{/if}--></em></button>
                <input type="hidden" name="typeoption[{$option[identifier]}][aid]" value="$option[value][aid]" id="sortaid_{$option[identifier]}" />
                <input type="hidden" name="sortaid_{$option[identifier]}_url" id="sortaid_{$option[identifier]}_url" />
                <!--{if $option[value]}--><input type="hidden" name="oldsortaid[{$option[identifier]}]" value="$option[value][aid]" tabindex="1" /><!--{/if}-->
                <input type="hidden" name="typeoption[{$option[identifier]}][url]" id="sortattachurl_{$option[identifier]}" {if $option[value][url]}value="$option[value][url]"{/if} tabindex="1" />
                <!--{/if}-->
                <div id="upsportfile"></div>

                <div id="sortattach_image_{$option[identifier]}" class="ptn">
                    <!--{if $option['value']['url']}-->
                    <a href="$option[value][url]" target="_blank"><img class="spimg" src="$option[value][url]" alt="" /></a>
                    <!--{/if}-->
                </div>
                <script type="text/javascript" reload="1">
                    function sortaid_{$option[identifier]}_upload(aid, url) {
                        ___('sortaid_{$option[identifier]}_url').value = url;
                        updatesortattach(aid, url, '{$_G['setting']['attachurl']}forum', '{$option[identifier]}');
                    }
                </script>
                <!--{else}-->
                <input type="text" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" class="px" tabindex="1" size="$option[inputsize]" onBlur="checkoption('$option[identifier]', '$option[required]', '$option[type]'{if $option[maxnum]}, '$option[maxnum]'{else}, '0'{/if}{if $option[minnum]}, '$option[minnum]'{else}, '0'{/if}{if $option[maxlength]}, '$option[maxlength]'{/if})" value="{if $_G['tid']}$option[value]{else}{if $member_profile[$option['profile']]}$member_profile[$option['profile']]{else}$option['defaultvalue']{/if}{/if}" $option[unchangeable] />
                <!--{/if}-->
                <!--{elseif in_array($option['type'], array('radio', 'checkbox', 'select'))}-->
                <!--{if $option[type] == 'select'}-->
                <!--{loop $option['value'] $selectedkey $selectedvalue}-->
                <!--{if $selectedkey}-->
                <script type="text/javascript">
                    changeselectthreadsort('$selectedkey', $optionid, 'update');
                </script>
                <!--{else}-->
                <select tabindex="1" onchange="changeselectthreadsort(this.value, '$optionid');checkoption('$option[identifier]', '$option[required]', '$option[type]')" $option[unchangeable] class="ps">
                    <option value="0">{lang please_select}</option>
                    <!--{loop $option['choices'] $id $value}-->
                    <!--{if !$value[foptionid]}-->
                    <option value="$id">$value[content] <!--{if $value['level'] != 1}-->&raquo;<!--{/if}--></option>
                    <!--{/if}-->
                    <!--{/loop}-->
                </select>
                <!--{/if}-->
                <!--{/loop}-->
                <!--{if !is_array($option['value'])}-->
                <select tabindex="1" onchange="changeselectthreadsort(this.value, '$optionid');checkoption('$option[identifier]', '$option[required]', '$option[type]')" $option[unchangeable] class="ps">
                    <option value="0">{lang please_select}</option>
                    <!--{loop $option['choices'] $id $value}-->
                    <!--{if !$value[foptionid]}-->
                    <option value="$id">$value[content] <!--{if $value['level'] != 1}-->&raquo;<!--{/if}--></option>
                    <!--{/if}-->
                    <!--{/loop}-->
                </select>
                <!--{/if}-->
                <!--{elseif $option['type'] == 'radio'}-->
                <ul class="xl2">
                    <!--{loop $option['choices'] $id $value}-->
                    <li><label><input type="radio" name="typeoption[{$option[identifier]}]" id="typeoption_$option[identifier]" class="weui-agree__checkbox" tabindex="1" onclick="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$id" $option['value'][$id] $option[unchangeable] class="pr"> $value</label></li>
                    <!--{/loop}-->
                </ul>
                <!--{elseif $option['type'] == 'checkbox'}-->
                <ul class="xl2">
                    <!--{loop $option['choices'] $id $value}-->
                    <li><label><input type="checkbox" name="typeoption[{$option[identifier]}][]" id="typeoption_$option[identifier]"  class="weui-agree__checkbox" tabindex="1" onclick="checkoption('$option[identifier]', '$option[required]', '$option[type]')" value="$id" $option['value'][$id][$id] $option[unchangeable] class="pc"> $value</label></li>
                    <!--{/loop}-->
                </ul>
                <!--{/if}-->
                <!--{elseif in_array($option['type'], array('textarea'))}-->
                <textarea name="typeoption[{$option[identifier]}]" tabindex="1" id="typeoption_$option[identifier]" rows="$option[rowsize]" onBlur="checkoption('$option[identifier]', '$option[required]', '$option[type]', 0, 0{if $option[maxlength]}, '$option[maxlength]'{/if})" $option[unchangeable] class="pt">$option[value]</textarea>
                <!--{/if}-->
                $option[unit]
            </div>
            <!--{if $option['maxnum'] || $option['minnum'] || $option['maxlength'] || $option['unchangeable'] || $option[description]}-->
            <div class="d">
                <!--{if $option['maxnum']}-->
                {lang maxnum} $option[maxnum]&nbsp;
                <!--{/if}-->
                <!--{if $option['minnum']}-->
                {lang minnum} $option[minnum]&nbsp;
                <!--{/if}-->
                <!--{if $option['maxlength']}-->
                {lang maxlength} $option[maxlength]&nbsp;
                <!--{/if}-->
                <!--{if $option['unchangeable']}-->
                {lang unchangeable}&nbsp;
                <!--{/if}-->
                <!--{if $option[description]}-->
                $option[description]
                <!--{/if}-->
            </div>
            <!--{/if}-->
            <div id="check{$option[identifier]}"></div>
        </td>
    </tr>
    <!--{/loop}-->
</table>
</div>
<!--{/if}-->

<script type="text/javascript" reload="1">
    var CHECKALLSORT = false;
    function mb_strlen(str) {
        var len = 0;
        for(var i = 0; i < str.length; i++) {
            len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
        }
        return len;
    }

    function warning(obj, msg) {
        obj.style.display = '';
        obj.innerHTML = '<img src="{IMGDIR}/check_error.gif" width="16" height="16" class="vm" /> ' + msg;
        obj.className = "warning";
        if(CHECKALLSORT) {
            alert(msg);
        }
    }
    var EXTRAFUNC = [];
    EXTRAFUNC['validator'] = [];

    EXTRAFUNC['validator']['special'] = 'validateextra';
    function validateextra() {
        CHECKALLSORT = true;
        <!--{loop $_G['forum_optionlist'] $optionid $option}-->
        if(!checkoption('$option[identifier]', '$option[required]', '$option[type]')) {
            return false;
        }
        <!--{/loop}-->
        return true;
    }

    <!--{if $_G['forum']['threadsorts']['expiration'][$_G['forum_selectsortid']]}-->
//    simulateSelect('typeexpiration');
    <!--{/if}-->
    var  UPLOADWINRECALL1 = null;
    function uploadWindow(fid, recall, type) {

        type = 'image';
        UPLOADWINRECALL1 = recall;
        $('#upsportfile').load('./forum.php?mod=misc&action=upload&fid=' + fid + '&type=' + type + 'mobile=2')
    }

    function uploadWindowload1() {

        var str = ___('uploadattachframe').contentWindow.document.body.innerHTML;
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

    function showError(msg) {
        var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
        msg = msg.replace(p, '');
        if(msg !== '') {
            $('#upfileinput1').remove();
            alert(msg);
        }
    }

    function updatesortattach(aid, url, attachurl, identifier) {
        ___('sortaid_' + identifier).value = aid;
        ___('sortattachurl_' + identifier).value = attachurl + '/' + url;
        ___('sortattach_image_' + identifier).innerHTML = '<img src="' + attachurl + '/' + url + '" class="spimg" />';
        console.log('sortattach_image_' + identifier);
        console.log('<img src="' + attachurl + '/' + url + '" class="spimg" />');
        $('#upfileinput1').remove();
        ATTACHORIMAGE = 1;
    }
</script>