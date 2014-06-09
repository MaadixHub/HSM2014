$(document).ready(function() {
	
	$("#mensaje").css("display", "none");

    $("#mensaje").fadeIn(0);
    $("#mensaje").fadeOut(3500);

	$("a.transition").click(function(event){
		event.preventDefault();
		linkLocation = this.href;
		$("body").fadeOut(redirectPage);		
	});
		

});