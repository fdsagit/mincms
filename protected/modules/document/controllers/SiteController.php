<?php namespace app\modules\document\controllers;  
use app\core\DB;
/**
*   
* 
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \app\core\FrontController
{ 
	function init(){
		parent::init();
		$this->active = "document.site.index"; 
	} 
 
	public function actionIndex($name='quick')
	{   
		$lang = 'zh';
		$path = __DIR__.'/../documents/'.$lang.'/';
		$home = $path.'documentation.md';
		$data['home'] = @file_get_contents($home);
		$data['path'] = $path;
		$data['body'] = @file_get_contents($path.$name.'.md');
		return $this->render('index',$data);
	}
	
	function actionTest($name='masonry'){    
 		$this->active = 'site.test';  
 	 	$node = node('post',1); 
 		//$data = Pagination::innerPager($node->body);
 	 
  		$data['cart_test'] = DB::all('cart_test'); 
  		$data['name'] = $name;
		return $this->render('test',$data);
 	}

	 
}
