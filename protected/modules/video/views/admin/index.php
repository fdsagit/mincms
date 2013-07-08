<?php echo module_widget('oauth','login');?>
<?php
use yii\helpers\Html;
use app\modules\video\Classes;
$videos = Classes::youku();
?>
<?php 
	if($videos){
		foreach($videos as $v){ 
			$one = node('video',array(
				'where'=>array(
					'path'=>$v->id,
				 	'type'=>3
				)
			));
		 	if(!$one){
		 		node_save('video',array(
					 	'type'=>3,
					 	'path'=>$v->id,
						'title'=>$v->title,
						'img'=>$v->thumbnail,
				));
		 	}
		 
	?>
 	
	<div class="image-container  ">
        <?php echo Html::img($v->thumbnail);?>
        <div class="overlay"> <?php echo $v->title;?> </div>
    </div>
     
<?php }}?>
