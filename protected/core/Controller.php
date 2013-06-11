<?php namespace app\core;  
use yii\base\Theme; 
/**
*  default controller
* 
* @author Sun < mincms@outlook.com >
*/
class Controller extends \yii\web\Controller
{ 
	public $theme = 'classic';
	//启用的菜单
	public $active; 
	function init(){
		parent::init();  
		language(); 
		hook('action_init');  
		/*
		* load modules 
		* 加载模块
		*/
		if(!cache_pre('all_modules'))
			\app\core\Modules::load();  
	}
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		hook('action_before'); 
		return true;
	}
	public function afterAction($action)
	{
		parent::afterAction($action);
		hook('action_after'); 
		return true;
	}
	function redirect($url){
		return redirect($url);
	}
}