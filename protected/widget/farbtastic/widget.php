<?php namespace app\widget\farbtastic;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options;
 	public $to;
	function run(){ 
		if($this->options)
			$opts = Json::encode($this->options);
		$base = publish(__DIR__.'/assets'); 
		
	 
	    js("
	    	$(function(){
	    		$('".$this->tag."').farbtastic('".$this->to."');
	    	});
	    
	    ");
	    css_file($base.'/farbtastic.css'); 
		js_file($base.'/farbtastic.js'); 
	    
	}
}