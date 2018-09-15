/**
 * Created by yzg on 2015/8/3.
 */
function idecre(){
    var itext = document.getElementById('itxt');
    if(!itext.value){
        itext.value = 0;
    }

    if(itext.value>min){
        itext.value = parseInt(itext.value) -1;
    }else{
        renum(itext, 1);
    }
}
function iincre(){
    var itext = document.getElementById('itxt');

    if(itext.value<max){
        if(!itext.value){
            itext.value = min;
        }else{
            itext.value = parseInt(itext.value) +1;
        }
    }else{
        renum(itext, 1);
    }
}
function renum(obj, out){
    obj.value=obj.value.replace(/[^\d]/g,'');
    /*setTimeout(function(){
        if(obj.value<min){
            obj.value = min;
        }
        if(obj.value>max){
            obj.value=max;
        }
    }, out);*/
}