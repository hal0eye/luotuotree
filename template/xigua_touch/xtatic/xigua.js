/**
 * Created by yzg on 2016/12/27.
 */
;(function(){'use strict';function FastClick(layer,options){var oldOnClick;options=options||{};this.trackingClick=false;this.trackingClickStart=0;this.targetElement=null;this.touchStartX=0;this.touchStartY=0;this.lastTouchIdentifier=0;this.touchBoundary=options.touchBoundary||10;this.layer=layer;this.tapDelay=options.tapDelay||200;this.tapTimeout=options.tapTimeout||700;if(FastClick.notNeeded(layer)){return}function bind(method,context){return function(){return method.apply(context,arguments)}}var methods=['onMouse','onClick','onTouchStart','onTouchMove','onTouchEnd','onTouchCancel'];var context=this;for(var i=0,l=methods.length;i<l;i++){context[methods[i]]=bind(context[methods[i]],context)}if(deviceIsAndroid){layer.addEventListener('mouseover',this.onMouse,true);layer.addEventListener('mousedown',this.onMouse,true);layer.addEventListener('mouseup',this.onMouse,true)}layer.addEventListener('click',this.onClick,true);layer.addEventListener('touchstart',this.onTouchStart,false);layer.addEventListener('touchmove',this.onTouchMove,false);layer.addEventListener('touchend',this.onTouchEnd,false);layer.addEventListener('touchcancel',this.onTouchCancel,false);if(!Event.prototype.stopImmediatePropagation){layer.removeEventListener=function(type,callback,capture){var rmv=Node.prototype.removeEventListener;if(type==='click'){rmv.call(layer,type,callback.hijacked||callback,capture)}else{rmv.call(layer,type,callback,capture)}};layer.addEventListener=function(type,callback,capture){var adv=Node.prototype.addEventListener;if(type==='click'){adv.call(layer,type,callback.hijacked||(callback.hijacked=function(event){if(!event.propagationStopped){callback(event)}}),capture)}else{adv.call(layer,type,callback,capture)}}}if(typeof layer.onclick==='function'){oldOnClick=layer.onclick;layer.addEventListener('click',function(event){oldOnClick(event)},false);layer.onclick=null}}var deviceIsWindowsPhone=navigator.userAgent.indexOf("Windows Phone")>=0;var deviceIsAndroid=navigator.userAgent.indexOf('Android')>0&&!deviceIsWindowsPhone;var deviceIsIOS=/iP(ad|hone|od)/.test(navigator.userAgent)&&!deviceIsWindowsPhone;var deviceIsIOS4=deviceIsIOS&&(/OS 4_\d(_\d)?/).test(navigator.userAgent);var deviceIsIOSWithBadTarget=deviceIsIOS&&(/OS [6-7]_\d/).test(navigator.userAgent);var deviceIsBlackBerry10=navigator.userAgent.indexOf('BB10')>0;FastClick.prototype.needsClick=function(target){switch(target.nodeName.toLowerCase()){case'button':case'select':case'textarea':if(target.disabled){return true}break;case'input':if((deviceIsIOS&&target.type==='file')||target.disabled){return true}break;case'label':case'iframe':case'video':return true}return(/\bneedsclick\b/).test(target.className)};FastClick.prototype.needsFocus=function(target){switch(target.nodeName.toLowerCase()){case'textarea':return true;case'select':return!deviceIsAndroid;case'input':switch(target.type){case'button':case'checkbox':case'file':case'image':case'radio':case'submit':return false}return!target.disabled&&!target.readOnly;default:return(/\bneedsfocus\b/).test(target.className)}};FastClick.prototype.sendClick=function(targetElement,event){var clickEvent,touch;if(document.activeElement&&document.activeElement!==targetElement){document.activeElement.blur()}touch=event.changedTouches[0];clickEvent=document.createEvent('MouseEvents');clickEvent.initMouseEvent(this.determineEventType(targetElement),true,true,window,1,touch.screenX,touch.screenY,touch.clientX,touch.clientY,false,false,false,false,0,null);clickEvent.forwardedTouchEvent=true;targetElement.dispatchEvent(clickEvent)};FastClick.prototype.determineEventType=function(targetElement){if(deviceIsAndroid&&targetElement.tagName.toLowerCase()==='select'){return'mousedown'}return'click'};FastClick.prototype.focus=function(targetElement){var length;if(deviceIsIOS&&targetElement.setSelectionRange&&targetElement.type.indexOf('date')!==0&&targetElement.type!=='time'&&targetElement.type!=='month'){length=targetElement.value.length;targetElement.setSelectionRange(length,length)}else{targetElement.focus()}};FastClick.prototype.updateScrollParent=function(targetElement){var scrollParent,parentElement;scrollParent=targetElement.fastClickScrollParent;if(!scrollParent||!scrollParent.contains(targetElement)){parentElement=targetElement;do{if(parentElement.scrollHeight>parentElement.offsetHeight){scrollParent=parentElement;targetElement.fastClickScrollParent=parentElement;break}parentElement=parentElement.parentElement}while(parentElement)}if(scrollParent){scrollParent.fastClickLastScrollTop=scrollParent.scrollTop}};FastClick.prototype.getTargetElementFromEventTarget=function(eventTarget){if(eventTarget.nodeType===Node.TEXT_NODE){return eventTarget.parentNode}return eventTarget};FastClick.prototype.onTouchStart=function(event){var targetElement,touch,selection;if(event.targetTouches.length>1){return true}targetElement=this.getTargetElementFromEventTarget(event.target);touch=event.targetTouches[0];if(deviceIsIOS){selection=window.getSelection();if(selection.rangeCount&&!selection.isCollapsed){return true}if(!deviceIsIOS4){if(touch.identifier&&touch.identifier===this.lastTouchIdentifier){event.preventDefault();return false}this.lastTouchIdentifier=touch.identifier;this.updateScrollParent(targetElement)}}this.trackingClick=true;this.trackingClickStart=event.timeStamp;this.targetElement=targetElement;this.touchStartX=touch.pageX;this.touchStartY=touch.pageY;if((event.timeStamp-this.lastClickTime)<this.tapDelay){event.preventDefault()}return true};FastClick.prototype.touchHasMoved=function(event){var touch=event.changedTouches[0],boundary=this.touchBoundary;if(Math.abs(touch.pageX-this.touchStartX)>boundary||Math.abs(touch.pageY-this.touchStartY)>boundary){return true}return false};FastClick.prototype.onTouchMove=function(event){if(!this.trackingClick){return true}if(this.targetElement!==this.getTargetElementFromEventTarget(event.target)||this.touchHasMoved(event)){this.trackingClick=false;this.targetElement=null}return true};FastClick.prototype.findControl=function(labelElement){if(labelElement.control!==undefined){return labelElement.control}if(labelElement.htmlFor){return document.getElementById(labelElement.htmlFor)}return labelElement.querySelector('button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea')};FastClick.prototype.onTouchEnd=function(event){var forElement,trackingClickStart,targetTagName,scrollParent,touch,targetElement=this.targetElement;if(!this.trackingClick){return true}if((event.timeStamp-this.lastClickTime)<this.tapDelay){this.cancelNextClick=true;return true}if((event.timeStamp-this.trackingClickStart)>this.tapTimeout){return true}this.cancelNextClick=false;this.lastClickTime=event.timeStamp;trackingClickStart=this.trackingClickStart;this.trackingClick=false;this.trackingClickStart=0;if(deviceIsIOSWithBadTarget){touch=event.changedTouches[0];targetElement=document.elementFromPoint(touch.pageX-window.pageXOffset,touch.pageY-window.pageYOffset)||targetElement;targetElement.fastClickScrollParent=this.targetElement.fastClickScrollParent}targetTagName=targetElement.tagName.toLowerCase();if(targetTagName==='label'){forElement=this.findControl(targetElement);if(forElement){this.focus(targetElement);if(deviceIsAndroid){return false}targetElement=forElement}}else if(this.needsFocus(targetElement)){if((event.timeStamp-trackingClickStart)>100||(deviceIsIOS&&window.top!==window&&targetTagName==='input')){this.targetElement=null;return false}this.focus(targetElement);this.sendClick(targetElement,event);if(!deviceIsIOS||targetTagName!=='select'){this.targetElement=null;event.preventDefault()}return false}if(deviceIsIOS&&!deviceIsIOS4){scrollParent=targetElement.fastClickScrollParent;if(scrollParent&&scrollParent.fastClickLastScrollTop!==scrollParent.scrollTop){return true}}if(!this.needsClick(targetElement)){event.preventDefault();this.sendClick(targetElement,event)}return false};FastClick.prototype.onTouchCancel=function(){this.trackingClick=false;this.targetElement=null};FastClick.prototype.onMouse=function(event){if(!this.targetElement){return true}if(event.forwardedTouchEvent){return true}if(!event.cancelable){return true}if(!this.needsClick(this.targetElement)||this.cancelNextClick){if(event.stopImmediatePropagation){event.stopImmediatePropagation()}else{event.propagationStopped=true}event.stopPropagation();event.preventDefault();return false}return true};FastClick.prototype.onClick=function(event){var permitted;if(this.trackingClick){this.targetElement=null;this.trackingClick=false;return true}if(event.target.type==='submit'&&event.detail===0){return true}permitted=this.onMouse(event);if(!permitted){this.targetElement=null}return permitted};FastClick.prototype.destroy=function(){var layer=this.layer;if(deviceIsAndroid){layer.removeEventListener('mouseover',this.onMouse,true);layer.removeEventListener('mousedown',this.onMouse,true);layer.removeEventListener('mouseup',this.onMouse,true)}layer.removeEventListener('click',this.onClick,true);layer.removeEventListener('touchstart',this.onTouchStart,false);layer.removeEventListener('touchmove',this.onTouchMove,false);layer.removeEventListener('touchend',this.onTouchEnd,false);layer.removeEventListener('touchcancel',this.onTouchCancel,false)};FastClick.notNeeded=function(layer){var metaViewport;var chromeVersion;var blackberryVersion;var firefoxVersion;if(typeof window.ontouchstart==='undefined'){return true}chromeVersion=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1];if(chromeVersion){if(deviceIsAndroid){metaViewport=document.querySelector('meta[name=viewport]');if(metaViewport){if(metaViewport.content.indexOf('user-scalable=no')!==-1){return true}if(chromeVersion>31&&document.documentElement.scrollWidth<=window.outerWidth){return true}}}else{return true}}if(deviceIsBlackBerry10){blackberryVersion=navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/);if(blackberryVersion[1]>=10&&blackberryVersion[2]>=3){metaViewport=document.querySelector('meta[name=viewport]');if(metaViewport){if(metaViewport.content.indexOf('user-scalable=no')!==-1){return true}if(document.documentElement.scrollWidth<=window.outerWidth){return true}}}}if(layer.style.msTouchAction==='none'||layer.style.touchAction==='manipulation'){return true}firefoxVersion=+(/Firefox\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1];if(firefoxVersion>=27){metaViewport=document.querySelector('meta[name=viewport]');if(metaViewport&&(metaViewport.content.indexOf('user-scalable=no')!==-1||document.documentElement.scrollWidth<=window.outerWidth)){return true}}if(layer.style.touchAction==='none'||layer.style.touchAction==='manipulation'){return true}return false};FastClick.attach=function(layer,options){return new FastClick(layer,options)};if(typeof define==='function'&&typeof define.amd==='object'&&define.amd){define(function(){return FastClick})}else if(typeof module!=='undefined'&&module.exports){module.exports=FastClick.attach;module.exports.FastClick=FastClick}else{window.FastClick=FastClick}}());
function Swipe2(e,t){"use strict";function h(){o=s.children,f=o.length,o.length<2&&(t.continuous=!1),i.transitions&&t.continuous&&o.length<3&&(s.appendChild(o[0].cloneNode(!0)),s.appendChild(s.children[1].cloneNode(!0)),o=s.children),u=new Array(o.length),a=e.getBoundingClientRect().width||e.offsetWidth,s.style.width=o.length*a+"px";var n=o.length;while(n--){var r=o[n];r.style.width=a+"px",r.setAttribute("data-index",n),i.transitions&&(r.style.left=n*-a+"px",g(n,l>n?-a:l<n?a:0,0))}t.continuous&&i.transitions&&(g(v(l-1),-a,0),g(v(l+1),a,0)),i.transitions||(s.style.left=l*-a+"px"),e.style.visibility="visible"}function p(){t.continuous?m(l-1):l&&m(l-1)}function d(){t.continuous?m(l+1):l<o.length-1&&m(l+1)}function v(e){return(o.length+e%o.length)%o.length}function m(e,n){if(l==e)return;if(i.transitions){var s=Math.abs(l-e)/(l-e);if(t.continuous){var f=s;s=-u[v(e)]/a,s!==f&&(e=-s*o.length+e)}var h=Math.abs(l-e)-1;while(h--)g(v((e>l?e:l)-h-1),a*s,0);e=v(e),g(l,a*s,n||c),g(e,0,n||c),t.continuous&&g(v(e-s),-(a*s),0)}else e=v(e),b(l*-a,e*-a,n||c);l=e,r(t.callback&&t.callback(l,o[l]))}function g(e,t,n){y(e,t,n),u[e]=t}function y(e,t,n){var r=o[e],i=r&&r.style;if(!i)return;i.webkitTransitionDuration=i.MozTransitionDuration=i.msTransitionDuration=i.OTransitionDuration=i.transitionDuration=n+"ms",i.webkitTransform="translate("+t+"px,0)"+"translateZ(0)",i.msTransform=i.MozTransform=i.OTransform="translateX("+t+"px)",i.display="table-cell",i.verticalAlign="top"}function b(e,n,r){if(!r){s.style.left=n+"px";return}var i=+(new Date),u=setInterval(function(){var a=+(new Date)-i;if(a>r){s.style.left=n+"px",w&&S(),t.transitionEnd&&t.transitionEnd.call(event,l,o[l]),clearInterval(u);return}s.style.left=(n-e)*(Math.floor(a/r*100)/100)+e+"px"},4)}function S(){E=setTimeout(d,w)}function x(){w=0,clearTimeout(E)}var n=function(){},r=function(e){setTimeout(e||n,0)},i={addEventListener:!!window.addEventListener,touch:"ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch,transitions:function(e){var t=["transitionProperty","WebkitTransition","MozTransition","OTransition","msTransition"];for(var n in t)if(e.style[t[n]]!==undefined)return!0;return!1}(document.createElement("swipe"))};if(!e)return;var s=e.children[0],o,u,a,f;t=t||{};var l=parseInt(t.startSlide,10)||0,c=t.speed||300;t.continuous=t.continuous!==undefined?t.continuous:!0;var w=t.auto||0,E,T={},N={},C,k={handleEvent:function(e){switch(e.type){case"touchstart":this.start(e);break;case"touchmove":this.move(e);break;case"touchend":r(this.end(e));break;case"webkitTransitionEnd":case"msTransitionEnd":case"oTransitionEnd":case"otransitionend":case"transitionend":r(this.transitionEnd(e));break;case"resize":r(h.call())}t.stopPropagation&&e.stopPropagation()},start:function(e){var t=e.touches[0];T={x:t.pageX,y:t.pageY,time:+(new Date)},C=undefined,N={},s.addEventListener("touchmove",this,!1),s.addEventListener("touchend",this,!1)},move:function(e){if(e.touches.length>1||e.scale&&e.scale!==1)return;t.disableScroll&&e.preventDefault();var n=e.touches[0];N={x:n.pageX-T.x,y:n.pageY-T.y},typeof C=="undefined"&&(C=!!(C||Math.abs(N.x)<Math.abs(N.y))),C||(e.preventDefault(),x(),w=t.auto||0,w&&(E=setTimeout(d,w)),clearTimeout(E),t.continuous?(y(v(l-1),N.x+u[v(l-1)],0),y(l,N.x+u[l],0),y(v(l+1),N.x+u[v(l+1)],0)):(N.x=N.x/(!l&&N.x>0||l==o.length-1&&N.x<0?Math.abs(N.x)/a+1:1),y(l-1,N.x+u[l-1],0),y(l,N.x+u[l],0),y(l+1,N.x+u[l+1],0)))},end:function(e){var n=+(new Date)-T.time,r=Number(n)<250&&Math.abs(N.x)>20||Math.abs(N.x)>a/2,i=!l&&N.x>0||l==o.length-1&&N.x<0;t.continuous&&(i=!1);var f=N.x<0;C||(r&&!i?(f?(t.continuous?(g(v(l-1),-a,0),g(v(l+2),a,0)):g(l-1,-a,0),g(l,u[l]-a,c),g(v(l+1),u[v(l+1)]-a,c),l=v(l+1)):(t.continuous?(g(v(l+1),a,0),g(v(l-2),-a,0)):g(l+1,a,0),g(l,u[l]+a,c),g(v(l-1),u[v(l-1)]+a,c),l=v(l-1)),t.callback&&t.callback(l,o[l])):t.continuous?(g(v(l-1),-a,c),g(l,0,c),g(v(l+1),a,c)):(g(l-1,-a,c),g(l,0,c),g(l+1,a,c))),s.removeEventListener("touchmove",k,!1),s.removeEventListener("touchend",k,!1)},transitionEnd:function(e){parseInt(e.target.getAttribute("data-index"),10)==l&&(w&&S(),t.transitionEnd&&t.transitionEnd.call(e,l,o[l]))}};return h(),w&&S(),i.addEventListener?(i.touch&&s.addEventListener("touchstart",k,!1),i.transitions&&(s.addEventListener("webkitTransitionEnd",k,!1),s.addEventListener("msTransitionEnd",k,!1),s.addEventListener("oTransitionEnd",k,!1),s.addEventListener("otransitionend",k,!1),s.addEventListener("transitionend",k,!1)),window.addEventListener("resize",k,!1)):window.onresize=function(){h()},{setup:function(){h()},slide:function(e,t){x(),m(e,t)},prev:function(){x(),p(),w=t.auto||0,w&&(E=setTimeout(p,w)),clearTimeout(E)},next:function(){x(),d(),w=t.auto||0,w&&(E=setTimeout(d,w)),clearTimeout(E)},getPos:function(){return l},getNumSlides:function(){return f},kill:function(){x(),s.style.width="auto",s.style.left=0;var e=o.length;while(e--){var t=o[e];t.style.width="100%",t.style.left=0,i.transitions&&y(e,0,0)}i.addEventListener?(s.removeEventListener("touchstart",k,!1),s.removeEventListener("webkitTransitionEnd",k,!1),s.removeEventListener("msTransitionEnd",k,!1),s.removeEventListener("oTransitionEnd",k,!1),s.removeEventListener("otransitionend",k,!1),s.removeEventListener("transitionend",k,!1),window.removeEventListener("resize",k,!1)):window.onresize=null}}}(window.jQuery||window.Zepto)&&function(e){e.fn.Swipe=function(t){return this.each(function(){e(this).data("Swipe",new Swipe(e(this)[0],t))})}}(window.jQuery||window.Zepto);

var add_praiseTID = null;
function errorhandle_recommend_add(msg, obj) {
    msg = $.trim(msg);
    if(add_praiseTID !== null && (obj.recommendv||VOTESUCCEED==msg) ){
        if(isNaN(obj.recommendv)){
            obj.recommendv = 1;
        }

        var old = parseInt(add_praiseTID.find('.praise_num').text());
        if(isNaN(old)){
            old = 0;
        }
        var neww =(old+ parseInt(obj.recommendv));
        console.log(old);
        console.log(neww);

        add_praiseTID.addClass('zan').find('.praise_num').text(neww);
        if(add_praiseTID.hasClass('praise_link')){
            $('.praise_link').addClass('zan').find('.praise_num').text(neww);
        }
    }else{
        popup.open('<div class="tip"><dt id="messagetext"><p>'+msg+'<p><div class="tipbtn"><input type="button" class="button" onclick="popup.close();" value="'+CLOSEBTXT+'"></div></dt></div>');
        setTimeout(function () {
            popup.close();
        }, 2000);
    }
}
function showFastform(){
    if(discuz_uid<1){
        window.location.href= 'member.php?mod=logging&action=login&referer='+encodeURIComponent(window.location.href+'&showFastform=1');
    }else{
        $('.fastpostbox').show();
    }
    return false;
}
function hideFastform(){
    $('.fastpostbox').fadeOut();
    return false;
}

$(function () {
    $("img.lazy").lazyload({
        effect : "fadeIn"
    });
    if(!NOFASKCLICK){
        FastClick.attach(document.body);
    }

    if(window.location.href.indexOf('showFastform=1')!=-1&&discuz_uid>0){
        history.pushState({}, '', window.location.href.replace('&showFastform=1', ''));
        showFastform();
    }
    $('.js_category').on('click', function () {
        $(this).parent().toggleClass('js_show');
        $(this).find('.morefilter').toggleClass('expanded');
    });

    var $iosActionsheet = $('#touch_iosActionsheet');
    var $iosMask = $('#iosMask');

    function touch_hideActionSheet() {
        $iosActionsheet.removeClass($iosActionsheet.attr('data-id'));
        $iosActionsheet.find('div').hide();
        $iosMask.fadeOut(200);
    }

    $iosMask.on('click', touch_hideActionSheet);
    $iosActionsheet.find('div').on('click', touch_hideActionSheet);
    $("#showIOSActionSheet").on("click", function(){
        $iosActionsheet.addClass($iosActionsheet.attr('data-id'));
        $iosActionsheet.find('div').fadeIn();
        $iosMask.fadeIn(200);
    });

    $('.morefilter_a').on('click', function () {
        $('.morefilter').addClass('expanded');
        $('.nav_expand_panel').addClass('show');
    });
    $('#nav_expand_panel_hide').on('click', function () {
        $('.morefilter').removeClass('expanded');
        $('.nav_expand_panel').removeClass('show');
    });

    $(document).on('click', '.add_praise', function() {
        add_praiseTID = $(this);
        $.ajax({
            type : 'GET',
            url : $(this).attr('href') + '&inajax=1',
            dataType : 'xml'
        })
        .success(function(s) {
            var s1 = s.lastChild.firstChild.nodeValue;
            console.log(discuz_uid);
            if(discuz_uid> 0){
                evalscript(s1);
            }else{
                popup.open(s1);
                evalscript(s1);
            }
        })
        .error(function() {
            window.location.href = add_praiseTID.attr('href');
            popup.close();
        });
        return false;
    });

    $(document).on('click', '.sidemask, .sidectrl', function () {
        if($('html').hasClass("openside")){
            $('html').removeClass('openside').addClass('closeside');
        }else{
            $('html').removeClass('closeside').addClass('openside');
        }
    });

    function runslider(_this,auto){
        var bullets = _this.find('nav.bullets');var position = _this.find('ul.position');
        new Swipe2(_this[0], {startSlide: 0,speed: 500,auto:auto,continuous:true,callback:function(index){if(bullets.length>0){bullets.find('em:first-child').text(index+1);} if(position.length>0){var selectors=position[0].children;
            for(var t=0;t<selectors.length;t++){selectors[t].className=selectors[t].className.replace("current","");} selectors[(index)%(selectors.length)].className="current";}}});
    }
    $('div.swipe').each(function(){runslider($(this),3000);$(this).css('height','auto');});
    $('nav.swipe').each(function(){runslider($(this),0);$(this).css('height','auto');});

    jQuery(window).scroll(function () {
        var top = (jQuery(document).height() - jQuery(this).scrollTop() - jQuery(this).height());
        if(jQuery(this).scrollTop()>=42){
            jQuery('.banner').addClass('dofixed');
        }else{
            jQuery('.banner').removeClass('dofixed');
        }
    });
});