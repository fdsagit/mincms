<?php use app\modules\content\models\FormBuilder;?>
<blockquote>
	<h3>
		<?php echo __('create'); ?>  [<?php echo $one->name;?>]
	</h3>
</blockquote>
<?php  
$form = new FormBuilder($name,$id);
echo $form->run();
?>

