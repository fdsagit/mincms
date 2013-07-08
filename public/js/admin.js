$(function(){
	$("#theme .img-polaroid img").hover(function(){
		$(this).parent('div:last').find('p').fadeIn().fadeOut(5000);
	});
	
});