 
<a href="<?php echo plugin_url($url);?>" class='insertCK'>
<?php echo __('insert image');?>
</a>
 
<?php
widget('colorbox',array(
	'tag'=>'.insertCK',
	'theme'=>3,
	'options'=>array(
		'width'=>800,
		'height'=>500
	)
));

?>
