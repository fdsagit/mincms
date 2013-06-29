<?php namespace app\modules\email\controllers; 
use  app\modules\email\models\Send;
/**  
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \app\core\AuthController
{  
	
	function init(){
		parent::init();
		$this->active = array('extend','email.site.index');
	}
	
	public function actionIndex()
	{   
 		$model = new Send;
 		$model->scenario = 'all';
		if ($model->load($_POST) && $model->validate()) {
			//send mail
		 	\app\modules\email\Mailer::send($model->title,$model->body,array($model->to_email=>$model->to_name),$attachment=null);
		 	flash('success',__('send mail success'));
		 	redirect(url('email/site/index'));
		}
	   
		return $this->render('index',array('model'=>$model));
	 
	}
	 

	 
}
