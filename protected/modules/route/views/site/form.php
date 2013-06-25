<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
 
/**
 * @var yii\base\View $this
 */
$this->params['breadcrumbs'][] =  array('label'=>__('route'),'url'=>url('route/site/index')); 
$this->params['breadcrumbs'][] = $this->title;
?>
 
<?php echo \app\core\widget\Form::widget(array(
	'model'=>$model,
	'form'=>false,
	'yaml' => "@app/modules/route/forms/route.yaml",
));?>
 
<div class="form-actions span12"  >
	<?php echo Html::submitButton(__('save'),  array('class' => 'btn ')); ?>
</div>
<?php ActiveForm::end();?>

