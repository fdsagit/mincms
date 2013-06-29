 
   
<?php 

echo widget('elevatezoom',array(
	'tag'=>'img',
	'img'=>array(
		image_url('upload/t/6.jpg',array(
			'resize'=>array(400,300)
		)) => base_url().'upload/t/6.jpg'
	),
));

 
?>
