jQuery(document).ready(function($) {
	$('.menutop li.root > .item').prepend('<i class="animateHover"></i>')
	$('ul li:last').addClass('lastItem');
	$('ul li:first').addClass('firstItem');
	/*Avoid input bg in Chrome*/
	if ($.browser.webkit) {
		$('input').attr('autocomplete', 'off');
	}
	/*Zoom Icon. Portfolio page*/
	$('#port .catItemImage a.modal').hover(function(){
		$(this).find('img').stop().animate({opacity:.3},{queue:false}).parent().find('span.zoom-icon').stop().animate({top: '50%'},{queue:false}).parent().find('span.zoom-text').stop().animate({bottom: '50%'},{queue:false});
	},function(){
		$(this).find('img').stop().animate({opacity:1},{queue:false}).parent().find('span.zoom-icon').stop().animate({top:0},{queue:false}).parent().find('span.zoom-text').stop().animate({bottom:0},{queue:false});
	})
	$('.fusion-submenu-wrapper.level2').parent().css({overflow:'visible'})
/*ScrollToTop button*/
$(window).scroll(function() {
	if($(this).scrollTop() != 0) {
		$('.rt-block.totop').fadeIn();	
	} else {
		$('.rt-block.totop').fadeOut();
	}
});
$(window).load(function(){
	var offset
	var mouseOffset ={}
	var beginAnimationPosition
	$('.menutop li.root').not('.active').find('>.item').hover(
		function(e){
			if($(this).parent().hasClass('f-mainparent-itemfocus')) return
			else {
				offset =$(this).offset()
				$(this).find('i.animateHover').css({left:(e.pageX-offset.left),top:(e.pageY-offset.top),width:0,height:0,opacity:0}).stop().animate({top:0,left:0,width:'100%',height:'100%',opacity:1})
			}
		},
		function(e){
			if($(this).parent().hasClass('f-mainparent-itemfocus')) {
				var menuElem=this
				function checMenukItem(menuElem){
					if($(menuElem).parent().hasClass('f-mainparent-itemfocus')){
						var menuElemInterval = setTimeout(function(){checMenukItem(menuElem)},100)
					}
					else {
						clearTimeout(menuElemInterval);
						offset =$(menuElem).offset()
						$(menuElem).find('i.animateHover').stop().animate({left:(e.pageX-offset.left),top:(e.pageY-offset.top),width:0,height:0,opacity:0})
					}
				}
				checMenukItem(menuElem)
			}
			else {
				offset =$(this).offset()
				$(this).find('i.animateHover').stop().animate({left:(e.pageX-offset.left),top:(e.pageY-offset.top),width:0,height:0,opacity:0})
			}
		}
	)
	$('.homepage #rt-menu').animate({height:40,opacity:1},800)
	$('.homepage #rt-logo').animate({top:0,opacity:1},800)
	$('.homepage #caption').animate({right:'50%',opacity:1},800,function(){$('.homepage #slider_nav a').animate({opacity:.25},800)})	
})
$(window).resize(function() {
				if($(window).height()<=500) {$('html').css({height:500})}
				else {$('html').css({height:'100%'})};
			})
	if(!$('.wrapper').hasClass('homepage')){
		$(window).load(function() {
			if($('body').width()>=$('#main_img').width()){
				$('#main_img').css({width:$('body').width(),height:'auto',top:-(185*($('body').width()/1300-1)),left:0})
			}
			else{
				$('#main_img').css({width:1300,height:'auto',top:0,left:-((1300-$(window).width())/2)})
			}
			$('#main_img').animate({opacity:1},500)
			$(window).resize(function() {
				if($('body').width()>=$('#main_img').width()){
					$('#main_img').css({width:$('body').width(),height:'auto',top:-(185*($('body').width()/1300-1)),left:0})
				}
				else{
					$('#main_img').css({width:1300,height:'auto',top:0,left:-((1300-$(window).width())/2)})
				}
			})
		})
	}
})	