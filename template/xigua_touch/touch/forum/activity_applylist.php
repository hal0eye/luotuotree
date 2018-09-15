<?php exit('xxxxx');?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<!--{if empty($_GET['infloat'])}-->

<div id="ct" class="wp cl">
    <div class="mn">
        <div class="bm bw0">
            <!--{/if}-->

            <form id="applylistform" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplylist&tid=$_G[tid]&applylistsubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat']) && empty($_GET['from'])} onsubmit="ajaxpost('applylistform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if} >
            <div class="f_c">


                <div class="weui-cells__title"><em id="return_$_GET['handlekey']"><!--{if $isactivitymaster}-->{lang activity_applylist_manage}<!--{else}-->{lang activity_applylist}<!--{/if}--></em>
                    <span>
				<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
			</span></div>




                <input type="hidden" name="formhash" value="{FORMHASH}" />
                <input type="hidden" name="operation" value="" />
                <!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
                <div class="c floatwrap">



                    <!--{loop $applylist $apply}-->
                    <div class="weui-form-preview">
                        <div class="weui-form-preview__hd">
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang activity_join_members}</label>
                                <em class="weui-form-preview__value">
                                    <!--{if $isactivitymaster}-->
                                        <!--{if $apply[uid] != $_G[uid]}-->
                                        <input type="checkbox" name="applyidarray[]" class="pc" value="$apply[applyid]" />
                                        <!--{else}-->
                                        <input type="checkbox" class="pc" disabled="disabled" />
                                        <!--{/if}-->
                                    <!--{/if}--></em>
                            </div>
                        </div>
                        <div class="weui-form-preview__bd">
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang activity_join_members}</label>
                                <span class="weui-form-preview__value">
                                    <a target="_blank" href="home.php?mod=space&uid=$apply[uid]">$apply[username]</a>
                                    <!--{if $apply[uid] != $_G[uid]}-->
                                        <a href="home.php?mod=spacecp&ac=pm&touid=$_G[uid]" title="{lang send_pm}"></a>
                                    <!--{/if}-->


                                </span>
                            </div>
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang leaveword}</label>
                                <span class="weui-form-preview__value"><!--{if $apply[message]}-->$apply[message]<!--{/if}--></span>
                            </div>
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang extension_project}</label>
                                <span class="weui-form-preview__value">


                                <!--{if $apply[ufielddata]}-->
                                     <ul>$apply[ufielddata]</ul>
                                    <!--{else}-->
                                {lang no_informations}
                                    <!--{/if}-->

                                </span>
                            </div>
                            <!--{if $activity['cost']}-->
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang activity_payment}</label>
                                <span class="weui-form-preview__value"><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></span>
                            </div>
                            <!--{/if}-->
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang activity_jointime}</label>
                                <span class="weui-form-preview__value">$apply[dateline]</span>
                            </div>
                            <!--{if $isactivitymaster}-->
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{lang status}</label>
                                <span class="weui-form-preview__value">
                                    <!--{if $apply[verified] == 1}-->
                                {lang activity_allow_join}
                                    <!--{elseif $apply[verified] == 2}-->
                                {lang activity_do_replenish}
                                    <!--{else}-->
                                {lang activity_cant_audit}
                                    <!--{/if}-->

                                </span>
                            </div>
                            <!--{/if}-->
                        </div>
                    </div>
                    <!--{/loop}-->

                </div>
            </div>
            <!--{if $isactivitymaster}-->

            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="reason" placeholder="{lang activity_ps}">
                    </div>
                </div>
            </div>


            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                <button class="button pnc vm" type="submit" value="true" name="applylistsubmit"><span>{lang confirm}</span></button>
                <button class="button vm" type="submit" value="true" name="applylistsubmit" onclick="$('applylistform').operation.value='replenish';"><span>{lang to_improve}</span></button>
                <button class="button vm" type="submit" value="true" name="applylistsubmit" onclick="$('applylistform').operation.value='notification';"><span>{lang send_notification}</span></button>
                <button class="button vm" type="submit" value="true" name="applylistsubmit" onclick="$('applylistform').operation.value='delete';"><span>{lang activity_refuse}</span></button>
                    </div>
                </div>
            </div>

            <!--{/if}-->
            </form>

            <!--{if !empty($_GET['infloat'])}-->
            <script type="text/javascript" reload="1">
                function succeedhandle_$_GET['handlekey'](locationhref) {
                    ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$_GET[pid]', 'post_$_GET[pid]');
                    hideWindow('$_GET['handlekey']');
                }
            </script>
            <!--{/if}-->

            <!--{if empty($_GET['infloat'])}-->
        </div>
    </div>
</div>
<!--{/if}-->
<!--{template common/footer}-->