<?php
use yii\helpers\Html;
use app\modules\content\Classes;
use yii\widgets\ActiveForm; 
/**
 * @var yii\base\View $this
 */
 
$this->title = __('content');
$this->params['breadcrumbs'][] =  array('label'=>__('taxonomy'),'url'=>url('content/node/index',array('name'=>$name,'pid'=>$pid)));   
?>
<blockquote>
	<h3>
		<?php echo $name;?>
	</h3>
</blockquote>
	
<?php if(!$name){?>
<table class="table">
  <thead>
    <tr> 
      <th><?php echo __('name');?></th>
      <th><?php echo __('slug');?></th>
      <th><?php echo __('action');?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($types as $t){?>
    <tr> 
      <td>
        
        <?php echo $t->name;?>
        	
      </td>
      <td><?php echo $t->slug;?></td>
      <td>
      	<?php echo Html::a('<i class="icon-plus-sign"></i>',url('content/node/create',array('name'=>$t->slug)));?>  
      	&nbsp;&nbsp;
      	<?php echo Html::a('<i class="icon-list-alt"></i>',url('content/node/index',array('name'=>$t->slug)));?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php }else{
$fields = Classes::structure($name);
 
?>

<?php echo $this->render('search',array('slug'=>$name,'fid'=>$fid,'model'=>$model ,'filters'=>$filters));?>
<?php echo Html::a('<i class="icon-plus-sign"></i>',url('content/node/create',array('name'=>$name)));?> 
<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal','id'=>'sort'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?><?php echo Html::hiddenInput('name',$name);?>

	 <table class="table">
	  <thead>
	    <tr> 
		<th><?php echo __('id');?></th>
		 <?php foreach($fields as $title=>$v){ 
				if($v['list']==1){?>
	      	<th><?php echo __($title);?></th>
	     <?php }}?>
	      <th><?php echo __('action');?></th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php if(!$models) return;foreach($models as $model){?>
	    <tr id="node_<?php echo $model->id;?>"> 
	    <td><i class="drag"></i><?php echo Html::hiddenInput('ids[]',$model->id).$model->id;?></td>
	    <?php foreach($fields as $title=>$v){ 
				if($v['list']==1){?>
	      <td>
		      <?php if($title=='name'){
		       $f = Classes::all('taxonomy',array('where'=>array('pid'=>$model->id)));
		      ?>
		      <?php if($f){?>
		      	  <a href="<?php echo url('content/node/index',array('name'=>$name,'pid'=>$model->id));?>" >
		      <?php }?>
		      	  <?php echo Classes::field_show_list($name,$title,$model->$title);?>
		      <?php if($f){?>
		      	  </a>
		      <?php }?>
		      <?php }else{?>	  
		      	  <?php echo Classes::field_show_list($name,$title,$model->$title);?>
		      <?php }?>
	      	</td>
	   <?php }}?>
	      <td>
	      	<?php echo Html::a('<i class="icon-edit"></i>',url('content/node/update',array('name'=>$name,'id'=>$model->id)));?> 
	      	 &nbsp;   
	        <?php if($model->display == 1){?>
	        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
	        		<img src="<?php echo base_url();?>img/right.png" />
	        	</a>
	        <?php }else{?>
	        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
	        		<img src="<?php echo base_url();?>img/error.png" />
	        	</a> 
	        <?php }?>
	      	   
	      </td>
	    </tr>
	    <?php }?>
	  </tbody>
	</table> 

<?php 
\app\core\UI::sort('#sort',url('content/node/sort'));
ActiveForm::end(); 
?>
 
<?php  echo \app\core\LinkPager::widget(array(
      'pagination' => $pages,
  ));?>
	 
<?php }?>
