<?php namespace app\modules\content\widget\ckeditor;  
use app\modules\content\Classes;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \app\modules\content\Widget
{  
  
 	static function node_type(){  
		 return 'text';
	}
	function run(){  
		$name = $this->name;  
	 
 		echo $this->form->field($this->model,$name)->textArea();
 		$id = "nodeactiverecord-".$name;	 
 		widget('ckeditor',array(
 			'tag'=>$id,
 			'options'=>$this->_opt
 		));
	}
}