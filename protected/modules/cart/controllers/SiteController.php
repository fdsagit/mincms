<?php namespace app\modules\cart\controllers; 
/**
*  ���ﳵ��ֻ�й���Ա����
*  ���ǻ�Ա���ܿ����� extends app\modules\member\AuthController
*  ���ǹ���Ա���ܿ����� extends \app\core\AuthController
* 
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \app\core\AuthController
{ 
	public function actionIndex()
	{ 
		return $this->render('index');
	}

	 
}
