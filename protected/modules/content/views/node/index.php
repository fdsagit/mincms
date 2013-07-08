<?php
use yii\helpers\Html;
use app\modules\content\Classes;
use yii\widgets\ActiveForm; 
use app\modules\auth\Auth;
/**
 * @var yii\base\View $this
 */
 
$this->title = __('content');
if($label)
$this->params['breadcrumbs'][] = $label; 
?>
<?php if($name){?>
<blockquote> 
		 <?php echo $label;?>
</blockquote>
<?php }?>
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
      <td><?php echo $t->name;?></td>
      <td><?php echo $t->slug;?></td>
      <td>
      	<?php echo Html::a('<i class="icon-plus-sign"></i>',url('content/node/create',array('name'=>$t->slug)).'#table');?>  
      	&nbsp;&nbsp;
      	<?php echo Html::a('<i class="icon-list-alt"></i>',url('content/node/index',array('name'=>$t->slug)).'#table');?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php }else{
$fields = Classes::structure($name);
 
?>

<?php echo $this->render('search',array('slug'=>$name,'fid'=>$fid,'model'=>$model ,'filters'=>$filters));?>
<?php echo Html::a('<span class=" btn btn-inverse"><i class="icon-plus-sign icon-white"></i></span>',url('content/node/create',array('name'=>$name)));?> 
<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-horizontal','id'=>'sort'),
	'fieldConfig' => array('inputOptions' => array('class' => 'input-xlarge')),
)); ?><?php echo Html::hiddenInput('name',$name);?>
<a name="table"></a>
	 <table class="table">
	  <thead>
	    <tr> 
		<th><?php echo __('id');?></th>
		 <?php foreach($fields as $title=>$v){ 
				if($v['list']==1){?>
	      	<th><?php echo __($title);?></th>
	     <?php }}?>
	     <th><?php echo __('created');?></th>
	     <th><?php echo __('updated');?></th>
	      <th><?php echo __('user');?></th>
	      <th><?php echo __('action');?></th>
	    </tr>
	  </thead>
	  <tbody>
	    <?php if(!$models) return;foreach($models as $model){?>
	    <tr id="node_<?php echo $model->id;?>"> 
	    <td><i class="drag"></i><?php echo Html::hiddenInput('ids[]',$model->id).$model->id;?></td>
	    <?php foreach($fields as $title=>$v){ 
				if($v['list']==1){?>
	      <td><?php echo Classes::field_show_list($name,$title,$model->$title);?></td>
	   <?php }}?>
	    <td title="<?php echo date('Y-m-d H:i:s' , $model->created);?>"><?php echo date('Y-m-d' , $model->created);?> </td>
	   	<td title="<?php echo date('Y-m-d H:i:s' , $model->updated);?>"><?php echo date('Y-m-d' , $model->updated);?> </td>
	   	<td><?php 
	   	 
	   	if($model->admin == 1) {
	   		$u = Auth::user($model->uid);	
	   	?>
	   	<span title="<?php echo $u->email;?>" class='label label-info'><?php echo $u->username;?></span>
	   		
	   	<?php }?></td>
	   		
	   	
	     <td>
	      	<?php  
	      	  if(self($model->uid)){
	      	  	echo Html::a('<i class="icon-edit" title="'. __('edit').'"></i>',url('content/node/update',array('name'=>$name,'id'=>$model->id)));?> 
	      	 &nbsp;   
	        <?php if($model->display == 1){?>
	        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
	        		<img src="<?php echo base_url();?>img/right.png" />
	        	</a>
	        <?php }else{?>
	        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
	        		<img src="<?php echo base_url();?>img/error.png" />
	        	</a> 
	        <?php }}else{?>
	      		
		      		<?php 
		      		if( uid() == 1){
		      			echo Html::a('<i class="icon-edit" title="'. __('edit').'"></i>',url('content/node/update',array('name'=>$name,'id'=>$model->id)));?> 
		      			&nbsp;  
		      			<?php if($model->display == 1){?>
			        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
			        		<img src="<?php echo base_url();?>img/right.png" />
			        	</a>&nbsp;  
			        	<?php }else{?>
			        	<a href="<?php echo url('content/node/display',array('name'=>$name,'id'=>$model->id));?> ">
			        		<img src="<?php echo base_url();?>img/error.png" />
			        	</a> &nbsp;  	
		      		<?php 
		      		}}?>
		      			
	      			<i class="icon-lock" title="<?php echo __('not your create');?>"></i>
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
