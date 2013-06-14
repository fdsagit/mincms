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
	}
	/**
	* ajax加入购物车
	*/
	public function actionIndex()
	{ 
		$this->layout = false;
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
	/**
	* [id] => 1
    [name] => IPHONE 10
    [price] => 6000
    [img] => upload/t/1.jpg
    [qty] => 15
    [total] => 90000
	*/
	function actionTip(){ 
		$this->layout = false;
		$all = Classes::get_carts(); 
		$arr = array(theme_path().'_elements/cart','cart');    
		return $this->render($this->view($arr),$all);   
	}
	/**
	* 结算
	*/
	function actionDo(){
		$data = Classes::get_carts();
	 	$arr = array(theme_path().'_elements/do','do');  
		return $this->render($this->view($arr),$data); 
	}
	/**
	* 个数相加
	*/
	function actionNum(){
		$cid = $_GET['cid'];
		$flag = $_GET['flag'];
		if($cid < 1 ) return ; 
		Classes::num($cid,$flag);
		$t =  Classes::total(); 
		echo json_encode(array('total'=>$t['total'],'nums'=>$t['nums']));
	}

	 
}
