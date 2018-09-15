<?php exit('hrh');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="{CHARSET}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta content="telephone=no" name="format-detection"/>
    <title>{$navtitle}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="source/plugin/xigua_login/static/common.css?t={$pluginversion}" rel="stylesheet"/>
    <link href="source/plugin/xigua_login/static/weui.css?t={$pluginversion}" rel="stylesheet"/>
    <script src="source/plugin/xigua_login/static/jquery.min.js?t={$pluginversion}"></script>
    <style>
        .container_map{width:100%;padding-top:0px}
        .weui-navbar{position:relative}
        .weui-btn-area {
            margin: 1.17647059em 15px 0.3em;
        }
        .weui-cells{margin-top: 0}
        .weui-navbar__item.weui-bar__item_on{background:none}
        .weui-btn_primary{background-color:$config[logincolor]}
        .weui-bar__item_on{position: relative}
        .weui-bar__item_on span:after {
            content: ' ';
            width: 12px;
            height: 4px;
            background: $config[logincolor];
            position: absolute;
            left: 50%;
            bottom:2px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            border-radius: 10px;
        }
        .weui-vcode-btn,.weui-bar__item_on span, .weui-vcode-btn:active{color:$config[logincolor]}
        .weui-navbar:after{border-bottom:none}
        .weui-navbar__item:after{top:15px;bottom:15px}
        $customstyle
    </style>
</head>
<body>
<div id="page-loading-overlay">
    <div class="ajxloading"></div>
</div>
{eval $loginhash = 'L'.random(4);}
<!-- userinfo start -->
<div class="container_map container_map_ami">

    <div class="weui-navbar">
        <!--{if !$_GET[lock]}-->
        <a href="plugin.php?id=xigua_login:reg&rb=0" class="weui-navbar__item <!--{if $_GET[rb]==0}-->weui-bar__item_on<!--{/if}-->">
            <span>$navtitle1</span>
        </a>
        <a href="plugin.php?id=xigua_login:reg&rb=1" class="weui-navbar__item <!--{if $_GET[rb]==1}-->weui-bar__item_on<!--{/if}-->">
            <span>$navtitle2</span>
        </a>
        <!--{else}-->
        <a href="plugin.php?id=xigua_login:reg&rb=1&lock=1" class="weui-navbar__item <!--{if $_GET[rb]==1}-->weui-bar__item_on<!--{/if}-->">
            <span>$navtitle2</span>
        </a>
        <!--{/if}-->
    </div>

    <!--{if $_GET[has]}-->
    <div class="weui-cells__title">{$config[confilt]}</div>
    <!--{else}-->
    <div class="weui-cells__title">{$tip}</div>
    <!--{/if}-->

    <form onsubmit="return recheck();" action="plugin.php?id=xigua_login:reg" method="post" <!--{if $config[charset]}-->accept-charset="{$config[charset]}"<!--{/if}-->>
        <input type="hidden" name="formhash" id="formhash" value='{FORMHASH}' />
        <input type="hidden" name="referer" id="referer" value="{$url}" />
        <input type="hidden" name="reg" value="1" />
        <input type="hidden" name="rb" value="$_GET[rb]" />

        <div class="">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input type="text" value="<!--{if $_GET[rb]==0|| $_GET[lock] }-->{$reg_nickname}<!--{/if}-->" tabindex="1" class="weui-input" size="30" autocomplete="off" name="username" placeholder="{lang inputyourname}" >
                    </div>
                </div>
                <!--{if $config[allowpassword]&& $_GET[rb]==0}-->
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" name="password" placeholder="{lang login_password}" >
                    </div>
                </div>
                <!--{/if}-->
                <!--{if $_GET[rb]!=0}-->
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="password" name="password" placeholder="{lang login_password}" >
                    </div>
                </div>

                <div class="weui-cell weui-cell_select">
                    <div class="weui-cell__bd">
                        <select id="questionid_{$loginhash}" name="questionid" class="weui-select sel_list">
                            <option value="0" selected="selected">{lang security_question}</option>
                            <option value="1">{lang security_question_1}</option>
                            <option value="2">{lang security_question_2}</option>
                            <option value="3">{lang security_question_3}</option>
                            <option value="4">{lang security_question_4}</option>
                            <option value="5">{lang security_question_5}</option>
                            <option value="6">{lang security_question_6}</option>
                            <option value="7">{lang security_question_7}</option>
                        </select>
                    </div>
                </div>

                <div class="weui-cell answerli" style="display:none">
                    <div class="weui-cell__bd">
                        <input type="text" name="answer" id="answer_{$loginhash}" class="weui-input" size="30" placeholder="{lang security_a}">
                    </div>
                </div>
                <!--{/if}-->

                <!--{if $config['smsAppKey'] && $config['smssecretKey'] && $config['smsFreeSignName'] && $config['smsTemplateCode']}-->
                <div class="weui-cell weui-cell_vcode">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="tel" id="mobile" name="mobile" placeholder="{lang xigua_login:plzinput}">
                    </div>
                    <div class="weui-cell__ft">
                        <button class="weui-vcode-btn" type="button" id="vcodebtn">{lang xigua_login:vcode_get}</button>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="tel" name="vrcode" id="vrcode" placeholder="{lang xigua_login:vcode_input}">
                    </div>
                </div>
                <!--{/if}-->



            </div>

        </div>
        <div class="weui-btn-area"><button tabindex="3" value="true" name="submit" type="submit" class="weui-btn weui-btn_primary"><span><!--{if $_GET[rb]==0}-->{lang xigua_login:newbtn}<!--{else}-->{lang xigua_login:bind}<!--{/if}--></span></button></div>

    </form>
</div>
<script src="source/plugin/xigua_login/static/custom.js"></script>
<script type="text/javascript">
    (function() {
        $(document).on('change', '.sel_list', function() {
            var obj = $(this);
            $('.span_question').text(obj.find('option:selected').text());
            if(obj.val() == 0) {
                $('.answerli').css('display', 'none');
            } else {
                $('.answerli').css('display', 'block');
            }
        });
    })();
    function recheck(){
        if($.trim($('input[name="username"]').val())==''){
            alert('{lang inputyourname}');
            return false;
        }
        if($('input[name="password"]').length>0){
            if($.trim($('input[name="password"]').val())==''){
                alert('{lang xigua_login:mimaempty}');
                return false;
            }
        }
        if($('#mobile').length>0){
            if($.trim($('#mobile').val())==''){
                alert('{lang xigua_login:plzinput}');
                return false;
            }
        }
        if($('#vrcode').length>0){
            if($.trim($('#vrcode').val())==''){
                alert('{lang xigua_login:vcode_input}');
                return false;
            }
        }
        return true;
    }
    var SMS_WAIT_TIME = 120;
    function sms_time() {
        var o = $('#vcodebtn');
        if (SMS_WAIT_TIME <= 0) {
            o.removeAttr("disabled");
            o.html("{lang xigua_login:vcode_get}");
            SMS_WAIT_TIME = 120;
        } else {
            o.attr("disabled", true);
            o.html("{lang xigua_login:vcode_again}(" + SMS_WAIT_TIME + ")");
            SMS_WAIT_TIME--;
            setTimeout(function() {
                sms_time();
            }, 1000);
        }
    }
    $(document).on('click', '#vcodebtn', function () {
        var mobile = $('#mobile').val();
        if(mobile){
            $.ajax({
                type: 'post',
                url: 'plugin.php?id=xigua_login:sendsms&inajax=1',
                data: {'formhash':'{FORMHASH}', 'mobile':mobile},
                dataType: 'xml',
                success: function (data) {
                    var s = data.lastChild.firstChild.nodeValue;
                    var er = s.split('|');
                    if(er[0]=='success'){
                        sms_time();
                    }else{
                        alert(er[1]);
                    }
                },
                error: function () {}
            });
        }else{
            alert('{lang xigua_login:plzinput}');
        }
    });
</script>
</body>
</html>