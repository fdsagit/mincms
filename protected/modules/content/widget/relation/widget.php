<?php namespace app\modules\content\widget\relation;  
use app\modules\content\Classes;
use yii\helpers\Html;
use app\core\Arr;
 
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \app\modules\content\widget\relationOne\Widget
{  
	 function value_type(){
	 	return true;
	 }
	 function run(){  
	 	$name = $this->name;   
 		$relate = $this->structure[$name]['relate']; 
 		//contnet type
 		$values = array(0=>__('please select'));
 		if(strpos($relate , 'node_') !== false){
 			$relate = str_replace('node_' , '' , $relate);
 			$all = Classes::all($relate);  
 			if($all){
	 			foreach($all as $v){  
	 				$v = (array)$v;
	 				$values[$v['id']] = Arr::first($v);
	 			} 
	 		 
 			}
 		} 
		 $this->multiple($values);
	}
	
	
}