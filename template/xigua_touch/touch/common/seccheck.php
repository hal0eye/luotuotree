<?php exit('xxxx'); ?>
{eval
	$sechash = 'S'.random(4);
	$sectpl = !empty($sectpl) ? explode("<sec>", $sectpl) : array('<br />',': ','<br />','');	
	$ran = random(5, 1);
}
<!--{if $secqaacheck}-->
<!--{eval
	$message = '';
	$question = make_secqaa();
	$secqaa = lang('core', 'secqaa_tips').$question;
}-->
<!--{/if}-->
<!--{if $sectpl}-->
	<!--{if $secqaacheck}-->

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">$secqaa</label></div>
            <div class="weui-cell__bd">
                <input name="secqaahash" type="hidden" value="$sechash" />
                <input name="secanswer" id="secqaaverify_$sechash" type="text" class="weui-input" />
            </div>
        </div>
    </div>

	<!--{/if}-->
	<!--{if $seccodecheck}-->
    <div class="weui-cells weui-cells_form">
<!--        <div class="weui-cell"></div>-->
        <div class="weui-cell weui-cell_vcode">
            <input name="seccodehash" type="hidden" value="$sechash" />
<!--            <div class="weui-cell__hd"><label class="weui-label">{lang seccode}</label></div>-->
            <div class="weui-cell__bd">
                <input type="text" class="weui-input" style="ime-mode:disabled;" autocomplete="off" value="" id="seccodeverify_$sechash" name="seccodeverify" placeholder="{lang seccode}" fwin="seccode">
            </div>
            <div class="weui-cell__ft">
                <img src="misc.php?mod=seccode&update={$ran}&idhash={$sechash}&mobile=2" class="weui-vcode-img" />
            </div>
        </div>
    </div>

	<!--{/if}-->
<!--{/if}-->
<script type="text/javascript">
	(function() {
		$('.weui-vcode-img').on('click', function() {
			$('#seccodeverify_$sechash').attr('value', '');
			var tmprandom = 'S' + Math.floor(Math.random() * 1000);
			$('.sechash').attr('value', tmprandom);
			$(this).attr('src', 'misc.php?mod=seccode&update={$ran}&idhash='+ tmprandom +'&mobile=2');
		});
	})();
</script>
