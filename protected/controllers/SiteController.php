<?php namespace app\controllers;
use app\core\DB;
use app\core\FrontController;
use app\models\LoginForm;
use app\models\ContactForm; 

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
		$this->active = 'site.index';  
		return $this->render('index');
	} 
	
 	function actionTest(){    
 		$this->active = 'site.test';  
 		dump(node('post',1));
 		$data = node_pager('post',null,1);
  		$data['cart_test'] = DB::all('cart_test'); 
		return $this->render('test',$data);
 	}
	 
}
