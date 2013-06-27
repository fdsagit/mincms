<?php
use yii\helpers\Html;
/**
 * @var yii\base\View $this
 */
 
$this->title = __('content type');
$this->params['breadcrumbs'][] =  array('label'=>__('content type'),'url'=>url('content/site/index'));  
$this->params['breadcrumbs'][] = __('list'); 
?>
<blockquote>
	<h3>
		<?php  if(!$model) {echo $this->title;} else{ echo $model->slug;} ?> 
	</h3>
</blockquote>
<?php echo app\core\widget\Table::widget(array(
	'models'=>$models,
	'pages'=>$pages,
	'create_url'=>url('content/site/create',array('pid'=>$_GET['pid'])),
	'fields'=>array('id','slug','name','link')	
));?>

