<?php namespace app\modules\cart\widget;  
use app\core\DB;
/**
*  
* @author Sun < mincms@outlook.com >
*/
class Ajax extends \yii\base\Widget
{ 
   
	function run(){  
		$base = publish(__DIR__.'/assets'); 
		js(" 
			$.post('".url('cart/ajax/tip')."',function(data){
				$('#my_mincms_cart').html(data);
				$('#cart_has').mycart();
			});
			
		"); 
	 	js_file($base.'/mycart.js'); 
	 	echo "<div id='my_mincms_cart'></div>";
	}
}