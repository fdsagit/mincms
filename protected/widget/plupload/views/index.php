<?php 
use app\core\File;
?>
<div id="<?php echo $container;?>">
	<a id="<?php echo $pickfiles;?>" href="#" class='clear'><?php echo __('select file');?></a>
	<div id="<?php echo $filelist;?>">
		<?php if($values){
			foreach($values as $v){
				echo File::input_one($v,$field);
			?> 
		 
		<?php }}?>
	</div> 
	
	
</div>
<?php
css('
.file .icon-remove{
	position: absolute;
	top: 0px;
	right: 0px;
}
.file {
	width: 160px;
	float: left;
	position: relative;
	margin-right:10px;
	cursor: hand;
	margin-bottom:10px;	
}
');	
?>
