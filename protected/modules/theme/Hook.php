<?php 
namespace app\modules\theme; 
use app\modules\core\Classes; 
class Hook
{
	static function action_init_front(){
		$arr = func_get_args();
 		$obj = $arr[0]; 
		$value = Classes::get_config('_theme_front');  
		if($obj->theme != 'default') return;
		if($value){ 
			$obj->theme = $value;
		} 
	}
 	static function action_init_auth(){
 		$arr = func_get_args();
 		$obj = $arr[0]; 
		$value = Classes::get_config('_theme_admin'.uid());  
		if($value){ 
			$obj->theme = $value;
		}
	}
}