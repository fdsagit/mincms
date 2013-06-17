<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
use app\modules\content\Classes;
$cols = Classes::structure($slug);
foreach($cols as $k => $v){
	$content_type[] = $k;
}
 
?>
<blockquote id='search' class='hander'>
	<?php echo __('search');?>
</blockquote>
<div id='filter'  style="display:none" >
	
	
<ul id='set_search'>
	<blockquote>
		<?php echo __('set search filed');?>
	</blockquote>
	<?php 
	$columns = array_merge(Classes::default_columns(),$content_type);
	
	foreach($columns as $col){
	?>
	<li class='label'><?php echo Html::a($col,url('content/site/search',array('slug'=>$slug,'name'=>$col)));?></li>
	<?php }?>
</ul>

<ul id='set_list' >
	<blockquote>
		<?php echo __('set display filed in list');?>
	</blockquote>	
	<?php 
	$columns = Classes::default_columns();
	foreach($columns as $col){
	?>
	<li class='label'><?php echo $col;?></li>
	<?php }?>
</ul>	

<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>
dd
<div class="form-actions">
	<?php echo Html::submitButton(__('filter'), null, null, array('class' => 'btn ')); ?>
</div>
<?php if(true === $show_form) ActiveForm::end(); ?>

</div>

<?php 
js("
	$('#search').click(function(){  
	 	if($('#filter').css('display')=='block'){
	 		$('#filter').hide();
	 	}else{
	 		$('#filter').show();
	 	}
	 });

");	
css("
#set_search li,#set_list li{
float:left; 
margin-right:5px;
display:block;
}
#set_list{
clear:both;display:block;margin-top:20px;
}
#set_search{margin-bottom:20px;}
");
?>