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
		if(YII_DEBUG ===true){ 
			\app\core\Modules::load();  
		}elseif(!cache_pre('all_modules'))
			\app\core\Modules::load();  
			
	}
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		hook('action_before'); 
		return true;
	}
	public function afterAction($action, &$result)
	{
		parent::afterAction($action, $result);
		hook('action_after'); 
		return true;
	}
	function redirect($url){
		return redirect($url);
	}
	/**
	* 渲染多个视图中第一个存在的视图
	$arr = array(theme_path().'_elements/do','do'); 
	echo $this->render($this->view($arr),$data); 
	*/
	function view($path){
		foreach($path as $p){ 
			$file  = $this->findViewFile($p); 
			$flag = false;
			if(strpos($p,'@www/themes')!==false){
				$file = root_path().$file; 
				$flag = true;
			}
			if(file_exists($file)){
				if($flag === true) 
					return "@app/../public/".substr($p,5);
				else
					return $p;
			}
		}
	}
}