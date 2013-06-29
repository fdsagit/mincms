<?php
use yii\helpers\Markdown;
?>
 
	
<section class="docs">  
	<nav class="span3 margin0">
		<?php echo Markdown::process($home);?>
	</nav> 
	<article class="span9">
		<?php echo Markdown::process($body);?>
	</article>
 
</section>
 

 