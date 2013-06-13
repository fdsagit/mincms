<?php 
use app\modules\cart\Classes;
use yii\helpers\Html;
?>
<div id='cart_has' class='cart_has ' rel='my_cart'><?php echo __('cart has');?>
	<span class="label label-important">(<?php echo $nums;?>)</span><?php echo __('item');?></div>
<?php if($rows){?>
<div  id='my_cart' style='display:none;'>  
		<?php 
	 
		foreach($rows as $v){?>
		<div style="clear:both;"> 
			<p style="float:left;">
			<?php echo image($v['img'],array(
				'resize'=>array(60,60)
			));?>
			</p>
			<p style="float:left;">
			<?php echo $v['name'];?> <br>
			&yen; <span class="label label-success"><?php echo $v['price'];?></span> 
			<span class="label label-important">*</span> <span class="label label-success"><?php echo $v['qty'];?></span>
			</p>
			<?php echo $v['total'];?>
		</div>  
		<?php }?> 
 	<div class='cart_total' style="clear:both;"> 
		<?php echo __('cart total');?> : <span class="label label-success"><?php echo $nums;?></span> <?php echo __('item');?> 
		<br>
		<?php echo __('total price');?> : &yen; <span class="label label-success"><?php echo $total;?></span>
		<p>
		<?php echo Html::a(__('settle up the bill'),url('cart/ajax/do'),array(
			'class'=>"label label-important"  
		));?>
		</p>
	</div>
	
</div>
<?php }?>
	
	
		
<?php
css('
.cart_has{clear:both;}
ul.cart_ul{margin:0;}
ul.cart_ul li{list-style:none;clear:both;}
.cart_total{clear:both;}
#my_cart{display:none;}
'); 
?>