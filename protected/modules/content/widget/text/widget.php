<?php namespace app\modules\content\widget\text;  
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
	}
}