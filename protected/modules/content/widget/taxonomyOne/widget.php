<?php namespace app\modules\content\widget\taxonomyOne;  
use app\modules\content\Classes;
use yii\helpers\Html;
use app\core\Arr;
use app\core\DB;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \app\modules\content\Widget
{  
	public $theme;	
	/***
	* when content type choice relation
	*/
  	static function content_type($selected=null){  
  		$all = Classes::all('taxonomy',array('orderBy'=>'sort desc,id desc'),true);   
  	 	foreach($all as $v){
			$taxonomy[$v->id] = $v;
		} 
  		$all = \app\core\Arr::tree($taxonomy);  
  		if(!$all) $all = array();
  		else{
  			foreach($all as $k=>$v){
  				$n['taxonomy:'.$k] = $v;
  			}
  			$all = $n;
  		}
  		$id = $_GET['id'];  
  		$str = '<div class="control-group">';   
 		$str .= "<p class='controls'>".Html::dropDownList('Field[relate]',$selected,$all,array('id'=>'Field_relate','style'=>'width:260px'))."</p>"; 
  	 	$str .= "</div>"; 
 		return $str; 
	}
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		unset($all);
		$name = $this->name;   
 		$relate = $this->structure[$name]['relate'];
 		$root = str_replace('taxonomy:','',$relate); 
 		$all = Classes::all('taxonomy',array('orderBy'=>'sort desc,id desc'),true);   
  	 	foreach($all as $v){
			$taxonomy[$v->id] = $v;
		}  
		$a1[''] = __('please select');    
  		$all = \app\core\Arr::tree($taxonomy,'name','id','pid',$root);  
  		if(!$all) $all = array(); 
  		else{
  			$all = $a1+$all;
  		} 
 		
 		echo $this->form->field($this->model,$name)->dropDownList($all); 
 		 
	}
}