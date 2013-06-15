<?php namespace app\modules\content\widget\image;  
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \app\modules\content\Widget
{  
	
  	static function content_type(){  
		return "<input type='hidden' name='Field[relate]' value='file'>";
	}
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		$name = $this->name;  
 	 	
 		$id = "NodeActiveRecord[".$name."]";
 		echo widget('plupload',array(
 			'field'=>$id
 		));	 
	}
}