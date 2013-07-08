<?php namespace app\modules\video\controllers; 
/**
* video  manage
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class AdminController extends \app\core\AuthController
{ 
 
	function init(){
		parent::init();
		$this->active = array('video','video.site.index');
	 
	}
	/**
	* video  lists
	*/ 
	public function actionIndex()
	{    
	 
		return $this->render('index');
	}

	 
}
