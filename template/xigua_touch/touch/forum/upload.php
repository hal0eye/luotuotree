<?php exit;?> 
<div class="post_upload" id="upfileinput1">
	<div class="c">
		<form id="uploadform" class="uploadform ptm pbm" method="post" autocomplete="off" target="uploadattachframe" action="misc.php?mod=swfupload&operation=upload&type=$type&inajax=yes&infloat=yes&simple=2" enctype="multipart/form-data">
			<input type="hidden" name="handlekey" value="upload" />
			<input type="hidden" name="uid" value="$_G['uid']">
			<input type="hidden" name="hash" value="{echo md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])}">
			<div class="filebtn">
				<input type="file" name="Filedata" id="filedata1" class="pf cur1" size="1" onchange="return submitbysort();" />
			</div>
		</form>
		<p class="xg1 mtn">
			<!--{if $type == 'image'}-->{lang attachment_allow_exts}: <span class="xi1">$imgexts</span><!--{elseif $_G['group']['attachextensions']}-->{lang attachment_allow_exts}: <span class="xi1">{$_G['group']['attachextensions']}</span><!--{/if}-->
		</p>
		<iframe name="uploadattachframe" id="uploadattachframe" style="display: none;" onload="uploadWindowload1();"></iframe>
	</div>
</div>

<script>
    function submitbysort(){
        $('#uploadform')[0].submit();
        $('#upfileinput1').hide();
        return false;
    }
</script>