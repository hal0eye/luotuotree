<?php exit;?>
<!--{eval $backlist = 1;}-->
<!--{template common/header}-->


<!--{if $tagname}-->
<div class="ct">
  
<!--{if empty($showtype) || $showtype == 'thread'}-->


    <!--{if empty($threadlist)}-->

    <div class="news-item tpl-1">
        <div class="guide">
            <h2>{lang empty_tags}</h2>
        </div>
    </div>
    <!--{else}-->
    <div class="thread_list_node2_list">
    <!--{eval $threadlist = x_s2($threadlist);}-->
    <!--{loop $threadlist $thread}-->
    <!--{subtemplate common/thread_list_node2}-->
    <!--{/loop}-->
    </div>


    <!--{if empty($showtype)}-->
        <div class="a_pg"><a href="misc.php?mod=tag&id=$id&type=thread">{lang more}...</a></div>
    <!--{else}-->
        <!--{if $multipage}--><div class="pgbox">$multipage</div><!--{/if}-->
    <!--{/if}-->

    <!--{/if}-->
  
<!--{/if}--> 
  
</div>
<!--{else}-->


<!--{/if}--> 
<!--{template common/footer}-->