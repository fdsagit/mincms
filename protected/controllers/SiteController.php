<?php namespace app\controllers;
use app\core\DB;
use app\core\FrontController;
use app\models\LoginForm;
use app\models\ContactForm; 
use app\core\Pagination;
class SiteController extends FrontController
{ 
	public function actions()
	{
		return array(
			'captcha' => array(
				'class' => 'yii\web\CaptchaAction',
			),
		);
	}
 
	public function actionIndex()
	{      
		$a = \app\modules\content\Classes::_one('post',13); 
		dump($a);
		dump(node('post',13));exit;
		
		$this->active = 'site.index';  
		return $this->render('index');
	}
	public function actionDebug()
	{      
	 //	$this->layout = false;
		return $this->render('debug');
	}  
	
 	function actionTest(){    
 		$this->active = 'site.test';  
 	 	$node = node('post',1); 
 		//$data = Pagination::innerPager($node->body);
 	 
  		$data['cart_test'] = DB::all('cart_test'); 
		return $this->render('test',$data);
 	}
	 
}
