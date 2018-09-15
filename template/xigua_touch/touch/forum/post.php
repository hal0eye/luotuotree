<?php exit('xxxx'); ?>
<!--{eval $backlist = 1;}-->
<!--{eval $hide_right = 1;}-->
<!--{template common/header}-->
<style>
    #thread_types+.wp{margin-top:12px}
</style>

<form method="post" class="cl" id="postform"
      {if $_GET[action]== 'newthread'}action="forum.php?mod=post&action={if $special != 2}newthread{else}newtrade{/if}&fid=$_G[fid]&extra=$extra&topicsubmit=yes&mobile=2"
{elseif $_GET[action] == 'reply'}action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&extra=$extra&replysubmit=yes&mobile=2"
{elseif $_GET[action] == 'edit'}action="forum.php?mod=post&action=edit&extra=$extra&editsubmit=yes&mobile=2" $enctype
{/if}>
<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}"/>
<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}"/>
<input type="hidden" id="allownoticeauthor" name="allownoticeauthor" value="1">
<!--{if !empty($_GET['modthreadkey'])}--><input type="hidden" name="modthreadkey" id="modthreadkey"
                                                value="$_GET['modthreadkey']"/><!--{/if}-->
<!--{if $_GET[action] == 'reply'}-->
<input type="hidden" name="noticeauthor" value="$noticeauthor"/>
<input type="hidden" name="noticetrimstr" value="$noticetrimstr"/>
<input type="hidden" name="noticeauthormsg" value="$noticeauthormsg"/>
<!--{if $reppid}-->
<input type="hidden" name="reppid" value="$reppid"/>
<!--{/if}-->
<!--{if $_GET[reppost]}-->
<input type="hidden" name="reppost" value="$_GET[reppost]"/>
<!--{elseif $_GET[repquote]}-->
<input type="hidden" name="reppost" value="$_GET[repquote]"/>
<!--{/if}-->
<!--{/if}-->
<!--{if $_GET[action] == 'edit'}-->
<input type="hidden" name="fid" id="fid" value="$_G[fid]"/>
<input type="hidden" name="tid" value="$_G[tid]"/>
<input type="hidden" name="pid" value="$pid"/>
<input type="hidden" name="page" value="$_GET[page]"/>
<!--{/if}-->

<!--{if $special}-->
<input type="hidden" name="special" value="$special"/>
<!--{/if}-->
<!--{if $specialextra}-->
<input type="hidden" name="specialextra" value="$specialextra"/>
<!--{/if}-->

<!--{if $sortid}-->
<input type="hidden" name="sortid" value="$sortid" />
<!--{/if}-->

<ul  id="thread_types" class="ttp  cl">

    <!--{if !$_G['forum']['allowspecialonly']}-->
    <li {if $postspecialcheck[0]}  class="xw1 a"{/if}> <a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" {if $postspecialcheck[0]} selected="selected"{/if}>{lang post_newthread}</a></li>
    <!--{/if}-->

    <!--{loop $_G['forum']['threadsorts'][types] $tsortid $name}-->
    <li{if $_GET[sortid] == $tsortid} class="xw1 a"{/if}><a href="forum.php?mod=post&action=newthread&sortid=$tsortid&fid=$_G[fid]"><!--{echo strip_tags($name);}--></a></li>
    <!--{/loop}-->
    <!--{if $_G['group']['allowpostpoll']}--><li {if $postspecialcheck[1]} class="xw1 a"{/if} ><a href="forum.php?mod=post&action=newthread&special=1&fid=$_G[fid]">{lang post_newthreadpoll}</a></li><!--{/if}-->
    <!--{if $_G['group']['allowpostreward']}--><li {if $postspecialcheck[3]} class="xw1 a"{/if}><a href="forum.php?mod=post&action=newthread&special=3&fid=$_G[fid]">{lang post_newthreadreward}</a></li><!--{/if}-->
    <!--{if $_G['group']['allowpostdebate']}--><li {if $postspecialcheck[5]} class="xw1 a"{/if}><a href="forum.php?mod=post&action=newthread&special=5&fid=$_G[fid]">{lang post_newthreaddebate}</a></li><!--{/if}-->
    <!--{if $_G['group']['allowpostactivity']}--><li {if $postspecialcheck[4]} class="xw1 a"{/if} ><a href="forum.php?mod=post&action=newthread&special=4&fid=$_G[fid]">{lang post_newthreadactivity}</a></li><!--{/if}-->
    <!--{if $_G['group']['allowposttrade']}--><li {if $postspecialcheck[2]} class="xw1 a"{/if}><a href="forum.php?mod=post&action=newthread&special=2&fid=$_G[fid]">{lang post_newthreadtrade}</a></li><!--{/if}-->
</ul>

<!--{if $specialextra || !($special != 2 && $special != 4 && $special != 1 && $special != 3 && $special != 5 && !($isfirstpost && $sortid))}-->
<!--{eval $adveditor = $isfirstpost && $special && ($_GET['action'] == 'newthread' || $_GET['action'] == 'reply' && !empty($_GET['addtrade']) || $_GET['action'] == 'edit' );}-->

<!--{if $special == '2'}-->
<div class="weui-cells__title">{lang send_special_trade_error}</div>
<!--{elseif $special == '1'}-->
<!--{template forum/post_poll}-->
<!--{elseif $special == 3}-->
<!--{template forum/post_reward}-->
<!--{elseif $special == '4'}-->
<!--{template forum/post_activity}-->
<!--{elseif $isfirstpost && $sortid}-->
<!--{template forum/post_sortoption}-->
<!--{elseif $special == 5}-->
<!--{template forum/post_debate}-->
<!--{elseif $specialextra}-->
<div class="cl">$threadplughtml</div>
<!--{/if}-->

<!--{/if}-->

<div class="wp">
    <!-- main postbox start -->
    <div class="post_from">
        <div class="weui-cells weui-cells_form mt0">



            <!--{if $_GET['action'] != 'reply'}-->
            <div class="weui-cell" id="subject">
                <div class="weui-cell__bd">
                    <input type="text" tabindex="1" class="weui-input" id="needsubject" size="30" autocomplete="off"
                           value="$postinfo[subject]" name="subject" placeholder="{lang thread_subject}" fwin="login">
                </div>
            </div>
            <!--{else}-->
            <div class="weui-cells__title">RE: $thread['subject'] <!--{if $quotemessage}-->$quotemessage
                <!--{/if}--></div>
            <!--{/if}-->

            <!--{if $_GET[action] == 'edit' && $isorigauthor && ($isfirstpost && $thread['replies'] < 1 || !$isfirstpost) && !$rushreply && $_G['setting']['editperdel']}-->
            <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">{lang post_delpost}{if $thread[special] == 3}{lang reward_price_back}{/if}
                </div>
                <div class="weui-cell__ft">
                    <input type="checkbox" name="delete" id="delete" class="weui-switch" value="1"
                           title="{lang post_delpost}{if $thread[special] == 3}{lang reward_price_back}{/if}">
                </div>
            </div>
            <!--{/if}-->

            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" id="needmessage" tabindex="3" autocomplete="off" name="$editor[textarea]" rows="6"
                              placeholder="{lang thread_content}" fwin="reply">$postinfo[message]</textarea>
                </div>
            </div>




            <!--{if $isfirstpost && !empty($_G['forum'][threadtypes][types])}-->
<!--            <div class="weui-cells__title">{lang select_thread_catgory}</div>-->
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <div class="post-tags cl" id="post-typeid">
                        <!--{loop $_G['forum'][threadtypes][types] $typeid $name}-->
                        <!--{if empty($_G['forum']['threadtypes']['moderators'][$typeid]) || $_G['forum']['ismoderator']}-->
                        <a class="weui-btn weui-btn_mini weui-btn_default {if $thread['typeid'] == $typeid || $_GET['typeid'] == $typeid}button{/if}" href="javascript:;" onclick="return setTypeid($typeid, this);"><!--{echo strip_tags($name);}--></a>
                        <!--{/if}-->
                        <!--{/loop}-->
                    </div>

                    <input type="hidden" id="typeid" name="typeid" value="<!--{if $thread['typeid']}-->$thread['typeid']<!--{else}-->$_GET['typeid']<!--{/if}-->" >
                    <script>
                        function setTypeid(id, obj){
                            $('#typeid').val(id);
                            $('#post-typeid a').removeClass('button');
                            $(obj).addClass('button');
                        }
                    </script>
                </div>
            </div>


            <!--{/if}-->


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

        <!--{if $_GET[action] != 'edit' && ($secqaacheck || $seccodecheck)}-->
        <!--{subtemplate common/seccheck}-->
        <!--{/if}-->

        <!--{template forum/postin}-->


        <!--{hook/post_bottom_mobile}-->
    </div>
</div>

<div class="weui-btn-area mbw">
    <button id="postsubmit" class="btn_pn weui-btn  <!--{if $_GET[action] == 'edit'}-->weui-btn_primary" disable="false"
    <!--{else}-->weui-btn_disabled" disable="true"<!--{/if}-->><strong>{lang send_thread}</strong></button>
    <input type="hidden"
           name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{elseif $_GET[action] == 'edit'}editsubmit{/if}"
           value="yes">
</div>


</form>

<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
