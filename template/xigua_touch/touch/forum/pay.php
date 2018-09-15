<?php exit('xxxxx');?>
<!--{template common/header}-->
<style>.tips .weui-cells__title,.tips .weui-cell{text-align:left;padding-left:0;padding-right: 0}</style>
<form id="payform" method="post" autocomplete="off" action="forum.php?mod=misc&action=pay&paysubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('payform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
<input type="hidden" name="formhash" value="{FORMHASH}" />
<input type="hidden" name="referer" value="{echo dreferer()}" />
<input type="hidden" name="tid" value="$_G[tid]" />
<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
<div class="tip tips">
    <div class="weui-cells__title">{lang pay}</div>

    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>{lang author}</p>
            </div>
            <div class="weui-cell__ft"><a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">$thread[author]</a></div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>{lang price}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</p>
            </div>
            <div class="weui-cell__ft">$thread[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>{lang pay_author_income}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</p>
            </div>
            <div class="weui-cell__ft">$thread[netprice] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>{lang pay_balance}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</p>
            </div>
            <div class="weui-cell__ft">$balance {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</div>
        </div>
    </div>

    <div class="cl">
        <button type="submit" name="paysubmit" class="button2" value="true">{lang submit}</button>
        <button type="button" class="weui-btn weui-btn_mini weui-btn_default" onclick="popup.close();">{lang close}</button>
    </div>
</div>

</form>

<!--{if !empty($_GET['infloat'])}-->
<script type="text/javascript" reload="1">
    function succeedhandle_$_GET['handlekey'](locationhref) {
        location.href = locationhref;
        popup.close();
    }
</script>
<!--{/if}-->

<!--{template common/footer}-->