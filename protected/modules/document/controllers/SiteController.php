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
 
	public function actionIndex()
	{    
		return $this->render('index');
	}

	 
}
