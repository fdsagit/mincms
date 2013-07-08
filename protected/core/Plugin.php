<?php namespace app\core;
/**
* Plugin Widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @link http://www.starplugins.com/cloudzoom   get license  
* @link http://mincms.com/demo-cloudzoom.html   demo
* @version 2.0.1
*/

class Plugin extends \yii\base\Widget
{  
	public $tag;
	public $id;
	public $class;
 	public $params;
 	public $cls;
 	public $url;
 	public $field;
 	/**
 	* in a view  $field is current field name
 	*
 	* Example
 	*
 	*  <code>
 	*   namespace app\plugin;  
 	*	class CkeditorImage extends \app\core\Plugin
	*	{  		
	*		//find::CkeditorImageFind find is static function. CkeditorImageFind is view file
	*		function run(){    
	*			$this->url .= 'find::CkeditorImageFind::'.$this->field;  
	*			$data['url'] = $this->url; 
	*			echo $this->view('CkeditorImage',$data);
	*		}
	*		
	*		static function find(){ 
	*			$data = (array)DB::pager('file');  
	*			return $data; 
	*		}
	*		
	*	}
	* </code>
 	*/
	function init(){  
		parent::init(); 
		$this->field = $this->params['tag'];
		$this->tag = 'nodeactiverecord-'.$this->field; 
		$this->id = '#'.$this->tag;
		$this->class = '.'.$this->tag;
		unset($this->params['tag']);
		$cls =  get_class($this);
		$this->cls = str_replace('app\plugin\\','',$cls);
		$this->url = $this->cls.'::';
	}
	function view($name,$data = array()){ 
		return $this->render('@app/plugin/'.$this->cls.'/'.$name , $data);
	}
}