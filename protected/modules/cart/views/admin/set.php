<?php  
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
if($id>0) $cls = 'btn-success'
?>
<?php echo $this->render('menu');?>
<div class='span12 margin0'>
	<div class='span6 margin0'>
		<?php echo app\core\widget\Table::widget(array(
			'models'=>$models,
			'pages'=>$pages,
			'create'=>false,
			'update_url'=>'set',
			'delete'=>false,
			'fields'=>array('id','slug','table')	
		));?>
	</div>
	<div class='span6 well' style="padding:0;padding-top:20px;margin-left:10px;">
		<blockquote>
			<h3>
				<?php echo $id>0?__('update'):__('create');?>
			</h3>
		</blockquote>
		<?php
		$form = ActiveForm::begin(array(
			'options' => array('class' => 'form-horizontal'),
			'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
		)); ?> 

		<?php echo $form->field($model, 'slug')->textInput();  ?> 
		<?php echo $form->field($model, 'table')->textInput();  ?> 
		<?php echo $form->field($model, 'name')->textInput();  ?>  
		<?php echo $form->field($model, 'nums')->textInput();  ?> 
		<?php echo $form->field($model, 'sales')->textInput();  ?> 
		<?php echo $form->field($model, 'price')->textInput();  ?>  
		<?php echo $form->field($model, 'img')->textInput();  ?>   
		<div class="form-actions">
			<?php echo Html::submitButton(__('save'), null, null, array('class' => "btn $cls")); ?>
		</div> 
		<?php ActiveForm::end(); ?>
	</div>
</div>