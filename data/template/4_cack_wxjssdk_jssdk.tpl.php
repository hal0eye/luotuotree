<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$mobole = <<<EOF

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
  <script type="text/javascript">  
 wx.config({
   debug:false,
   appId: '{$signPackage["appId"]}',
   timestamp: {$signPackage["timestamp"]},
   nonceStr: '{$signPackage["nonceStr"]}',
   signature: '{$signPackage["signature"]}',
jsApiList: [
'checkJsApi',
'onMenuShareTimeline',
'onMenuShareAppMessage',
'onMenuShareQQ',
'onMenuShareWeibo'
]
 });
  </script>  
 <script type="text/javascript">  
 wx.ready(function () {
wx.onMenuShareTimeline({
   title: 
EOF;
 if($cwx['title']) { 
$mobole .= <<<EOF
'{$cwx['title']}'
EOF;
 } else { 
$mobole .= <<<EOF
document.title
EOF;
 } 
$mobole .= <<<EOF
,
   link: '{$signPackage["url"]}',
   imgUrl: '{$cwx['pic']}',
   success: function () {
   },
   cancel: function () {
   }
});
    wx.onMenuShareAppMessage({  
title: 
EOF;
 if($cwx['title']) { 
$mobole .= <<<EOF
'{$cwx['title']}'
EOF;
 } else { 
$mobole .= <<<EOF
document.title
EOF;
 } 
$mobole .= <<<EOF
,
desc: document.getElementsByName('description')[0].content,
link: '{$signPackage["url"]}',
imgUrl: '{$cwx['pic']}',
success: function () {
},
cancel: function () {
}
    });  

});	
</script> 


EOF;
?>