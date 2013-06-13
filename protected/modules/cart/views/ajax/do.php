<?php 
use yii\helpers\Html;	
 	
if(!$all){?>
	
<?php }else{?>
<table class="table table-striped">
  <thead>
    <tr>
      <th><?php echo __('product name');?></th>
      <th><?php echo __('product price');?></th>
      <th><?php echo __('product qty');?></th>
      <th><?php echo __('product action');?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($all as $row){  
    
    ?> 
    <tr id="cart<?php echo $row['id'];?>">
      <td><?php echo image($row['img'],array(
        	'resize'=>array(160,160),
        ));?> <?php echo $row['name'];?></td>
      <td> <?php echo $row['price'];?>  </td>
      <td> 
        <!----->
        <span class='cart cart_edd' rel="<?php echo $row['id'];?>">-</span> 
        <span class="cart_left cart_qty cart_num<?php echo $row['id'];?>" cid="<?php echo $row['cid'];?>"> 
       		 <?php echo $row['qty'];?> 
      	</span> 
        <span class="cart cart_add right" rel="<?php echo $row['id'];?>">+</span>
       
        </td>
      <td><?php echo Html::a(__('delete'),url('#'));?></td>
    </tr>
    <?php }?>
  </tbody>
</table>

<div class="pull-right">
	<?php echo __('cart total');?> : 

		<span style='color:red;'>
			<?php echo $nums;?>
		</span> 
		<?php echo __('item');?> 
	<br>
		<?php echo __('total price');?> : &yen; 
<!----->
			<span style='color:red;' class='cart_total'><?php echo $total;?></span>
	<p>
	<?php echo Html::a(__('pay the bill'),url('payment/site/index'),array(
		'class'=>"label label-important"  
	));?>
</div> 
<?php }
css("
.cart{
width: 13px;
height: 13px;
margin-top: 3px;
float: left;
display: block;
overflow: hidden;
line-height: 13px;
cursor: pointer;
background: #fff;
border: 1px solid #ccc;
text-align: center;}
.cart_left{float:left;margin-left:5px;margin-right:5px;}
");	 

?>
<?php 
//加载cart.js
js("");
$base = publish(__DIR__.'/../../widget/assets');   
$file = $base.'/cart.js';
$new = $base.'/app.js';
if(!file_exists($new)){
	$content = file_get_contents(root_path().$file);
	$content = str_replace('{{url}}',url('cart/ajax/num'),$content);
	file_put_contents(root_path().$new,$content);
}
js_file($new);
?> 
