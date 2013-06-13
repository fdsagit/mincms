<?php namespace app\controllers;
use app\core\DB;
use app\core\FrontController;
use app\models\LoginForm;
use app\models\ContactForm;
use app\vendor\Geo;
use yii\helpers\FileHelper;
 
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
		new FileHelper;
		exit;
		$this->active = 'site.index';  
		echo $this->render('index');
	} 
 	function actionTest(){   
 		$this->active = 'site.test';  
 	//	echo Geo::getCity() . ', ' . Geo::getCountry();exit;
 		$data['cart_test'] = DB::all('cart_test');
		echo $this->render('test',$data);
 	}
	 
}
