<!--{eval $backlist=1;}--><!--{template common/header}-->
<div id="ct" class="ct2 wp cl">
    <div class="mn">
        <div class="bm fl cl">
            <!--{if $typelist}-->
            <div class="banner">
                <nav class="weui-flex">
                    <!--{loop $typelist $fid $type}-->
                    <a href="group.php?sgid=$fid">$type[name]</a>
                    <!--{/loop}-->
                </nav>
            </div>
            <div class="banner_fix cl"></div>
            <!--{/if}-->

            <!--{if $list}-->

            <div class="weui-cells">
                <!--{loop $list $fid $val}-->
                <a class="weui-cell" href="forum.php?mod=group&fid=$fid">
                    <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                        <img src="$val[icon]" style="width: 50px;display: block">
                    </div>
                    <div class="weui-cell__bd">
                        <p>$val[name]</p>
                        <p style="font-size: 13px;color: #888888;">$val[description]</p>
                    </div>
                    <div class="weui-cell__ft" style="font-size: 14px;">
                        <span class="i_z z"><strong>$val[membernum]</strong><em class="xg1">{lang group_member}</em></span>
                        <span class="i_y z"><strong>$val[threads]</strong><em class="xg1">{lang threads}</em></span>
                    </div>
                </a>
                <!--{/loop}-->


            </div>
            <!--{else}-->
            <div class="bm emp">
                <div class="weui-cells__title">{lang group_category_no_groups}</div>
                <div class="weui-cells__title">{lang group_category_no_groups_detail}</div>
            </div>
            <!--{/if}-->
        </div>
        <!--{if $list}-->
        <div class="pgbox cl">
            $multipage
        </div>
        <!--{/if}-->
    </div>
    <div class="sd">
        <!--{if helper_access::check_module('group')}-->
        <div class="weui-btn-area mbw">
            <a class="btn_pn weui-btn weui-btn_primary" href="forum.php?mod=group&action=create&fupid=$fup&groupid=$sgid">{lang group_create}</a>
        </div>
        <!--{/if}-->
    </div>
</div>

<!--{template common/footer}-->