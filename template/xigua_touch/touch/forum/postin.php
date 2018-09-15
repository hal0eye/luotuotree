<?php exit('xxxx');?>




<div class="weui-cells weui-cells_form" style="background:none;margin-top:5px">
    <div class="input-inline weui-cell weui-cell_switch">
        <div id="postinbar" class="weui-cell__bd weui-flex" style="width:100%">
            <a id="smilie"><i class="iconfont icon-biaoqing"></i></a>
            <!--{if $_GET['mod']=='post'&&$_GET[action] != 'reply' }-->
            <a id="tag"><i class="iconfont icon-tag"></i></a>
            <!--{/if}-->
            <a id="yinyue"><i class="iconfont icon-yinle"></i></a>
            <a id="shipin"><i class="iconfont icon-x-mpg"></i></a>
        </div>
    </div>

    <div class="weui-cell postinbox" id="smilie-box">
        <div class="weui-cell__bd">
            <div class="weui-uploader">
                <div class="weui-flex" id="smilies-type">
                </div>
                <ul id="smilies">
                </ul>
            </div>
        </div>
    </div>


    <!--{if $_GET['mod']=='post'&&$_GET[action] != 'reply' }-->
    <div class="postinbox" id="tag-box">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" id="tags" name="tags" value="" placeholder="{echo xtl('shezhi');}">
            </div>
            <div class="weui-cell__ft">
                <a class="button2" onclick="return relatekw();">{echo xtl('zid');}</a>
            </div>
        </div>

        <label for="weuiAgree" class="weui-agree">
            <span class="weui-agree__text">{lang posttag_comment}</span>
        </label>
    </div>
    <!--{/if}-->

    <div class="postinbox" id="yinyue-box">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" id="yinyue-txt" value="" placeholder="{echo xtl('mp3');}">
            </div>
            <div class="weui-cell__ft">
                <a class="button2" onclick="return insertbyself('audio', 'yinyue');">{echo xtl('tianjia');}</a>
            </div>
        </div>

        <label for="weuiAgree" class="weui-agree">
            <span class="weui-agree__text">{echo xtl('grshi');}</span>
        </label>
    </div>

    <div class="postinbox" id="shipin-box">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" id="shipin-txt" value="" placeholder="{echo xtl('mp4');}">
            </div>
            <div class="weui-cell__ft">
                <a class="button2"  onclick="return insertbyself('media', 'shipin');">{echo xtl('tianjia');}</a>
            </div>
        </div>

        <label for="weuiAgree" class="weui-agree">
            <span class="weui-agree__text">{echo xtl('mp4desc');}</span>
        </label>
    </div>


</div>

<!--{template common/upload_js}-->
