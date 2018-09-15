<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<!--{eval $loginhash = 'L'.random(4);}-->

<!-- userinfo start -->
<div class="loginbox <!--{if $_GET[infloat]||$_GET[inajax]}-->login_pop<!--{/if}-->">
		<form id="loginform" method="post" action="member.php?mod=logging&action=login&loginsubmit=yes&loginhash=$loginhash&mobile=2" onsubmit="{if $_G['setting']['pwdsafety']}pwmd5('password3_$loginhash');{/if}" >
		<input type="hidden" name="formhash" id="formhash" value='{FORMHASH}' />
		<input type="hidden" name="referer" id="referer" value="<!--{if dreferer()}-->{echo dreferer()}<!--{else}-->forum.php?mobile=2<!--{/if}-->" />
		<input type="hidden" name="fastloginfield" value="username">
		<input type="hidden" name="cookietime" value="2592000">
		<!--{if $auth}-->
			<input type="hidden" name="auth" value="$auth" />
		<!--{/if}-->
	<div class="login_from">

		<div class="weui-cells weui-cells_form  mt0" >
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<input type="text" value="" tabindex="1" class=" p_fre weui-input" size="30" autocomplete="off" value="" name="username" placeholder="{lang inputyourname}" fwin="login">
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<input type="password" tabindex="2" class=" p_fre weui-input" size="30" value="" name="password" placeholder="{lang login_password}" fwin="login">
				</div>
			</div>
			<div class="weui-cell" style="padding-top:0;padding-bottom:0">
				<div class="weui-cell__bd">
					<select id="questionid_{$loginhash}" name="questionid" class="sel_list weui-select">
						<option value="0" selected="selected">{lang security_question}</option>
						<option value="1">{lang security_question_1}</option>
						<option value="2">{lang security_question_2}</option>
						<option value="3">{lang security_question_3}</option>
						<option value="4">{lang security_question_4}</option>
						<option value="5">{lang security_question_5}</option>
						<option value="6">{lang security_question_6}</option>
						<option value="7">{lang security_question_7}</option>
					</select>
				</div>
			</div>
			<div class="weui-cell answerli" style="display:none;">
				<div class="weui-cell__bd">
					<input type="text" name="answer" id="answer_{$loginhash}" class=" p_fre weui-input" size="30" placeholder="{lang security_a}">
				</div>
			</div>

		</div>


		<!--{if $seccodecheck}-->
		<!--{subtemplate common/seccheck}-->
		<!--{/if}-->
	</div>

			<div class="btn_login">
				<button tabindex="3" value="true" name="submit" type="submit" class="weui-btn weui-btn_primary formdialog">{lang login}</button>
			</div>
	</form>


	<!--{if $_G['setting']['connect']['allow'] && !$_G['setting']['bbclosed']}-->
	<div class="btn_qqlogin"><a class="bu weui-btn weui-btn_warn qqblue" href="$_G[connect][login_url]&statfrom=login_simple">{lang qqconnect:connect_mobile_login}</a></div>
	<!--{/if}-->
	<!--{if $_G['setting']['regstatus']}-->
	<p class="reg_link"><a href="member.php?mod={$_G[setting][regname]}">{lang noregister}</a></p>
	<!--{/if}-->
	<!--{hook/logging_bottom_mobile}-->
</div>
<!-- userinfo end -->

<!--{if $_G['setting']['pwdsafety']}-->
	<script type="text/javascript" src="{$_G['setting']['jspath']}md5.js?{VERHASH}" reload="1"></script>
<!--{/if}-->
<!--{eval updatesession();}-->

<script type="text/javascript">
	(function() {
		$(document).on('change', '.sel_list', function() {
			var obj = $(this);
			$('.span_question').text(obj.find('option:selected').text());
			if(obj.val() == 0) {
				$('.answerli').css('display', 'none');
			} else {
				$('.answerli').css('display', 'block');
			}
		});
	 })();
</script>
<!--{template common/footer}-->
