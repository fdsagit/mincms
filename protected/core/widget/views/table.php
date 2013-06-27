<?php if(true===$create){?>
<p><a href="<?php if(!$create_url){
			 echo url_action('create');
		 } else { echo $create_url;}?>" 
	class='label label-info'><?php echo __('create');?></a></p>
<?php }?>
<table class="table table-hover table-bordered">
  <thead>
    <tr>
	<?php foreach($fields as $f){?> 
    <th><?php echo __($f);?></th>
    <?php }?>
    <?php if($delete || $update){?>
	    <th >
	    
	    </th>
    <?php }?>
    </tr>
  </thead>
  <tbody>
	<?php foreach($models as $model) {  ?> 
	<tr id="table-<?php echo $model->id;?>">
		<?php foreach($fields as $f){?> 
        <td><?php echo $model->$f;?></td>
        <?php }?>
        <?php if($delete || $update){?>
		    <td >
		    	<?php if($update){?>
		    		<a href="<?php echo url($update_url,array('id'=>$model->id));?>"><i class="icon-edit"></i></a>&nbsp;
		    	<?php }?>
		     
		    	<?php if($delete){?> 
		    		<a type="button" data-toggle="modal"  class='mymodal' data-target="#modal" 
		    			title="<?php echo $title;?> #<?php echo $model->id;?>" content="<?php echo $content;?>"
		    			rel="<?php echo url($delete_url,array('id'=>$model->id));?>">
		    			<i class="icon-trash hander"></i>
		    		</a>
		    	<?php }?>
		    </td>
	    <?php }?>
    </tr>
	                
	<?php }?> 
    
  </tbody>
</table>
<?php if($pages){?>
	<div class='pagination'>
	<?php  echo \app\core\LinkPager::widget(array(
	      'pagination' => $pages,
	  ));?>
	</div>
<?php }?>
<?php echo core_widget('Modal');?>