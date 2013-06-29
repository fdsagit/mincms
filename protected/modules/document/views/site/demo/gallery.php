<div id="galleria" style="width:600px;height:400px;">
	<?php for($i=1;$i<5;$i++){ $f = 'upload/t/'.$i.'.jpg';   ?>
    <a href="<?php echo image_url($f,array('resize'=>array(600,400,true,true)));?>"><img src="<?php echo image_url($f,array('resize'=>array(300,200)));?>"     
    	data-big="<?php echo image_url($f,array('resize'=>array(600,400)));?>" data-title="My title 1" data-description="My description 1"></a>
    <?php }?>
</div>
<?php widget('gallery',array(
	'tag'=>'#galleria',
	'theme'=>'twelve',// classic , azur ,dots,fullscreen,twelve
));
?> 
