<?php exit('xigua_touch');?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->

<div class="yd-classify-wrapper">
	<!--{hook/index_header}-->
	<div class="classify-names">
		<a href="javascript:" onclick="return the_click(this, 0);" class="active">{lang recommend_group}</a>

		<!--{loop $first $groupid $group}-->
		<a href="javascript:" onclick="return the_click(this, $groupid);" >$group[name]</a>
		<!--{/loop}-->

		<!--{if helper_access::check_module('group')}-->
		<!--{if empty($gid) && empty($sgid)}-->

		<!--{if helper_access::check_module('group')}-->
		<a href="forum.php?mod=group&action=create" id="create_group_btn">{lang group_create}</a>
		<!--{/if}-->
		<!--{else}-->
		<a href="forum.php?mod=group&action=create&fupid=$fup&groupid=$sgid" id="create_group_btn">{lang group_create}</a>
		<!--{/if}-->
		<!--{/if}-->
	</div>
	<div class="classify-item">


		<div class="t-recommend" id="thelist_0" style="display:none">
		<!--{loop dunserialize($_G['setting']['group_recommend']) $val}-->
			<div class="item">
				<a href="forum.php?mod=group&fid=$val[fid]" class="t-bottom">
					<div class="t-right">
						<div class="mid">
							<span class="name">{$val[name]}</span>
						</div>
					</div>
				</a>
			</div>
		<!--{/loop}-->
		</div>

		<!--{loop $first $groupid $group}-->
		<div class="t-recommend" id="thelist_$groupid" style="display:none">

			<!--{loop $lastupdategroup[$groupid] $val}-->
			<div class="item">
				<a href="forum.php?mod=group&fid=$val[fid]" class="t-bottom">
					<div class="t-right">
						<div class="mid">
							<span class="name">{$val[name]}</span>
						</div>
					</div>
				</a>
			</div>
			<!--{/loop}-->

		</div>
		<!--{/loop}-->

	</div>
</div>
<script>
    function the_click(obj, id) {
        $('.classify-names a').removeClass('active');
        $(obj).addClass('active');
        $('.t-recommend').hide();
        $('#thelist_'+id).show();
    }
    $('.classify-names a:first-child').trigger('click');
</script>



<!--{template common/footer}-->