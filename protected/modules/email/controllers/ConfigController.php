<?php namespace app\modules\email\controllers; 
use app\modules\email\models\Config; 
use app\core\Arr;
/**  
* @author Sun < mincms@outlook.com >
*/
class ConfigController extends \app\core\AuthController
{ 
 	function init(){
		parent::init();
		$this->active = array('system','email.config.index');
	}
	
	public function actionIndex()
	{   
		$a = array(array('s'=>2)); 
		$model = Config::find()->one();
		if(!$model)
	  		$model = new Config();
	 
	  	$model->scenario = 'all'; 
		if ($model->load($_POST) && $model->save()) {
		 	flash('success',__('mail settings success'));
		 	redirect(url('email/config/index'));
		} 
		return $this->render('index',array('model'=>$model));
	 
	}
	 

	 
}
