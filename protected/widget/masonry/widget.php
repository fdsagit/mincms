<?php namespace app\widget\masonry;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; 
 	public $bottom = true;
 	public $itemSelector = '.item';
	function run(){   
		$base = publish(__DIR__.'/assets');  
 		$tag = $this->tag; 
		$bottom = $this->bottom?:true; 
		$itemSelector = $this->itemSelector?:'.item';
		if(!$this->options['itemSelector'])
	 		$this->options['itemSelector'] = $itemSelector;
		$opts = Json::encode($this->options);  
		
		if(array_key_exists('scroll',$old) && $old['scroll']===true){
			js_file($base.'/jquery.infinitescroll.js');
			css("#infscr-loading{clear:both; position: absolute;padding-left:10px;bottom: -25px;width: 200px;}#infscr-loading img{float: left;margin-right: 5px;}");
		 	js("
				var \$container = $('".$tag."');
		 		\$container.imagesLoaded(function(){
			     \$container.masonry($params);
			    });   
				var \$container = $('".$tag."');
					\$container.infinitescroll({ 
					loading:{ 
				    	img:'".$base."/ajax-loader.gif',
					    msgText:'".__('loading content¡­¡­')."',  
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
		}else{
			js("
				var \$container = $('".$tag."');
		 		\$container.imagesLoaded(function(){
			     \$container.masonry($params);
			    });  
			"); 
		
		}
		js_file($base.'/jquery.masonry.min.js');
		js_file($base.'/jquery.imagesloaded.min.js'); 
	}
}