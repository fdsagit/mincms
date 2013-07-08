<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
unset($this->params['breadcrumbs']);
$this->params['breadcrumbs'][] =  array('label'=>__('content type'),'url'=>url('content/site/index')); 
$this->params['breadcrumbs'][] =  array('label'=>__('parent'),'url'=>url('content/site/index' , array('pid'=>$model->pid))); 
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?>

<div class='span6 margin0'> 
	<?php echo \app\core\widget\Form::widget(array(
		'model'=>$model,
		'form'=>false,
		'open'=>$form,
		'yaml' => "@app/modules/content/forms/content.yaml",
	));?>
	<div class="control-group">
		<label class="control-label"><?php echo __('form widget');?></label>
		<div class="controls">
			<?php 
				echo Html::dropDownList('widget',$model->widget,$widget,array('id'=>'widget','style'=>'width:200px;')); 
				/**
				* create relate table
				* autoload widget from content module.
				* 
				static function content_type(){  
					return "<input type='hidden' name='Field[relate]' value='file'>";
				}
				*/
				 
	  			$relate = $model->relate;  
				js("
					var w = $('#widget').val(); 
					var relate = \"".$relate."\"; 
					widget_ajax(w);
					$('#widget').change(function(){
						var w = $(this).val();
						widget_ajax(w);
					});
					function widget_ajax(w){
						$.post('".url('content/site/ajax')."',{w:w , selected:relate},function(data){ 
							$('#relate_div').html(data);  
							$('select').select2();
						});
					}
				");
				 
			?>
		</div>
		<div id='relate_div' style="margin-top: 20px;">
		</div>
		<div class="control-group">
			<label class="control-label"><?php echo __('widget config');?></label>
			<div class="controls">
				<?php echo Html::textArea('widget_config',$model->widget_config);?>
			</div>
		</div>
	</div>
</div>
<div class='span6'>
			
	<div id='plugin' class="control-group">
		
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo __('rules');?></label>
		<div class="controls">
			<?php echo Html::textArea('rule',$model->rule);?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"><?php echo __('memo');?></label>
		<div class="controls">
			<?php echo Html::textArea('Field[memo]',$model->memo);?>
		</div>
	</div>
</div>
	<div class="form-actions span12"  >
		<?php echo Html::submitButton(__('save'),  array('class' => 'btn ')); ?>
	</div>
<?php ActiveForm::end();?>
<?php 
if(!$_GET['pid']){
	js("
	$('div.field-field-pid').hide();	
	");
}else{
	$pid = (int)$_GET['pid'];
	js("
	$('#field-pid option[value=".$pid."]').attr('selected',true);
	");
}
?>
<div style='clear:both;'></div>
	
<?php 
$id = $id?:0;
js(
" 
load_plugin();
function load_plugin(){
	$.post('".url('content/site/plugin')."',{value:$('#widget').val() , id:".$id."} , function(data){
		$('#plugin').html(data);
		$('select').select2();
	});
}
$('#widget').change(function(){
	load_plugin();
});	
"	
);?>