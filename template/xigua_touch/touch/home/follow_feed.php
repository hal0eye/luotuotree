<?php exit;?>
<!--{eval $backlist = 1;}-->
<!--{subtemplate common/header}-->

<!--{block m_follow}-->
<ul id="thread_types" class="ttp cl">
    <li><a style="width:33%" href="home.php?mod=follow&view=follow"><span class="xg1">{lang follow}</span> <strong class="xi2">$space['feeds']</strong></a></li>
    <li><a style="width:33%" href="home.php?mod=follow&do=following&uid=$uid"><span class="xg1">{lang follow_add}</span> <strong class="xi2">$space['following']</strong></a></li>
    <li><a style="width:33%" href="home.php?mod=follow&do=follower&uid=$uid"><span class="xg1">{lang follow_follower}</span> <strong class="xi2">$space['follower']</strong></a></li>
</ul>
<!--{/block}-->

<div class="ct">

		<!--{if in_array($do, array('feed', 'view'))}-->
<div id="tabox" class="tabox box_bg">
    <div class="hd">
        <ul class="thread_types ttp cl">
            <li class="{if $actives[follow]}a{/if}"><a href="home.php?mod=follow&view=follow">{lang follow_following}</a></li>
            <li class="{if !$_REQUEST[post]&&$actives[special]}a{/if}"><a href="home.php?mod=follow&view=special">{lang follow_special_following}</a></li>
            <li class="{if $actives[other]}a{/if}"><a  href="home.php?mod=follow&view=other">{lang follow_hall}</a></li>
            <li class="{if $_REQUEST[post]}a{/if}"><a href="home.php?mod=follow&view=special&post=1">{echo xtl('postguangbo');}</a></li>
        </ul>
    </div>
</div>


<!--{if $_REQUEST['post']}-->
<div>
    <!--{eval $dmfid = $_G['setting']['followforumid'] && !empty($defaultforum) ? $_G['setting']['followforumid'] : 0;}-->
    <form method="post" autocomplete="off" id="fastpostform"
          action="home.php?mod=spacecp&ac=follow&op=newthread&topicsubmit=yes&infloat=yes&handlekey=fastnewpost"
          onsubmit="return fastpostvalidate(this);">
        <input type="hidden" name="formhash" value="{FORMHASH}"/>
        <input type="hidden" name="usesig" value="$usesigcheck"/>
        <input type="hidden" name="adddynamic" value="1"/>
        <input type="hidden" name="addfeed" value="1"/>
        <input type="hidden" name="topicsubmit" value="true"/>
        <input type="hidden" name="referer" value="{echo dreferer()}"/>

        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" placeholder="{echo xtl('postguangbo');}" rows="3" name="message"
                              id="fastpostmessage"></textarea>
                </div>
            </div>
        </div>

        <!--{if checkperm('seccode') && ($secqaacheck || $seccodecheck)}-->
        <!--{subtemplate common/seccheck}-->
        <!--{/if}-->

        <div class="weui-btn-area mbw">
            <button type="submit" class="btn_pn weui-btn weui-btn_primary" name="topicsubmit_btn"
                    id="fastpostsubmit" value="topicsubmitbtn"
                    tabindex="13">{lang publish}
            </button>
        </div>

    </form>
</div>
<!--{/if}-->


			<!--{if in_array($do, array('feed', 'view'))}-->

				<!--{if !empty($list['feed']) && !$_REQUEST[post]}-->
                
					<div class="flw_feed box_bg">
                    
						<ul id="followlist" class="el">
							<!--{subtemplate home/follow_feed_li}-->
						</ul>                        
                        
					</div>
                    
                    <!--{else}-->
                    
						<!--{if $do == 'feed' && $view == 'special' && !$_REQUEST[post]}-->
                        <div class="weui-cells__title">
							{lang follow_add_special_tip}<a href="home.php?mod=follow&do=following&uid=$uid" class="xi2">{lang follow_add_special_following}</a>
						</div>
						<!--{/if}-->
					
				<!--{/if}-->                
                
				<!--{if count($list['feed']) > 19 && ($archiver || $primary)}-->
					<script type="text/javascript">
						var scrollY = 0;
						var page = 2;
						var feedInfo = {scrollY: 0, archiver: $archiver, primary: $primary, query: true, scrollNum:1};
					</script>
				<!--{/if}-->
                
			<!--{/if}-->            

			<!--{elseif in_array($do, array('following', 'follower'))}-->            
            
				<!--{if $list}-->
                
                <!--{$m_follow}-->
                
					<ul class="flw_ulist box_bg">
					<!--{loop $list $fuid $fuser}-->
						<li class="cl">
						<!--{if $do=='following'}-->
							<a href="home.php?mod=space&uid=$fuser['followuid']" title="$fuser['fusername']" id="edit_avt" class="flw_avt" shref="home.php?mod=space&uid=$fuser['followuid']"><!--{avatar($fuser['followuid'],small)}--></a>
							<!--{if $viewself}-->
								<a id="a_followmod_{$fuser['followuid']}" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$fuser['followuid']" onclick="ajaxget(this.href);doane(event);" class="flw_btn_unfo">{lang follow_del}</a>
							<!--{elseif $fuser[followuid] != $_G[uid]}-->
								<!--{if $fuser['mutual']}-->
									<!--{if $fuser['mutual'] > 0}--><span class="z flw_status_2">{lang follow_follower_mutual}</span><!--{else}--><span class="z flw_status_1">{lang did_not_follow_to_me}</span><!--{/if}--><a id="a_followmod_{$fuser['followuid']}" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$fuser['followuid']"  onclick="ajaxget(this.href);doane(event);" class="flw_btn_unfo">{lang follow_del}</a>
								<!--{elseif helper_access::check_module('follow')}-->
									<a id="a_followmod_{$fuser['followuid']}" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$fuser['followuid']" onclick="ajaxget(this.href);doane(event);" class="flw_btn_fo">{lang follow_add}</a>
								<!--{/if}-->
							<!--{/if}-->
							<p class="pbn"><a href="home.php?mod=space&uid=$fuser['followuid']" title="$fuser['fusername']" class="xi2" c="1" shref="home.php?mod=space&uid=$fuser['followuid']">$fuser['fusername']</a>&nbsp;<span id="followbkame_{$fuser['followuid']}" class="xg1 xs1 xw0"><!--{if $fuser['bkname']}-->$fuser[bkname]<!--{/if}--></span></p>
							<!--{if !empty($fuser['recentnote'])}--><p><span class="xg1">{lang follow_recent_note}:</span>$fuser[recentnote]</p><!--{/if}-->
							<p class="ptm xg1">								
								{lang follow_follower}: <a href="home.php?mod=follow&do=follower&uid=$fuser['followuid']"><strong class="xi2" id="followernum_$fuser['followuid']">$memberinfo[$fuid]['follower']</strong></a>{lang person} <span class="pipe">|</span>
								{lang follow_add}: <a href="home.php?mod=follow&do=following&uid=$fuser['followuid']"><strong class="xi2">$memberinfo[$fuid]['following']</strong></a>{lang person} 
								<!--{if $viewself && $fuser[followuid] != $_G[uid]}-->								
								<!--{if helper_access::check_module('follow')}-->
								<span class="pipe">|</span>
								<a id="a_specialfollow_{$fuser['followuid']}" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&special={if $fuser['status'] == 1}2{else}1{/if}&fuid=$fuser['followuid']" onclick="ajaxget(this.href);doane(event);"><!--{if $fuser['status'] == 1}-->{lang follow_del_special_following}<!--{else}-->{lang follow_add_special_following}<!--{/if}--></a>
								<!--{/if}-->
								<!--{/if}-->
							</p>
						<!--{else}-->
							<a href="home.php?mod=space&uid=$fuser['uid']" title="$fuser['username']" id="edit_avt" class="flw_avt" c="1" shref="home.php?mod=space&uid=$fuser['uid']"><!--{avatar($fuser['uid'],small)}--></a>
							<!--{if $fuser[uid] != $_G[uid]}-->                           
								<!--{if $fuser['mutual']}-->
									<a id="a_followmod_{$fuser['uid']}" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$fuser['uid']"  onclick="ajaxget(this.href);doane(event);" class="flw_btn_unfo">{lang follow_del}</a>
								<!--{elseif helper_access::check_module('follow')}-->
									<a id="a_followmod_{$fuser['uid']}" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$fuser['uid']" onclick="ajaxget(this.href);doane(event);" class="flw_btn_fo">{lang follow_add}</a>
								<!--{/if}-->
                              
							<!--{/if}-->
							<p class="pbn"><a href="home.php?mod=space&uid=$fuser['uid']" title="$fuser['username']" class="xi2" c="1" shref="home.php?mod=space&uid=$fuser['uid']">$fuser['username']</a></p>
							<p><span class="xg1">{lang follow_recent_note}:</span>$fuser[recentnote]</p>
							<p class="ptm xg1">								
								{lang follow_follower}: <a href="home.php?mod=follow&do=follower&uid=$fuser['uid']"><strong class="xi2" id="followernum_$fuser['uid']">$memberinfo[$fuid]['follower']</strong></a>{lang person} <span class="pipe">|</span>
								{lang follow_add}: <a href="home.php?mod=follow&do=following&uid=$fuser['uid']"><strong class="xi2">$memberinfo[$fuid]['following']</strong></a>{lang person}
							</p>
						<!--{/if}-->
						</li>
					<!--{/loop}-->
					</ul>

					<!--{if !empty($multi)}--><div class="pgbox">$multi</div><!--{/if}-->					
                    
				<!--{else}-->
										<div class="weui-cells__title">
											<!--{if $viewself}-->
                                            
												<!--{if $do=='following'}-->
													{lang follow_you_following_none}<a href="home.php?mod=follow&view=other" class="xi2">{lang follow_hall}</a>{lang follow_fetch_interested_user}
												<!--{else}-->
													{lang follow_you_follower_none1}<a href="home.php?mod=follow" class="xi2">{lang follow_add_feed}</a>{lang follow_you_follower_none2}
												<!--{/if}-->
                                                
											<!--{else}-->
												<!--{if $do=='following'}-->
													{lang follow_user_following_none}
												<!--{else}-->
													{lang follow_user_follower_none}
												<!--{/if}-->

											<!--{/if}-->
										</div>
                    
				<!--{/if}-->
                
			<!--{/if}-->
</div>

<!--{subtemplate common/footer}-->