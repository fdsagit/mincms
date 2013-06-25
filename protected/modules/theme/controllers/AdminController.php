<?php namespace app\modules\theme\controllers;  
use app\modules\core\Classes;
/**
* themes manager
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license personal
* @license http://mincms.com/licenses
*/
class AdminController extends \app\core\AuthController
{ 
	public $theme_selected = 'admin';
	public $theme_selected_front = 'default';
	function init(){
		parent::init();  
	}
	function actionSelected($name){ 
		$key = '_theme_admin';
		$value = Classes::get_config($key); 
		Classes::set_config_lock($key,$name);
		cache_pre_delete('hooks');
		flash('success',__('sucessful'));
		$this->redirect(url('theme/admin/index'));
	}
	function actionSelectedfront($name){ 
		$key = '_theme_front';
		$value = Classes::get_config($key); 
		Classes::set_config_lock($key,$name);
		cache_pre_delete('hooks');
		flash('success',__('sucessful'));
		$this->redirect(url('theme/admin/index'));
	}
	/**
	* theme lists
	*/
	public function actionIndex()
	{ 
		if(Classes::get_config('_theme_admin'))
			$this->theme_selected = Classes::get_config('_theme_admin');
		if(Classes::get_config('_theme_front'))
			$this->theme_selected_front = Classes::get_config('_theme_front');
		$dir = root_path()."themes";
		$list = scandir($dir); 
		foreach($list as $vo){   
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{ 
				 
				if(file_exists($dir.'/'.$vo.'/info.php')){
					$data[$vo] = include $dir.'/'.$vo.'/info.php';
				} 
				 
			}
		}
		if($data){
			foreach($data as $k=>$v){
				if($v['admin']){
					$theme['admin'][$k] = $v;
				}else{
					$theme['front'][$k] = $v;
				}
			}
		}
	 
		$this->active = array('extend','theme.admin.index');
		$theme['actived'] = $this->theme_selected;
		$theme['actived_front'] = $this->theme_selected_front;
		return $this->render('index',$theme);
	}
	 

	 
}
