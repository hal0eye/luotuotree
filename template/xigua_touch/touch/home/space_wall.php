<!--{eval $_G['home_tpl_titles'] = array('{lang message}');}-->

<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<div class="weui-cells__title">{$space[username]}{lang message}</div>

    <div id="ct" class="ct1 wp cl">
        <div class="mn">
            <div class="bm bw0">
                <div class="cl">

        <!--{if helper_access::check_module('wall')}-->
        <form id="quickcommentform_{$space[uid]}" action="home.php?mod=spacecp&ac=comment&uid=$_GET[uid]" method="post" autocomplete="off" >
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <!--{if $_G['uid'] || $_G['group']['allowcomment']}-->
                        <textarea id="comment_message"  name="message" rows="3" class="weui-textarea"></textarea>
                        <!--{elseif $_G['connectguest']}-->
                        {lang connect_fill_profile_to_comment}
                        <!--{else}-->
                        {lang login_to_wall} <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a>
                        <!--{/if}-->
                    </div>
                </div>
            </div>
                <input type="hidden" name="referer" value="home.php?mod=space&uid=$wall[uid]&do=wall" />
                <input type="hidden" name="id" value="$space[uid]" />
                <input type="hidden" name="idtype" value="uid" />
                <input type="hidden" name="handlekey" value="qcwall_{$space[uid]}" />
                <input type="hidden" name="commentsubmit" value="true" />
                <input type="hidden" name="quickcomment" value="true" />
            <div class="weui-btn-area mbw"><button type="submit" name="commentsubmit_btn"value="true" id="commentsubmit_btn" class="btn_pn weui-btn weui-btn_primary"><strong>{lang leave_comments}</strong></button></div>
                <span id="return_qcwall_{$space[uid]}"></span>

            <input type="hidden" name="formhash" value="{FORMHASH}" />
        </form>
        <!--{/if}-->
        <div id="div_main_content" class="mtm mbm">
            <div id="comment">
                <!--{if $cid}-->
                <div class="weui-cells__title">
                    {lang view_one_operation_message},<a href="home.php?mod=space&uid=$space[uid]&do=wall">{lang click_view_message}</a>
                </div>
                <!--{/if}-->

                <div class="weui-cells">
                    <!--{loop $list $k $value}-->
                    <div class="weui-cell">
                        <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">

                            <a href="home.php?mod=space&uid=$value[authorid]"><img src="<!--{avatar($value[authorid],'small', true)}-->" style="width: 50px;display: block"></a>
                        </div>
                        <div class="weui-cell__bd">
                            <p>
                                <!--{if $value[author]}-->
                                <a href="home.php?mod=space&uid=$value[authorid]" id="author_$value[cid]">{$value[author]}</a>
                                <!--{else}-->
                                $_G[setting][anonymoustext]
                                <!--{/if}-->
                            </p>
                            <p style="font-size: 13px;color: #888888;"><!--{if $value[status] == 0 || $value[authorid] == $_G[uid] || $_G[adminid] == 1}-->$value[message]<!--{else}--> {lang moderate_not_validate} <!--{/if}--></p>
                            <p style="font-size:13px;color:#888"><!--{date($value[dateline])}--></p>
                        </div>
                        <!--{if $_G[uid]}-->
                        <div class="weui-cell__ft">
                            <!--{if $value[authorid]==$_G[uid]}-->
                            <a class="button" href="home.php?mod=spacecp&ac=comment&op=edit&cid=$value[cid]&handlekey=editcommenthk_{$value[cid]}" id="c_$value[cid]_edit" onclick="showWindow(this.id, this.href, 'get', 0);">{lang edit}</a>
                            <!--{/if}-->
                            <!--{if $value[authorid]==$_G[uid] || $value[uid]==$_G[uid] || checkperm('managecomment')}-->
                            <a class="button" href="home.php?mod=spacecp&ac=comment&op=delete&cid=$value[cid]&handlekey=delcommenthk_{$value[cid]}" id="c_$value[cid]_delete" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a>
                            <!--{/if}-->
                        </div>
                        <!--{/if}-->
                    </div>
                    <!--{/loop}-->



                </div>


            </div>
            <div class="pgs cl mtm">$multi</div>
        </div>



        </div>
        </div>
        </div>
    </div>

<!--{template common/footer}-->