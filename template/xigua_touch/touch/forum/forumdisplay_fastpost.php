<?php exit('xxx'); ?>
<div class="cl fastpostbox pop in">

    <form method="post" autocomplete="off" id="fastpostform" action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&extra=$_GET[extra]&replysubmit=yes&mobile=2">
    <input type="hidden" name="formhash" value="{FORMHASH}" />

        <div class="fastpost_title weui-flex">
            <a onclick="return hideFastform();" href="javascript:;">{echo xtl('quxiao');}</a>
            <div class="weui-flex__item">{echo xtl('fabuhui');}</div>
            <a type="button" class="fastpost_btn" name="replysubmit" id="fastpostsubmit">{lang reply}</a>
        </div>

        <div class="fastpost post_from">
            <div class="weui-cells weui-cells_form mt0">

                <!--{if $_G[forum_thread][special] == 5 && empty($firststand)}-->
                <div class="weui-cell weui-cell_select">
                    <div class="weui-cell__bd">
                        <select class="weui-select" id="stand" name="stand" >
                            <option value="">{lang debate_viewpoint}</option>
                            <option value="0">{lang debate_neutral}</option>
                            <option value="1">{lang debate_square}</option>
                            <option value="2">{lang debate_opponent}</option>
                        </select>
                    </div>
                </div>
                <!--{/if}-->


                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea class="weui-textarea" name="message" id="needmessage" placeholder="{lang send_reply_fast_tip}" rows="6"></textarea>
                    </div>
                </div>


                <div class="weui-cell" id="imglist-box">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">

                            <ul id="imglist" class="post_imglist cl">

                                <li>
                                    <div class="weui-uploader__input-box">
                                        <input class="weui-uploader__input" type="file" name="Filedata" id="filedata">
                                    </div>
                                </li>
                            </ul>


                        </div>
                    </div>
                </div>
            </div>


            <!--{if $secqaacheck || $seccodecheck}--><!--{subtemplate common/seccheck}--><!--{/if}-->

            <!--{template forum/postin}-->

            <!--{hook/viewthread_fastpost_button_mobile}-->
        </div>
    </form>
</div>
<script type="text/javascript">
	(function() {
		var form = $('#fastpostform');
		<!--{if !$_G[uid] || $_G[uid] && !$allowpostreply}-->
		$('#needmessage').on('focus', function() {
			<!--{if !$_G[uid]}-->
				popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			<!--{else}-->
				popup.open('{lang nopostreply}', 'alert');
			<!--{/if}-->
			this.blur();
		});

        $('#fastpostsubmit').on('click', function() {
            <!--{if !$_G[uid]}-->
            popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
            <!--{else}-->
            popup.open('{lang nopostreply}', 'alert');
            <!--{/if}-->
            $('#needmessage').blur();
            return false;
        });
		<!--{else}-->
		$('#needmessage').on('focus', function() {
			var obj = $(this);
			if(obj.attr('color') == 'gray') {
				obj.attr('value', '');
				obj.removeClass('grey');
				obj.attr('color', 'black');
				$('#fastpostsubmitline').css('display', 'block');
			}
		})
		.on('blur', function() {
			var obj = $(this);
			if(obj.attr('value') == '') {
				obj.addClass('grey');
				obj.attr('value', '{lang send_reply_fast_tip}');
				obj.attr('color', 'gray');
			}
		});
        $('#fastpostsubmit').on('click', function() {
            var msgobj = $('#needmessage');
            if(msgobj.val() == '{lang send_reply_fast_tip}') {
                msgobj.attr('value', '');
            }
            $.ajax({
                type:'POST',
                url:form.attr('action') + '&handlekey=fastpost&loc=1&inajax=1',
                data:form.serialize(),
                dataType:'xml'
            })
                .success(function(s) {
                    evalscript(s.lastChild.firstChild.nodeValue);
                })
                .error(function() {
                    window.location.href = obj.attr('href');
                    popup.close();
                });
            return false;
        });
		<!--{/if}-->

		$('#replyid').on('click', function() {
			$(document).scrollTop($(document).height());
			$('#needmessage')[0].focus();
		});

	})();

	function succeedhandle_fastpost(locationhref, message, param) {
		var pid = param['pid'];
		var tid = param['tid'];
		if(pid) {
			$.ajax({
				type:'POST',
				url:'forum.php?mod=viewthread&tid=' + tid + '&viewpid=' + pid + '&mobile=2',
				dataType:'xml'
			})
			.success(function(s) {
                $('.kongzhuangtai').hide();
				$('#post_new').append(s.lastChild.firstChild.nodeValue);
                hideFastform();
                $(document).scrollTop($(document).height());
                $('input[name="seccodeverify"]').val('');
			})
			.error(function() {
				window.location.href = 'forum.php?mod=viewthread&tid=' + tid;
				popup.close();
			});
		} else {
			if(!message) {
				message = '{lang postreplyneedmod}';
			}
			popup.open(message, 'alert');
		}
		$('#needmessage').attr('value', '');
		if(param['sechash']) {
			$('.seccodeimg').click();
		}
	}

	function errorhandle_fastpost(message, param) {
		popup.open(message, 'alert');
	}
</script>
