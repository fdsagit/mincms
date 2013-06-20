<div id="<?php echo $container;?>">
	<div id="<?php echo $filelist;?>">
		<?php if($values){
			foreach($values as $v){?>
		<div class="file"><span class="icon-remove hander"></span>
	
		 	<input type="hidden" name="<?php echo $field;?>[]" value="<?php echo $v['id'];?>">
		 	<?php echo image($v['path'],array(
			 		'resize'=>array(160,160)
		 		));?>
		</div>
		<?php }}?>
	</div> 
	<div style="clear:both;"></div>
	<a id="<?php echo $pickfiles;?>" href="#"><?php echo __('select file');?></a>
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
