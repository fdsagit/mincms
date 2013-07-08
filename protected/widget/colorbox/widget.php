<?php namespace app\widget\colorbox;  
use yii\helpers\Json;
use yii\helpers\Html;
/**
* colorbox widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://www.jacklmoore.com/colorbox/    offical website
* @link http://mincms.com/demo-colorbox.html   demo
* @version 2.0.1
*/

class Widget extends \yii\base\Widget
{  
	/**
	* html element
	*/
 	public $tag; 
 	/**
 	* theme support 1 to 5
 	*/ 
 	public $theme = 1;
 	/**
 	* array options
 	*/
 	public $options; 
  
 	/**
	*  
	* Example 
	*  
	* <code> 
	*	widget('colorbox',array(
	*		'tag'=>'.insertCK',
	*		'theme'=>3,
	*       'options'=>array()
	*	));
	*</code> 
	*/ 
	function run(){   
		$base = publish(__DIR__.'/assets');   
		$this->options['previous']='';
		$this->options['next']='';
		$this->options['close']='';
		$opts = Json::encode($this->options);    
		if($this->tag) 
			js("$('".$this->tag."').colorbox($opts);");    
		else
			js("$.colorbox($opts);");    
		css_file($base.'/example'.$this->theme.'/colorbox.css');
		js_file($base.'/jquery.colorbox-min.js');  
		 
	}
}