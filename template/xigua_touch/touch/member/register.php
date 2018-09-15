<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<!--{eval $dreferer = str_replace('&amp;', '&', dreferer());}-->

<!-- registerbox start -->
<div class="loginbox registerbox">
    <div class="login_from">
        <form method="post" autocomplete="off" name="register" id="registerform"
              action="member.php?mod={$_G[setting][regname]}&mobile=2">
            <input type="hidden" name="regsubmit" value="yes"/>
            <input type="hidden" name="formhash" value="{FORMHASH}"/>
            <input type="hidden" name="referer" value="$dreferer"/>
            <input type="hidden" name="activationauth" value="{if $_GET[action] == 'activation'}$activationauth{/if}"/>
            <input type="hidden" name="agreebbrule" value="$bbrulehash" id="agreebbrule" checked="checked"/>


            <div class="weui-cells mt0">


                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="text" tabindex="1" class="weui-input" autocomplete="off" value=""
                               name="{$_G['setting']['reginput']['username']}" placeholder="{lang registerinputtip}"
                               fwin="login">
                    </div>
                </div>


                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="password" tabindex="2" class="weui-input" value=""
                               name="{$_G['setting']['reginput']['password']}" placeholder="{lang login_password}"
                               fwin="login">
                    </div>
                </div>


                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="password" tabindex="3" class="weui-input" value=""
                               name="{$_G['setting']['reginput']['password2']}" placeholder="{lang registerpassword2}"
                               fwin="login">
                    </div>
                </div>


                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="email" tabindex="4" class="weui-input" autocomplete="off" value=""
                               name="{$_G['setting']['reginput']['email']}" placeholder="{lang registeremail}"
                               fwin="login">
                    </div>
                </div>


                <!--{if empty($invite) && ($_G['setting']['regstatus'] == 2 || $_G['setting']['regstatus'] == 3)}-->
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="text" name="invitecode" autocomplete="off" tabindex="5" class="weui-input"
                               value="" placeholder="{lang invite_code}" fwin="login">
                    </div>
                </div>
                <!--{/if}-->

                <!--{if $_G['setting']['regverify'] == 2}-->
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="text" name="regmessage" autocomplete="off" tabindex="6" class="weui-input"
                               value="" placeholder="{lang register_message}" fwin="login">
                    </div>
                </div>
                <!--{/if}-->

            </div>


            <!--{if $secqaacheck || $seccodecheck}-->
            <!--{subtemplate common/seccheck}-->
            <!--{/if}-->


    </div>

        <div class="btn_login">
            <button tabindex="7" value="true" name="regsubmit" type="submit" class="weui-btn weui-btn_primary formdialog"><span>{lang quickregister}</span></button>
            <!--{if $_G['cache']['plugin']['xigua_login']}-->
                <a href="plugin.php?id=xigua_login:login" class="weui-btn weui-btn_primary"><span>$_G['cache']['plugin']['xigua_login'][wechatword]</span></a>
            <!--{/if}-->
        </div>
    </form>
</div>
<!-- registerbox end -->

<!--{eval updatesession();}-->
<!--{template common/footer}-->
