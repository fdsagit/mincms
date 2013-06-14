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
		echo $this->render('index');
	} 
 	function actionTest(){   
 		$this->active = 'site.test';  
  		$data['cart_test'] = DB::all('cart_test');
		echo $this->render('test',$data);
 	}
	 
}
