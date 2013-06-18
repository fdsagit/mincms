<?php 
use app\modules\content\models\FormBuilder;
$id = $_GET['id'];
if(!$id){ 
	$info = __('create');
}else{ 
	$info = __('update');
}
$this->title = __('content');
$this->params['breadcrumbs'][] =  array('label'=>__('content'),'url'=>url('content/node/index',array('name'=>$name)));  
$this->params['breadcrumbs'][] = $info; 	
?>
<blockquote>
	<h3>
		[<?php echo $one->name;?>] #<?php echo $_GET['id'];?>
		<small>
			<?php echo $info; ?>
		</small>
	</h3>
</blockquote>
<?php  
$form = new FormBuilder($name,$id);
echo $form->run();
?>

