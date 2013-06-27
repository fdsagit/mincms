<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
?>
<?php  
	echo \app\core\widget\Form::widget(array(
	'model'=>$model,
	'form'=>false,
	'yaml' => "@app/modules/content/forms/content_type.yaml",
));?>
 

<div class="form-actions span12"  >
	<?php echo Html::submitButton(__('save'),  array('class' => 'btn ')); ?>
</div>
<?php ActiveForm::end();?>