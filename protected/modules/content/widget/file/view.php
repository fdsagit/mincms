<div class="control-group ">
<label class="control-label" ><?php echo __($name);?></label>
<div class="controls" style="padding-top: 8px;">
	<?php
	echo   widget('plupload',array(
	 			'field'=>$id, 
	 			'values'=>$all,
				'ext'=>'*',
	 		));	
	?>
<span class="help-inline"></span>
</div>
</div>

