<?php 
use yii\helpers\Html;
?>

<?php echo Html::a(__('add to cart'),"#",array(
	'class'=>"addCart $class",	
	'rel'=>$id
));?>
<div class='alert alert-warning cart-info' style='display:none;'></div>
<?php
js("
$('.addCart').click(function(){
	var obj = $(this);
	var div  = $(this).parent().find('div:first');
	if(obj.hasClass('".$active."')){
		div.html('".__('had added to cart')."').fadeIn().fadeOut(3000).removeClass('label label-success');;
		return false;
	}
	$.post('".url('cart/ajax/index')."',{id:$(this).attr('rel')},function(data){
		obj.html('".__('added cart')."');
		obj.removeClass('".$class."').addClass('".$active."');
		div.html('".__('add cart success')."').fadeIn().fadeOut(3000).addClass('label label-success');
		$.post('".url('cart/ajax/tip')."',function(data){
			$('#my_mincms_cart').html(data);
			$('#cart_has').mycart();
		});
	});
	return false;
});
");

?>