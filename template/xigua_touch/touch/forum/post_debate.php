<?php exit('xxxxx');?>

<div class="sorttable cl" style="background:transparent;margin-top:12px;margin-bottom:12px">
    <div class="weui-cells__title">{lang debate_square_point}</div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea name="affirmpoint" id="affirmpoint" class="weui-textarea">$debate[affirmpoint]</textarea>
            </div>
        </div>
    </div>


    <div class="weui-cells__title">{lang debate_opponent_point}</div>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <textarea name="negapoint" id="negapoint" class="weui-textarea">$debate[negapoint]</textarea>
            </div>
        </div>
    </div>

    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">{lang endtime}</label></div>
            <div class="weui-cell__bd">
                <input type="text" name="endtime" placeholder="{echo xtl('datetime_format')}2016-01-25" id="endtime" class="weui-input" autocomplete="off" value="$debate[endtime]"  />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">{lang debate_umpire}</label></div>
            <div class="weui-cell__bd">
                <input type="text" name="umpire" id="umpire" class="weui-input" value="$debate[umpire]"  />
            </div>
        </div>




    </div>

</div>

