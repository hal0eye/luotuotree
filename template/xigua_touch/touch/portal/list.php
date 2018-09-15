<?php exit('xxxx');?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<!--{eval include DISCUZ_ROOT.TPLDIR.'/php/portal.php';}-->

<!--{eval $list = array();}-->
<!--{eval $wheresql = category_get_wheresql($cat);}-->
<!--{eval $list = category_get_list($cat, $wheresql, $page);}-->
<div class="cl">

    <!--{eval $portal_banners = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['portal_banner'])));}-->
    <!--{if $portal_banners}-->
    <div class="banner">
        <nav class="weui-flex">
            <!--{loop $portal_banners $k $portal_banner}-->
            <!--{eval list($font, $link, $icon)= explode(",", trim($portal_banner)); }-->
            <a href="{$link}" class="<!--{if strpos(xg_currenturl(), $link)!==false}--> active<!--{/if}-->">$font</a>
            <!--{/loop}-->
        </nav>
    </div>
    <div class="banner_fix cl"></div>
    <!--{/if}-->
            
	<div class="news-list-wrapper tab-news-content thread_list_node2_list">
	<!--{loop $list['list'] $value}-->
        <section class="m_article cl">
            <a href="portal.php?mod=view&aid=$value[aid]">
                <!--{if $value[pic]}-->
                <div class="m_article_img">
                    <img src="template/xigua_touch/xtatic/none.png" class="lazy" data-original="$_G[siteurl]/$value[pic]"/>
                </div>
                <!--{/if}-->
                <div class="m_article_info">
                    <div class="m_article_title">
                        <span>$value[title]</span>
                    </div>
                    <div class="m_article_desc cl">
                        <div class="m_article_desc_l">

                            <span class="m_article_channel">$value[catname]</span>

                            <span class="m_article_time">$value[username]</span>
                        </div>
                        <div class="m_article_desc_r">
                            <div class="left_hands_desc">
                                $value[dateline]
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </section>
	<!--{/loop}-->
	</div>

    <!--{if $list['multi']}-->
    <div class="pgbox">{$list['multi']}</div>
    <!--{/if}-->
</div>
<!--{subtemplate common/footer}-->