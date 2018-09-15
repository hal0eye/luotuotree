<?php exit('xxxx');?>
<script src="data/cache/common_smilies_var.js?{VERHASH}" type="text/javascript"></script>
<script type="text/javascript">
    function insettomsg(obj, smilies) {
        var val = $('#needmessage').val();
        val += smilies;
        $('#needmessage').val(val);
        $(obj).addClass('hover').siblings().removeClass('hover');
        return false;
    }
    var tyhtml = '';
    var smilieshtml = '';
    for (var i in smilies_type) {
        var tmphtml = '';
        var type = i.substring(1);
        var page = 1;
        if (smilies_type[i][0]) {
            s = smilies_array[type][page][0];
            smilieimg = STATICURL + 'image/smiley/' + smilies_type['_' + type][1] + '/' + s[2];
            tyhtml += '<div class="placeholder"><img src="' + smilieimg + '"></div>';

            for (var j = 0; j < smilies_array[type][page].length; j++) {
                smilieimg = STATICURL + 'image/smiley/' + smilies_type['_' + type][1] + '/' + smilies_array[type][page][j][2];
                tmphtml += '<a href="javascript:;" onclick="return insettomsg(this,\'' + smilies_array[type][page][j][1].replace(/'/, '\\\'') + '\')"><img src="' + smilieimg + '"></a>';
            }
            smilieshtml += "<li class='cl'>" + tmphtml + "</li>";
        }
    }
    $('#smilies-type').prepend(tyhtml);
    $('#smilies').html(smilieshtml);

    $('.placeholder:first').addClass('on');
    $('#smilies li:first').addClass('on');

    $('.placeholder').on('touchstart', function () {
        $(this).addClass('on').siblings().removeClass('on');
        $('#smilies li').eq($(this).index()).addClass('on').siblings().removeClass('on');
    });

    var postinbar = $('#postinbar a');
    postinbar.on('touchstart', function () {
        var me = $(this);
        var meid = '#'+me.attr('id');
        postinbar.not(meid).removeClass('color_11');
        me.toggleClass('color_11');
        $('.postinbox').not(meid+'-box').hide();
        $(meid+'-box').slideToggle('fast');
    });
    function insertbyself(type, id) {
        var bval = $.trim($('#'+id+'-txt').val());
        if(!bval){
            return ;
        }
        var val = $('#needmessage').val();
        val += "["+type+"]"+bval+"[/"+type+"]\n";
        $('#needmessage').val(val);
        $('#'+id+'-txt').val('');
    }

    function cnCode(str) {
        str = str.replace(/<\/?[^>]+>|\[\/?.+?\]|"/ig, "");
        str = str.replace(/\s{2,}/ig, ' ');
        return str;
    }
    function relatekw() {

        var subject = cnCode($('#needsubject').val());
        var message = cnCode($('#needmessage').val());
        message = message.replace(/&/ig, '', message);

        jQuery.ajax({
            type: 'POST',
            url: 'forum.php?mod=relatekw&form=mobile&inajax=1',
            data: {subjectenc:subject,messageenc:message},
            dataType: 'xml'
        }).success(function (s) {
            if(s.lastChild.firstChild.nodeValue){
                $("#tags").val(s.lastChild.firstChild.nodeValue);
            }
        });


    }

</script>
<script type="text/javascript">
    (function () {
        var needsubject = needmessage = false;
        setTimeout(function(){
            $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
            $('.btn_pn').attr('disable', 'false');
        }, 500);

        <!--{if $_GET[action] == 'reply'}-->
        needsubject = true;
        <!--{elseif $_GET[action] == 'edit'}-->
        needsubject = needmessage = true;
        <!--{/if}-->

        <!--{if $_GET[action] == 'newthread' || ($_GET[action] == 'edit' && $isfirstpost)}-->
        $('#needsubject').on('keyup input', function () {
            var obj = $(this);
            if (obj.val()) {
                needsubject = true;
                if (needmessage == true) {
                    $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                    $('.btn_pn').attr('disable', 'false');
                }
            } else {
                needsubject = false;
                $('.btn_pn').removeClass('weui-btn_primary').addClass('weui-btn_disabled');
                $('.btn_pn').attr('disable', 'true');
            }
        });
        <!--{/if}-->
        $('#needmessage').on('keyup input', function () {
            var obj = $(this);
            if (obj.val()) {
                needmessage = true;
                if (needsubject == true) {
                    $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                    $('.btn_pn').attr('disable', 'false');
                }
            } else {
                needmessage = false;
                $('.btn_pn').removeClass('weui-btn_primary').addClass('weui-btn_disabled');
                $('.btn_pn').attr('disable', 'true');
            }
        });

        $('#needmessage').on('scroll', function () {
            var obj = $(this);
            if (obj.scrollTop() > 0) {
                obj.attr('rows', parseInt(obj.attr('rows')) + 2);
            }
        }).scrollTop($(document).height());
    })();
</script>
<script type="text/javascript" src="{STATICURL}js/mobile/ajaxfileupload.js?{VERHASH}"></script>
<script type="text/javascript" src="{STATICURL}js/mobile/buildfileupload.js?{VERHASH}"></script>
<script type="text/javascript">
    var imgexts = typeof imgexts == 'undefined' ? 'jpg, jpeg, gif, png' : imgexts;
    var STATUSMSG = {
        '-1': '{lang uploadstatusmsgnag1}',
        '0': '{lang uploadstatusmsg0}',
        '1': '{lang uploadstatusmsg1}',
        '2': '{lang uploadstatusmsg2}',
        '3': '{lang uploadstatusmsg3}',
        '4': '{lang uploadstatusmsg4}',
        '5': '{lang uploadstatusmsg5}',
        '6': '{lang uploadstatusmsg6}',
        '7': '{lang uploadstatusmsg7}(' + imgexts + ')',
        '8': '{lang uploadstatusmsg8}',
        '9': '{lang uploadstatusmsg9}',
        '10': '{lang uploadstatusmsg10}',
        '11': '{lang uploadstatusmsg11}'
    };
    var form = $('#postform');
    $(document).on('change', '#filedata', function () {
        popup.open('<img src="' + IMGDIR + '/imageloading.gif" class="imageloading">');

        uploadsuccess = function (data) {
            if (data == '') {
                popup.open('{lang uploadpicfailed}', 'alert');
            }
            var dataarr = data.split('|');
            if (dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
                popup.close();
                $('#imglist').append('<li><span aid="' + dataarr[3] + '" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;"><img style="height:54px;width:54px;" id="aimg_' + dataarr[3] + '" title="' + dataarr[6] + '" src="{$_G[setting][attachurl]}forum/' + dataarr[5] + '" /></a></span><input type="hidden" name="attachnew[' + dataarr[3] + '][description]" /></li>');
            } else {
                var sizelimit = '';
                if (dataarr[7] == 'ban') {
                    sizelimit = '{lang uploadpicatttypeban}';
                } else if (dataarr[7] == 'perday') {
                    sizelimit = '{lang donotcross}' + Math.ceil(dataarr[8] / 1024) + 'K)';
                } else if (dataarr[7] > 0) {
                    sizelimit = '{lang donotcross}' + Math.ceil(dataarr[7] / 1024) + 'K)';
                }
                popup.open(STATUSMSG[dataarr[2]] + sizelimit, 'alert');
            }
        };

        if (typeof FileReader != 'undefined' && this.files[0]) {

            $.buildfileupload({
                uploadurl: 'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
                files: this.files,
                uploadformdata: {
                    uid: "$_G[uid]",
                    hash: "<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"
                },
                uploadinputname: 'Filedata',
                maxfilesize: "$swfconfig[max]",
                success: uploadsuccess,
                error: function () {
                    popup.open('{lang uploadpicfailed}', 'alert');
                    $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                    $('.btn_pn').attr('disable', 'false');
                }
            });

        } else {

            $.ajaxfileupload({
                url: 'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
                data: {
                    uid: "$_G[uid]",
                    hash: "<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"
                },
                dataType: 'text',
                fileElementId: 'filedata',
                success: uploadsuccess,
                error: function () {
                    popup.open('{lang uploadpicfailed}', 'alert');
                    $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                    $('.btn_pn').attr('disable', 'false');
                }
            });

        }
    });

    <!--{if 0 && $_G['setting']['mobile']['geoposition']}-->
    geo.getcurrentposition();
    <!--{/if}-->
    $('#postform').on('submit', function () {
        var obj = $('#postsubmit');
        if (obj.attr('disable') == 'true') {
            return false;
        }

        if(typeof EXTRAFUNC != 'undefined'){

            for(i in EXTRAFUNC['validator']) {
                try {
                    eval('var v = ' + EXTRAFUNC['validator'][i] + '()');
                    if(!v) {
                        return false;
                    }
                } catch(e) {}
            }
        }

        obj.attr('disable', 'true').removeClass('weui-btn_primary').addClass('weui-btn_disabled');
        popup.open('<img src="' + IMGDIR + '/imageloading.gif" class="imageloading">');

        var postlocation = '';
        if (geo.errmsg === '' && geo.loc) {
            postlocation = geo.longitude + '|' + geo.latitude + '|' + geo.loc;
        }

        $.ajax({
            type: 'POST',
            url: form.attr('action') + '&geoloc=' + postlocation + '&handlekey=' + form.attr('id') + '&inajax=1',
            data: form.serialize(),
            dataType: 'xml'
        })
            .success(function (s) {
                popup.open(s.lastChild.firstChild.nodeValue);
                $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                $('.btn_pn').attr('disable', 'false');
            })
            .error(function () {
                popup.open(s.lastChild.firstChild.nodeValue);
                $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                $('.btn_pn').attr('disable', 'false');
            });
        return false;
    });

    $(document).on('click', '.del', function () {
        var obj = $(this);
        $.ajax({
            type: 'GET',
            url: 'forum.php?mod=ajax&action=deleteattach&inajax=yes&aids[]=' + obj.attr('aid'),
        })
            .success(function (s) {
                obj.parent().remove();
                $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                $('.btn_pn').attr('disable', 'false');
            })
            .error(function () {
                obj.parent().remove();
                $('.btn_pn').removeClass('weui-btn_disabled').addClass('weui-btn_primary');
                $('.btn_pn').attr('disable', 'false');
            });
        return false;
    });

</script>
