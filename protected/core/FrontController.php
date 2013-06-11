<?php namespace app\core;  
/**
*  front controller
* 
* @author Sun < mincms@outlook.com >
*/
class FrontController extends Controller
{ 
 
	public $guest_unique;//访问用户的唯一值
	public $active;
	public $theme = 'default';
	function init(){
		parent::init();  
	 	$unique = cookie('guest_unique');  
		if(!$unique){ 
			$unique = uniqid(); 
			cookie('guest_unique',$unique);
		}
		$this->guest_unique = $unique; 
	}
 
}