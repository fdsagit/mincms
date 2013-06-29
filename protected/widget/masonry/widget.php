<?php namespace app\widget\masonry;  
use yii\helpers\Json;
/**
* masonry widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://mincms.com/demo-masonry.html masonry demo
* @link http://mincms.com/demo-scroll.html scroll demo
* @version 1.0.1
*/

class Widget extends \yii\base\Widget
{  
	/**
	* html element, such as #id .class
	*/
 	public $tag; 
 	/**
 	* array options
 	*/
 	public $options; 
 	/**
 	* if scroll ajax_load.gif position
 	*/
 	public $bottom = true;
 	/**
 	* item
 	*/
 	public $itemSelector = '.item';
 	/**
 	* scroll  true/false
 	*/
 	public $scroll = false; 
 	/**
	* masonry/scroll images
	*
	* Example masonry:
	*  
	* <code> 
	* <?php
	*	widget('masonry' , array('tag'=>'#masonry'));
	*	css("
	*		#masonry li{ 
	*			list-style:none; 
	*			float:left;
	*			margin-rigth:10px;
	*		}
	*	");
	* ?>
	* <div id='masonry'>
	*	 <ul>
	*	 <?php for($j=1;$j<=50;$j++){?>
	*	 	<?php for($i=1;$i<=6;$i++){?>
	*		 	<li class='item'>
	*		 		<?php echo image("upload/t/{$i}.jpg" , array( 'resize' => array(120)));?>
	*		 	</li>
	*	 	<?php }?>
	*	 <?php }?>
	*	 </ul> 
	* </div>
	* </code>  
	* Example scroll:
	* <code>
	*	<?php 
	*	$data = \app\core\DB::pagination('file');
	*	$count = $data->pages->itemCount;
	*	$size = $data->pages->pageSize;
	*	$models = $data->models;  
	*	widget('masonry' , array(
	*		'tag'=>'#masonry',
	*		'scroll'=>true
	*	));
	*	css("
	*		#masonry li{ 
	*			list-style:none; 
	*			float:left;
	*			margin-rigth:10px;
	*		}
	*	");
	*	 ?>
	*	 <div id='masonry'>
	*		 <ul> 
	*		 	<?php foreach($models as $v){?>
	*			 	<li class='item'>
	*			 		<?php echo image($v['path'] , array( 'resize' => array(120)));?>
	*			 	</li>
	*		 	<?php }?> 
	*		 </ul> 
	*	</div>
	*</code> 
	*/

	function run(){   
		$base = publish(__DIR__.'/assets');  
 		$tag = $this->tag; 
		$bottom = $this->bottom?:true; 
		$itemSelector = $this->itemSelector?:'.item';
		if(!$this->options['itemSelector'])
	 		$this->options['itemSelector'] = $itemSelector;
		$opts = Json::encode($this->options);  
		
		if($this->scroll === true){ 
			css("#infscr-loading{clear:both; position: absolute;padding-left:10px;bottom: -25px;width: 200px;}#infscr-loading img{float: left;margin-right: 5px;}");
		 	js("
				var \$container = $('".$tag."');
		 		\$container.imagesLoaded(function(){
			     \$container.masonry($opts);
			    });   
				var \$container = $('".$tag."');
					\$container.infinitescroll({ 
					loading:{ 
				    	img:'".$base."/ajax-loader.gif',
					    msgText:'".__('loading content……')."',  
					    finishedMsg:'".__('content loading finished')."'
				    },
				    dataType: 'html',
				    navSelector  : 'div.pagination',   
				    nextSelector : 'div.pagination a',    
				    itemSelector : '".$itemSelector."', 
				 },  
				  function( newElements ) {
				    var \$newElems = $( newElements ).css({ opacity: 0 });
			        \$newElems.imagesLoaded(function(){
			          \$newElems.animate({ opacity: 1 });
			          \$container.masonry( 'appended', \$newElems, true ); 
			        });

				  }
				); 
			"); 
			js_file($base.'/jquery.infinitescroll.js');
		}else{
			js("
				var \$container = $('".$tag."');
		 		\$container.imagesLoaded(function(){
			     \$container.masonry($opts);
			    });  
			"); 
		
		}
		js_file($base.'/jquery.masonry.min.js');
		js_file($base.'/jquery.imagesloaded.min.js'); 
	}
}