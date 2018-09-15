<?php exit('xxxxx'); ?>
<!--{template common/header}-->
<!--{eval $top_banners = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['top_banner'])));}-->
<!--{if $top_banners}-->
<div class="banner">
    <nav class="weui-flex">
        <!--{loop $top_banners $k $top_banner}-->
        <!--{eval list($font, $link, $icon)= explode(",", trim($top_banner)); }-->
        <a href="{$link}" class="<!--{if $k==0}--> active<!--{/if}-->">$font</a>
        <!--{/loop}-->
    </nav>
</div>
<div class="banner_fix cl"></div>
<!--{/if}-->

<!--{eval $top_navsliders = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['top_navslider'])));}-->
<!--{if $top_navsliders}-->
<div class="swipe cl">
    <div class="swipe-wrap">
        <!--{loop $top_navsliders $top_navslider}-->
        <!--{eval list($font, $link, $icon)= explode(",", trim($top_navslider)); }-->
        <div><a href='$link' ><img src='$icon'/></a></div>
        <!--{/loop}-->
    </div>
    <nav class="bullets">
        <ul class="position">
            <!--{loop $top_navsliders $k $slider}-->
            <li <!--{if $k==0}-->class="current"<!--{/if}-->></li>
            <!--{/loop}-->
        </ul>
    </nav>

    <div class="water">
        <div class="water-c">
            <div class="water-1"></div>
            <div class="water-2"></div>
        </div>
    </div>

</div>
<!--{/if}-->

<!--{if $_G['cache']['plugin']['xigua_th']['bighui'] || $_G['cache']['plugin']['xigua_th']['smallhui']||$_G['cache']['plugin']['xigua_th']['toutiao']}-->
<div class="weui-cells mt0" style="margin-bottom: 12px">
    <!--{eval list($link1, $icon1) = explode(",", trim($_G['cache']['plugin']['xigua_th']['bighui']));}-->
    <!--{if $icon1}-->
    <div class="chip-l"><a href="$link1"><img src="$icon1"></a></div>
    <!--{/if}-->

    <!--{eval $smallhuis = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['smallhui'])));}-->
    <!--{loop $smallhuis $smallhui}-->
    <!--{eval list($font1, $font2, $icon, $link)= explode(",", trim($smallhui)); }-->
    <div class="chip">
        <div>
            <p><a href="$link">$font1</a></p>
            <p><a href="$link">$font2</a></p>
        </div>
        <a href="$link"><img src="$icon"></a>
    </div>
    <!--{/loop}-->

    <!--{if $_G['cache']['plugin']['xigua_th']['toutiao']}-->
    <div class="chip-row">
        <div class="toutiao" <!--{if $_G['cache']['plugin']['xigua_th']['toutiaocolor']}-->style="color:{$_G['cache']['plugin']['xigua_th']['toutiaocolor']}"<!--{/if}-->>$_G['cache']['plugin']['xigua_th']['toutiao']</div>
        <div class="toutiao-slider swiper-container" id="newsSlider">
            <ul class="swiper-wrapper">
                <!--{eval $toutiaoitems = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['toutiaoitems'])));}-->
                <!--{loop $toutiaoitems $toutiaoitem}-->
                <!--{eval list($font, $link)= explode(",", trim($toutiaoitem)); }-->
                    <li class="swiper-slide"> <a href="$link">$font</a> </li>
                <!--{/loop}-->
            </ul>
        </div>
    </div>
    <script src="template/xigua_touch/xtatic/idangerous.swiper.min.js"></script>
    <script>
        var mySwiper = new Swiper('#newsSlider', {
            mode: 'vertical',
            speed: '800',
            autoplay: '3000',
            loop: true,
            autoplayDisableOnInteraction:false
        })
    </script>
    <!--{/if}-->
</div>
<!--{/if}-->

<!--{eval $top_iconlists = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['top_iconlist'])));}-->
<!--{if $top_iconlists}-->
<nav class="nav-list cl swipe">
    <div class="swipe-wrap">
        <div><ul class="cl">
                <!--{loop $top_iconlists $k $top_iconlist}-->
                <!--{eval list($font, $link, $icon)= explode(",", trim($top_iconlist)); }-->
                <!--{if $k && $k%8==0}-->
            </ul></div><div><ul class="cl">
                <!--{/if}-->
                <li>
                    <a href="$link">
                        <span><img src="$icon" /></span>
                        <em class="m-piclist-title">$font</em>
                    </a>
                </li>
                <!--{/loop}-->
            </ul>
        </div>
    </div>
    <!--{eval $tmpary = range(1, ceil(count($top_iconlists)/8));}-->
    <!--{if count($tmpary)>1}-->
    <nav class="cl bullets bullets1">
        <ul class="position position1">
            <!--{loop $tmpary $k $v}-->
            <li {if $k==0} class="current" {/if}></li>
            <!--{/loop}-->
        </ul>
    </nav>
    <!--{/if}-->
</nav>
<!--{/if}-->

<div class="ct <!--{if $top_banners || $top_navsliders || $top_iconlists}-->mtm<!--{/if}-->">
    <!--{eval $showlistidx = unserialize($_G['cache']['plugin']['xigua_th']['showlistidx']);}-->
    <!--{eval $showlistidx1 = array_filter(explode("\n", trim($_G['cache']['plugin']['xigua_th']['showlistidx1'])));}-->
    <!--{if !(count($showlistidx)==1&& in_array('0', $showlistidx))}-->
    <div class="weui-flex guidenav">
        <!--{if in_array('newthread', $showlistidx)}-->
        <div class="weui-flex__item{if $view == 'newthread'} a{/if}"><a href="forum.php?mod=guide&view=newthread" class="lb"><!--{if $showlistidx1[0]}-->$showlistidx1[0]<!--{else}-->{lang guide_newthread}<!--{/if}--></a></div>
        <!--{/if}-->
        <!--{if in_array('hot', $showlistidx)}-->
        <div class="weui-flex__item{if $view == 'hot'} a{/if}"><a href="forum.php?mod=guide&view=hot" class="nb"><!--{if $showlistidx1[1]}-->$showlistidx1[1]<!--{else}-->{lang guide_hot}<!--{/if}--></a></div>
        <!--{/if}-->
        <!--{if in_array('digest', $showlistidx)}-->
        <div class="weui-flex__item{if $view == 'digest'} a{/if}"><a href="forum.php?mod=guide&view=digest" class="rb"><!--{if $showlistidx1[2]}-->$showlistidx1[2]<!--{else}-->{lang guide_digest}<!--{/if}--></a></div>
        <!--{/if}-->
        <!--{if in_array('new', $showlistidx)}-->
        <div class="weui-flex__item{if $view == 'new'} a{/if}"><a href="forum.php?mod=guide&view=new" class="rb"><!--{if $showlistidx1[3]}-->$showlistidx1[3]<!--{else}-->{lang guide_new}<!--{/if}--></a></div>
        <!--{/if}-->
        <!--{if in_array('sofa', $showlistidx)}-->
        <div class="weui-flex__item{if $view == 'sofa'} a{/if}"><a href="forum.php?mod=guide&view=sofa" class="rb"><!--{if $showlistidx1[4]}-->$showlistidx1[4]<!--{else}-->{lang guide_sofa}<!--{/if}--></a></div>
        <!--{/if}-->
    </div>
    <!--{/if}-->
    <div class="threadlist">
        <!--{if $view == 'index'}-->
        <!--{eval dheader("location: forum.php?mod=guide&view=newthread");exit; }-->
        <!--{else}-->
        <!--{loop $data $key $list}-->
        <div class="news-list-wrapper tab-news-content">
            <!--{if $list['threadcount']}-->

            <!--{eval $threadlist = x_s2($list['threadlist']);}-->
            <!--{loop $threadlist $thread}-->
            <!--{subtemplate common/thread_list_node}-->
            <!--{/loop}-->

            <!--{else}-->
            <div class="news-item tpl-1">
                <a class="guide">
                    <h2>{lang guide_nothreads}</h2>
                </a>
            </div>
            <!--{/if}-->
        </div>
        <!--{/loop}-->
        <!--{/if}-->
    </div>
</div>

$multipage

<!--{template common/footer}-->
