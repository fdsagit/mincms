<?php namespace app\modules\content\widget\hidden;  
use yii\helpers\Html;
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
	 	echo Html::hiddenInput($this->_name,$this->value); 
 	 	
	}
}