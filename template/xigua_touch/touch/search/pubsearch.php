<?php exit('xxxx'); ?>
<!--{if !empty($srchtype)}-->
<input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
<div class="search weui-flex">
    <div class="weui-flex__item">
    <input value="$keyword" autocomplete="off" class="input" name="srchtxt" id="scform_srchtxt" value="" placeholder="{lang searchthread}">
    </div>
    <div>
    <input type="hidden" name="searchsubmit" value="yes">
    <input type="submit" value="{lang search}" class="button2" id="scform_submit">
    </div>
</div>
