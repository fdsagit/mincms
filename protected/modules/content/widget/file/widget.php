<?php namespace app\modules\content\widget\file;  
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \app\modules\content\Widget
{  
  
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		$name = $this->name;  
 		echo $this->form->field($this->model,$name)->textArea();	 
	}
}