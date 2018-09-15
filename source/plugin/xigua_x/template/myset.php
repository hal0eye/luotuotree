<?php exit('xxxx'); ?>

<form method="post" autocomplete="off" action="">
    <input type="hidden" name="formhash" value="{FORMHASH}" />

    <p class="tbmu mbm">{lang xigua_x:you}</p>
    <table cellspacing="0" cellpadding="0" class="tfm">

        <!--{loop $setar $k $v}-->
        <tr>
            <th align="right">{eval echo lang('plugin/xigua_x', $v);}</th>
            <td align="left">
                <select name="my[$v]">
                    <option value="0" <!--{if !$opt[$v]}-->selected<!--{/if}--> >{lang xigua_x:yes}</option>
                    <option value="1" <!--{if $opt[$v]}-->selected<!--{/if}-->>{lang xigua_x:no}</option>
                </select>
            </td>
        </tr>
        <!--{/loop}-->
        <tr>
            <th>&nbsp;</th>
            <td><button type="submit" name="privacysubmit" value="true" class="pn pnc" /><strong>{lang save}</strong></button></td>
        </tr>
    </table>

</form>