<?php namespace app\modules\cart\controllers; 
use app\core\FrontController;
use app\modules\cart\Classes;
/**
*  AJAX加入购物车
*  如是会员才能看到的 extends app\modules\member\AuthController
*  如是管理员才能看到的 extends \app\core\AuthController
* 
* @author Sun < mincms@outlook.com >
*/
class AjaxController extends \app\core\FrontController
{ 
	function init(){
		parent::init();
		$this->layout = false;
	}
	/**
	* ajax加入购物车
	*/
	public function actionIndex()
	{ 
		if(!is_ajax()) exit('access deny');
		$id = $_POST['id'];
	   	$arr = (array)json_decode(decode($id));
	   	$slug = $arr['slug'];
	   	$product_id = $arr['id'];
	   	$price = $arr['price'];
	   	$less = Classes::less($slug,$product_id); //剩余产品数
	   	if($less<1){ //没有库存了
	   		
	   	}
	   	//加入购物车
	   	Classes::cart();
	   	return true;
	}
	function actionTip(){ 
		$all = Classes::get_carts();
		$data['all'] = $all;
		$data['num'] = count($all)?:0;
		echo $this->render('tip',$data); 
	 
	}

	 
}
