<div id="<?php echo $container;?>">
	<div id="<?php echo $filelist;?>"></div> 
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
	margin-right:8px;
}
');	
?>
