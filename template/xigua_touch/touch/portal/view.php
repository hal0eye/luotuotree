<?php exit('xxxxxx'); ?>

<!--{eval $backlist = 1;}-->
<!--{template common/header}-->
<div class="postlist cl">

    <div class="headtitle">
        <a href="javascript:;" onclick="window.location.reload();">
            <h2>$article[title] <!--{if $article['status'] == 1}--><span>({lang moderate_need})</span>
                <!--{elseif $article['status'] == 2}--><span>({lang ignored})</span><!--{/if}--></h2>
        </a>

        <div class="article-header">


            <div class="texts">
                <div class="x-user usr-name">
                    <a href="home.php?mod=space&uid=$article[uid]" class="blue vm">$article[username]</a>

                    <em class="vm grey">$article[dateline]</em>
                    <em class="vm grey">{lang view_views} <!--{if $article[viewnum] > 0}-->$article[viewnum]
                        <!--{else}-->0<!--{/if}--> </em>
                    <em class="vm grey">{lang view_comments}: <!--{if $article[commentnum] > 0}--><a href="$common_url"
                                                                                                     title="{lang view_all_comments}">$article[commentnum]</a>
                        <!--{else}-->0<!--{/if}--></em>

                </div>
            </div>
            <!--{hook/view_article_subtitle}-->
        </div>


    </div>


    <div class="plc cl postitem">
        <div class="display pi">$content[content]</div>
        <!--{if $multi}-->
        <div class="pgbox">$multi</div><!--{/if}-->
    </div>


</div>
<!--{hook/view_article_content}-->

<div class="weui-cells">
    <!--{if $article['prearticle']}--><a class="weui-cell weui-cell_access" href="{$article['prearticle']['url']}">
        <div class="weui-cell__bd ellipsis">
            {lang pre_article} {$article['prearticle']['title']}
        </div>
        <div class="weui-cell__ft"></div>
    </a><!--{/if}-->
    <!--{if $article['nextarticle']}--><a class="weui-cell weui-cell_access"
                                          href="{$article['nextarticle']['url']}">
        <div class="weui-cell__bd ellipsis">
            {lang next_article} {$article['nextarticle']['title']}
        </div>
        <div class="weui-cell__ft">
        </div>
    </a><!--{/if}-->
</div>


<!--{if $article['related']}-->
<div class="cl">
    <div class="weui-cells__title">{lang view_related}</div>
    <div class="weui-cells">
        <!--{loop $article['related'] $value}-->
        <a class="weui-cell weui-cell_access" href="portal.php?mod=view&aid=$value[aid]">
            <div class="weui-cell__bd">
                <p>{echo cutstr($value[title],36)}</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
        <!--{/loop}-->
    </div>
</div>
<!--{/if}-->

<!--{if $article['allowcomment']==1}-->
<!--{eval $data = &$article}-->
<!--{subtemplate portal/portal_comment}-->
<!--{/if}-->

<a href="javascript:;" class="caidantop sidectrl bottom"><i class="iconfont icon-caidan"></i></a>
<!--{template common/footer}-->