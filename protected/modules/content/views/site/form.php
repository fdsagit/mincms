<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
 
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('content type'),'url'=>url('content/site/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='span8 margin0'>
	<?php echo \app\core\widget\Form::widget(array(
		'model'=>$model,
		'form'=>false,
		'yaml' => "@app/modules/content/forms/".$name.".yaml",
	));?>
	<div class="control-group">
		<label class="control-label"><?php echo __('is list');?></label>
		<div class="controls">
			<?php echo Html::checkbox('Field[list]',$model->list,array(
				0=>__('no'),
				1=>__('yes'),
			));?>
		</div>
	</div>
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
					var relate = '".$relate."'; 
					widget_ajax(w);
					$('#widget').change(function(){
						var w = $(this).val();
						widget_ajax(w);
					});
					function widget_ajax(w){
						$.post('".url('content/site/ajax')."',{w:w},function(data){ 
							$('#relate_div').html(data);
							
							$('#Field_relate option').each(function(i){  
								if($(this).val() == relate){
									$(this).attr('selected' , true);
								}
							});
						});
					}
				");
				 
			?>
		</div>
		<div id='relate_div'>
		</div>
	</div>
</div>
<div class='span4'>
	<div class="control-group">
		<label class="control-label"><?php echo __('widget config');?></label>
		<div class="controls">
			<?php echo Html::textArea('widget_config',$model->widget_config);?>
		</div>
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
		<?php echo Html::submitButton(__('save'), null, null, array('class' => 'btn ')); ?>
	</div>
<?php ActiveForm::end();?>

