<?php namespace app\widget\datepicker;  
use yii\helpers\Json;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; 
	function run(){  
		if(!$this->options['timeFormat'])
		 	$this->options['timeFormat'] = "HH:mm";
		if($this->options)
			$opts = Json::encode($this->options);
		$base = publish(__DIR__.'/assets');  
 		if(!$this->tag) return; 
 		js(" 
 			$('".$this->tag."').timepicker(".$opts."); 
 		");  
 		js_file("js/jui/jquery-ui.js");
 		css_file("js/jui/css/flick/jquery-ui.min.css"); 
 		js_file($base."/jquery-ui-timepicker-addon.js");
 		css_file($base."/css.css");
	}
}