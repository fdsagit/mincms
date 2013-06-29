<?php 
$data = \app\core\DB::pagination('file');
$count = $data->pages->itemCount;
$size = $data->pages->pageSize;
$models = $data->models; 
 
widget('masonry' , array(
	'tag'=>'#masonry',
	'scroll'=>true
));
css("
	#masonry li{ 
		list-style:none; 
		float:left;
		margin-rigth:10px;
	}
");
 ?>
<div id='masonry'>
	 <ul>
	 
	 	<?php for($j=1;$j<=3;$j++){?>
		 	<?php for($i=1;$i<=6;$i++){?>
			 	<li class='item'>
			 		<?php echo image("upload/t/{$i}.jpg" , array( 'resize' => array(120)));?>
			 	</li>
		 	<?php }?>
		 <?php }?>
	  
	 </ul> 
</div>
	
<?php  
	echo \app\core\Pagination::next($count,$size);
?>	
