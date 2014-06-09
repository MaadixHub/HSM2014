jQuery(document).ready(function($){
	$('ul li:first-child').addClass('first')
	$('ul li:last-child').addClass('last')
	$('.items-row:last-child').addClass('last')
	
	$('dl dt:first-child').addClass('first')
	
	$('#header-right ul li.parent').hover(
		function() {
			$(this).addClass("actives");
			$(this).find('> ul').stop(false, true).fadeIn();
			$(this).find('>ul ul').stop(false, true).fadeOut('fast');
		},
		function() {
			$(this).removeClass("actives");        
			$(this).find('ul').stop(false, true).fadeOut('fast');
			}
		);
		
	$('#slider').nivoSlider({
		effect: 'fade',
		customChange: function(){
            },
		slices: 1,
		boxCols: 8, // For box animations
		boxRows: 4, // For box animations
		pauseTime: 99000,
		directionNav: false,
		captionOpacity: 1
	});
	
	$('button.validate, button.button, input.button, .formelm-buttons button').wrap('<div class="button">');
	$('button.validate, button.button, input.button,  .formelm-buttons button').after('<span></span>');
	
	
	$('.nivo-controlNav').css('z-index', 999);
});