<?php exit('xxxxxx');?>
<!--{if $_G['cache']['plugin']['xigua_th']['default_index'] && $_REQUEST['forumlist'] != 1}-->
<!--{eval dheader("location: ".urldecode($_G['cache']['plugin']['xigua_th']['default_index']));exit; }-->
<!--{/if}-->

<!--{if $_G['setting']['mobile']['mobilehotthread'] && $_GET['forumlist'] != 1}-->
<!--{eval dheader('Location:forum.php?mod=guide&view=hot');exit;}-->
<!--{/if}-->