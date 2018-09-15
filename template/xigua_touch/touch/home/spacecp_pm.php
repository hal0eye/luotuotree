<?php exit('xxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<ul id="thread_types" class="ttp  cl">
    <li class="{if $_GET[do]}xw1 a{/if}"><a style="width:50%" href="home.php?mod=space&do=pm">{lang pm}</a></li>
    <li class="{if $_GET[ac]}xw1 a{/if}"><a style="width:50%" href="home.php?mod=spacecp&ac=pm">{lang send_pm}</a></li>
</ul>

<!--{if $op != ''}-->
<div class="bm_c">{lang user_mobile_pm_error}</div>
<!--{else}-->

<form id="pmform_{$pmid}" name="pmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid&pmid=$pmid&mobile=2" >
	<input type="hidden" name="referer" value="{echo dreferer();}" />
	<input type="hidden" name="pmsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
    <input type="hidden" name="pmsubmit_btn" value="yes" />

<!-- main post_msg_box start -->
<div class="wp">
	<div class="post_msg_from">
        <div class="weui-cells weui-cells_form">
            <!--{if !$touid}-->
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input type="text" value="" tabindex="1" class="weui-input" autocomplete="off" id="username" name="username" placeholder="{lang addressee}">
                </div>
            </div>
            <!--{/if}-->
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" tabindex="2" autocomplete="off" value="" id="sendmessage" name="message" cols="80" rows="5"  placeholder="{lang thread_content}"></textarea>
                </div>
            </div>
        </div>

        <div class="weui-cells myprofile nobg">
            <div class="weui-btn-area mbw">
                <button id="pmsubmit_btn" class="btn_pn weui-btn weui-btn_primary" disable="true"><span>{lang sendpm}</span></button>
            </div>
        </div>
	</div>
</div>
<!-- main postbox start -->
</form>
<script type="text/javascript">
	(function() {
		$('#sendmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
				$('.btn_pn').attr('disable', 'false');
			} else {
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
		var form = $('#pmform_{$pmid}');
		$('#pmsubmit_btn').on('click', function() {
			var obj = $(this);
			if(obj.attr('disable') == 'true') {
				return false;
			}
			$.ajax({
				type:'POST',
				url:form.attr('action') + '&handlekey='+form.attr('id')+'&inajax=1',
				data:form.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				popup.open(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				popup.open('{lang networkerror}', 'alert');
			});
			return false;
			});
	 })();
</script>
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
