<?php namespace app\modules\cart\controllers;  
use app\modules\cart\models\Tables;
/**
*  购物车，只有管理员看到
*  如是会员才能看到的 extends app\modules\member\AuthController
*  如是管理员才能看到的 extends \app\core\AuthController
* 
* @author Sun < mincms@outlook.com >
*/
class AdminController extends \app\core\AuthController
{ 
	function init(){
		parent::init();  
	}
	public function actionIndex()
	{ 
		$this->active = array('extend','cart.admin.index');
		return $this->render('index');
	}
	/**
	* 设置cart数据库信息
	*/
	public function actionSet($id=nll)
	{ 
		$this->active = array('extend','cart.admin.set','cart.admin.index'); 
		if($id>0)
			$model = Tables::find($id);
		else
			$model = new Tables();
	 	$model->scenario = 'all'; 
		if ($this->populate($_POST, $model) && $model->validate()) {  
		 	$model->save();
		 	if($id>0)
		 		flash('success',__('update sucessful'));
		 	else
		 		flash('success',__('create sucessful'));
			$this->redirect(url('cart/admin/set'));
		} 
		$rt = \app\core\Pagination::run('\app\modules\cart\models\Tables');  
		
		return $this->render('set', array(
		   'model' => $model, 
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		   'id'=>$id
		));
		
	 
	}

	 
}
