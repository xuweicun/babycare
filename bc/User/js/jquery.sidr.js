/*
* Sidr
* https://github.com/artberri/sidr
*
* Copyright (c) 2013 Alberto Varela
* Licensed under the MIT license.
*/
;(function( $ ){//前面加；，防止不被换行？
var sidrMoving = false,//操作锁定变量，判断上一次移动是否已经完成，若正在移动则不进行移动操作；
sidrOpened = false;
// Private methods
var privateMethods = {
		// Check for valids urls 私有函数
		// From : http://stackoverflow.com/questions/5717093/check-if-a-javascript-string-is-an-url
		isUrl: function (str) {
		var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
		'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
		'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
		'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
		'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
		if(!pattern.test(str)) {
		return false;
		} else {
		return true;
		}
		},
		// Loads the content into the menu bar 
		loadContent: function($menu, content) {
		$menu.html(content);
		},
		// Add sidr prefixes 为元素的id和class增加sidr-id前缀；移除style标签；
		addPrefix: function($element) {
		var elementId = $element.attr('id'),
		elementClass = $element.attr('class');
		if(typeof elementId === 'string' && '' !== elementId) {
		$element.attr('id', elementId.replace(/([A-Za-z0-9_.\-]+)/g, 'sidr-id-$1'));
		}
		if(typeof elementClass === 'string' && '' !== elementClass && 'sidr-inner' !== elementClass) {
		$element.attr('class', elementClass.replace(/([A-Za-z0-9_.\-]+)/g, 'sidr-class-$1'));
		}
		$element.removeAttr('style');
		},
		execute: function(action, name, callback) {
		// Check arguments 如果第二参数为函数，则将第二参数传递给第三参数；第二参数如果为空，就改为”sidr“
			if(typeof name === 'function') {
			callback = name;
			name = 'sidr';
			}
			else if(!name) {
			name = 'sidr';
			}
		// Declaring
				var $menu = $('#' + name),
			$body = $($menu.data('body')),
			$html = $('html'),
			menuWidth = $menu.outerWidth(true),
			speed = $menu.data('speed'),
			side = $menu.data('side'),
			displace = $menu.data('displace'),
			onOpen = $menu.data('onOpen'),
			onClose = $menu.data('onClose'),//把menu中存储的各种数据取出来；
			bodyAnimation,
			menuAnimation,
			scrollTop,
			bodyClass = (name === 'sidr' ? 'sidr-open' : 'sidr-open ' + name + '-open');
			// Open Sidr
			if('open' === action || ('toggle' === action && !$menu.is(':visible'))) {
				// Check if we can open it
				if( $menu.is(':visible') || sidrMoving ) {
				return;//如果目前可见或者正在移动，则不执行；
				}
		// If another menu opened close first
			if(sidrOpened !== false) {
			methods.close(sidrOpened, function() {
			methods.open(name);
			});
			return;
			}
			// Lock sidr
			sidrMoving = true;
			// Left or right?
			if(side === 'left') {
				$body = $('body');
				var wth = parseInt($body.width());
				wth = (wth - parseInt(menuWidth)).toString()+'px';
				bodyAnimation = {left: menuWidth + 'px',width:wth};//此处让页面右移
				menuAnimation = {left: '0px'};
			}
			else {
				bodyAnimation = {right: menuWidth + 'px',width:wth};
				menuAnimation = {right: '0px'};
			}
			// Prepare page if container is body
			if($body.is('body')){
			scrollTop = $html.scrollTop();//获取滚动条偏移量；
			$html.css('overflow-x', 'hidden').scrollTop(scrollTop);//将滚动条回复到原来位置？
			}
			// Open menu
			if(displace){//如果设置为可偏移
			$body.addClass('sidr-animating').css({//修改body的类名，以通过css文件进行控制；
			width: $body.width(),//保存宽度，以便恢复；
			position: 'absolute'
			}).animate(bodyAnimation, speed, function() {
			$(this).addClass(bodyClass);//为当前元素增加一类：bodyclass。
			});
			}
			else {
			setTimeout(function() {
			$(this).addClass(bodyClass);
			}, speed);
			}
			$menu.css('display', 'block').animate(menuAnimation, speed, function() {
			sidrMoving = false;//
			sidrOpened = name;//记录当前打开的是哪个菜单；
			// Callback
			if(typeof callback === 'function') {
			callback(name);
			}
			$body.removeClass('sidr-animating');//增加了一个类属性，或许可以对其进行操控，在动画过程中使得CSS发生变化；
});
// onOpen callback
onOpen();
}
// Close Sidr
else {
// Check if we can close it
	if( !$menu.is(':visible') || sidrMoving ) {
	return;
	}
// Lock sidr
sidrMoving = true;
// Right or left menu?
if(side === 'left') {
bodyAnimation = {left: 0};
menuAnimation = {left: '-' + menuWidth + 'px'};
}
else {
bodyAnimation = {right: 0};
menuAnimation = {right: '-' + menuWidth + 'px'};
}
// Close menu
if($body.is('body')){
scrollTop = $html.scrollTop();
$html.removeAttr('style').scrollTop(scrollTop);
}
$body.addClass('sidr-animating').animate(bodyAnimation, speed).removeClass(bodyClass);
$menu.animate(menuAnimation, speed, function() {
$menu.removeAttr('style').hide();
$body.removeAttr('style');
$('html').removeAttr('style');
sidrMoving = false;
sidrOpened = false;
// Callback
if(typeof callback === 'function') {
callback(name);
}
$body.removeClass('sidr-animating');
});
// onClose callback
onClose();
}
}
};
// Sidr public methods
var methods = {
open: function(name, callback) {
privateMethods.execute('open', name, callback);
},
close: function(name, callback) {
privateMethods.execute('close', name, callback);
},
toggle: function(name, callback) {
privateMethods.execute('toggle', name, callback);
},
// I made a typo, so I mantain this method to keep backward compatibilty with 1.1.1v and previous
toogle: function(name, callback) {
privateMethods.execute('toggle', name, callback);
}
};
$.sidr = function( method ) {
if ( methods[method] ) {
return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
}
else if ( typeof method === 'function' || typeof method === 'string' || ! method ) {
return methods.toggle.apply( this, arguments );
}
else {
$.error( 'Method ' + method + ' does not exist on jQuery.sidr' );
}
};
//前面定义了一大堆变量、公有函数、私有函数；
//下面代码中options可以用来覆盖作者的设置；
$.fn.sidr = function( options ) {
var settings = $.extend( {
name : 'sidr', // Name for the 'sidr'
speed : 200, // Accepts standard jQuery effects speeds (i.e. fast, normal or milliseconds)
side : 'left', // Accepts 'left' or 'right'
source : null, // Override the source of the content.
renaming : true, // The ids and classes will be prepended with a prefix when loading existent content
body : 'body', // Page container selector,
displace: true, // Displace the body content or not,偏移；
onOpen : function() {}, // Callback when sidr opened
onClose : function() {} // Callback when sidr closed
}, options);
var name = settings.name,
$sideMenu = $('#' + name);
// If the side menu do not exist create it
if( $sideMenu.length === 0 ) {
$sideMenu = $('<div />')
.attr('id', name)
.appendTo($('body'));
}
// Adding styles and options
$sideMenu
	.addClass('sidr')
	.addClass(settings.side)
	.data({
	speed : settings.speed,
	side : settings.side,
	body : settings.body,
	displace : settings.displace,
	onOpen : settings.onOpen,
	onClose : settings.onClose
	});
// The menu content
if(typeof settings.source === 'function') {
var newContent = settings.source(name);
privateMethods.loadContent($sideMenu, newContent);
}
else if(typeof settings.source === 'string' && privateMethods.isUrl(settings.source)) {
$.get(settings.source, function(data) {
privateMethods.loadContent($sideMenu, data);
});
}
else if(typeof settings.source === 'string') {
var htmlContent = '',
selectors = settings.source.split(',');
$.each(selectors, function(index, element) {
htmlContent += '<div class="sidr-inner">' + $(element).html() + '</div>';
});
// Renaming ids and classes
if(settings.renaming) {
var $htmlContent = $('<div />').html(htmlContent);
$htmlContent.find('*').each(function(index, element) {
var $element = $(element);
privateMethods.addPrefix($element);
});
htmlContent = $htmlContent.html();
}
privateMethods.loadContent($sideMenu, htmlContent);
}
else if(settings.source !== null) {
$.error('Invalid Sidr Source');
}
return this.each(function(){
var $this = $(this),
data = $this.data('sidr');
// If the plugin hasn't been initialized yet
if ( ! data ) {
$this.data('sidr', name);
if('ontouchstart' in document.documentElement) {
$this.bind('touchstart', function(e) {
var theEvent = e.originalEvent.touches[0];
this.touched = e.timeStamp;
});
$this.bind('touchend', function(e) {
var delta = Math.abs(e.timeStamp - this.touched);
if(delta < 200) {
e.preventDefault();
methods.toggle(name);
}
});
}
else {
$this.click(function(e) {
e.preventDefault();
methods.toggle(name);
});
}
}
});
};
})( jQuery );