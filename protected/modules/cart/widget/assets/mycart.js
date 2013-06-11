/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
(function($){ 
 	$.fn.extend({  
 		mycart: function(options) {  
			var defaults = {  
				id:'#cart_has',  
			};
			var opts = $.extend(defaults,options);  
			var hide = '#'+$(this).attr('id');
			var rel = '#'+$(this).attr('rel'); 
			$(this).bind('mouseover',function(){   
				$(rel).fadeIn();
			}) ;
			 $(document).mouseover(function(e) {
					var t = $(e.target); 
					var v1 = "#cart_has,#cart_has span,.cart_ul ,#my_cart img,#my_cart a,.cart_ul li,#my_cart,#my_cart p, #my_cart span,#my_cart div,#my_cart ul,#my_cart li"; 
					if (!t.is(v1)) {
						$(rel).hide(); 
					  
					}
				 
			});

    	}
	});
	
})(jQuery); 