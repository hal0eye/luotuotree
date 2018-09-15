jQuery(function () {
	var liCur = jQuery("#nv>ul>li.a"),
		curP = liCur.position().left,
		curW = liCur.outerWidth(true),
		slider = jQuery(".navsign"),
		targetEle = jQuery("#nv>ul>li:not('.last')"),
		navBox = jQuery("#nv");
	slider.stop(true, true).animate({
		"left" : curP,
		"width" : curW
	});
	targetEle.mouseenter(function () {
		var _parent = jQuery(this);//.parent(),
		_width = _parent.outerWidth(true),
		posL = _parent.position().left;
		slider.stop(true, true).animate({
			"left" : posL,
			"width" : _width
		}, "fast");
	});
	navBox.mouseleave(function (cur, wid) {
		cur = curP;
		wid = curW;
		slider.stop(true, true).animate({
			"left" : cur,
			"width" : wid
		}, "fast");
	});
});
