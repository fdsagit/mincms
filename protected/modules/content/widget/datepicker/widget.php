<?php namespace app\modules\content\widget\datepicker;  
use app\core\DB;
use yii\helpers\Html; 
/**
*  
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Widget extends \app\modules\content\Widget
{   
  	 
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		hook_add('beforeSave',"\app\modules\content\widget\datepicker\Widget");
		hook_add('afterFind',"\app\modules\content\widget\datepicker\Widget");
		$name = $this->name;  
		if(is_array($this->model->$name)) $this->model->$name = ''; 
		echo  Html::textInput($this->_name,$this->value , array('id'=>$this->id ));   
 	 
 		widget('datepicker',array('tag'=>'#'.$this->id , 'options'=>$this->_opt)); 
	}
	static function beforeSave(){
		
		exit;
	}
	static function afterFind(){
		
		exit;
	}
}