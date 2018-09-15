<?php exit('xigua_touch');?>
<!--{eval $backlist=1;}-->
<!--{subtemplate common/header}-->
<div class="ct ctpd">
    <form id="attachpayform" method="post" autocomplete="off" action="forum.php?mod=misc&action=attachpay&tid={$_G[tid]}">
            <input type="hidden" name="formhash" value="{FORMHASH}" />
            <input type="hidden" name="referer" value="{echo dreferer()}" />
            <input type="hidden" name="aid" value="$aid" />
            
                <table cellspacing="5" cellpadding="5" class="tfm">
                    <tr>
                        <td>{lang author}</td>
                        <td><a href="home.php?mod=space&uid=$attach[uid]&do=profile" class="xi2">$attach[author]</a></td>                      
                    </tr>
                    <tr>
                        <td>{lang attachment}</td>
                        <td><div style="overflow:hidden">$attach[filename] <!--{if $attach['description']}-->($attach[description])<!--{/if}--></div></td>
                    </tr>
                    <tr>
                        <td>{lang price}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</td>
                        <td>$attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
                    </tr>
                    <!--{if $status != 1}-->
                    <tr>
                        <td>{lang pay_author_income}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</td>
                        <td>$attach[netprice] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
                    </tr>
                    <tr>
                        <td>{lang pay_balance}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</td>
                        <td>$balance {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
                    </tr>
                    <!--{/if}-->
                    <!--{if $status == 1}-->
                    <tr>
                        <td>&nbsp;</td>
                        <td>{lang status_insufficient}</td>
                    </tr>
                    <!--{elseif $status == 2}-->
                    <tr>
                        <td>&nbsp;</td>
                        <td>{lang status_download}, <a href="forum.php?mod=attachment&aid=$aidencode" target="_blank">{lang download}</a></td>
                    </tr>
                    <!--{/if}-->
                    <tr>
                        <td>&nbsp;</td>
                        <td><input name="buyall" type="checkbox" value="yes" /> {lang buy_all_attch}</label></td>
                    </tr>
                </table>
            
           
                <!--{if $status != 1}-->
        <div class="weui-cells myprofile nobg">
            <div class="weui-btn-area mbw">
                <input type="submit" name="paysubmit" id="paysubmit" value="<!--{if $status == 0}-->{lang pay_attachment}<!--{else}-->{lang free_buy}<!--{/if}-->" class="btn_pn weui-btn weui-btn_primary" />

            </div>
        </div>
                <!--{/if}-->
           
    </form>
</div>
<!--{subtemplate common/footer}-->