$(function(){
	$('.cart_add').click(function(){
		var id = $(this).attr('rel');
		var cid = $('.cart_num'+id).attr('cid'); 
		var v = parseInt($('.cart_num'+id).html()) + parseInt(1) ;
		$('.cart_num'+id).html( v );
		cart_ajax(cid,1);
	});	
	$('.cart_edd').click(function(){
		var id = $(this).attr('rel');
		var cid = $('.cart_num'+id).attr('cid'); 
		var v = parseInt($('.cart_num'+id).html()) - parseInt(1);
		if(v<1) return false;
		$('.cart_num'+id).html( v );
		cart_ajax(cid,0);
	});	
	function cart_ajax(cid,num){   
		/**
		* 更新购物车数量
		*/
		$.getJSON('{{url}}',{cid:cid,flag:num},function(data){
		 	$('.cart_total').html(data.total); 
	  	     
		});
	}

})