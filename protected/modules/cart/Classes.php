<?php 
namespace app\modules\cart; 
use app\core\DB;  
use app\modules\member\Auth;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	static $cart_table_id;
	static $product_id;
	/**
	* 总价格
	*/
	static function total(){
		return static::get_carts(); 
	}
	/**
	* 更新购物车的数量
	*/
	static function num($id,$add = 1){ 
		$id = (int)$id;
		if($id<1) return;
		$one = DB::one('cart_temp',array(
	 		'where'=>"id=$id and qty>0",
	 		'orderBy'=>'qty desc'
	 	));  
	 	if($add == 1){
	 		$num = $one['qty']+1;
	 	}else{
	 		$num = $one['qty']-1;
	 	} 
		DB::update('cart_temp',array(
				'qty'=>$num
			),'id=:id',array(':id'=>$one['id']));
	 	
	}
	/**
	* 返回产品详细信息
	* 如 名称 价格 图片
	*/
	static function product($cart){
		$cart_table_id  = $cart['cart_table_id'];
		$id  = $cart['product_id']; 
		$arr = static::cart_table($cart_table_id); 
	 	$table = trim($arr['table']);
	 	$name = trim($arr['name']);
	 	$sales = trim($arr['sales']);
	 	$all = trim($arr['nums']);
	 	$img = trim($arr['img']);
	 	$price = trim($arr['price']);  
	 	$one = DB::one($table,array(
	 		'where'=>array('id'=>$id)
	 	)); 
	 	return array(
	 		'id'=>$one['id'],
	 		'name'=>$one[$name],
	 		'price'=>$one[$price],
	 		'img'=>$one[$img],
	 	);
	}
	/**
	* 取得当前用户的购物车
	*/
	static function get_carts(){
		$mid = Auth::id();//会员ID
		$unique = \Yii::$app->controller->guest_unique; 
		if($mid>0)
			$where['mid'] = $mid;
		else
			$where['unid'] = $unique;
		$all = DB::all('cart_temp',array(
			'select'=>'id,sum(qty) qty,product_id,mid,cart_table_id,unid,created',
			'where'=>$where,
			'groupBy'=>'product_id'
		));   
	 
		$nums = count($all)?:0; 
		$i=0;
		$total = 0;
		foreach($all as $v){  
			 $one =  Classes::product($v); 
			 $out[$i] = $one;
			 $out[$i]['cid'] = $v['id'];//购物车中的ID
			 $out[$i]['qty'] = $v['qty'];
			 $out[$i]['total']  = $one['price']*$v['qty']; 
			 $total +=$one['price']*$v['qty']; 
			 $i++;
		}
	 	$data['all'] = $out; 
	 	$data['total'] = $total; 
	 	$data['nums'] = $nums; 
	 	
		return $data;
	}
	/**
	* 产品加入购物车
	*/
	static function cart(){
		$mid = Auth::id();//会员ID
		$unique = \Yii::$app->controller->guest_unique;
		$arr = array(
			'product_id'=>static::$product_id,
			'cart_table_id'=>static::$cart_table_id,
			'qty'=>1,
			'mid'=>$mid,
			'unid'=>$unique,
			'created'=>time(),
		);
		$where['product_id'] = static::$product_id;
		if($mid>0)
			$where['mid'] = $mid;
		else
			$where['unid'] = $unique;
		$one = DB::one('cart_temp',array(
			'where'=>$where
		)); 
		if(!$one){ 
			DB::insert('cart_temp',$arr);
		}else{
			$qty = $one['qty']+1;
			DB::update('cart_temp',array(
				'qty'=>$qty
			),'id=:id',array(':id'=>$one['id']));
		}
	}
	 
	 /**
	 * 取得剩余产品数
	 */
	 static function less($slug,$product_id){
	 	$arr = static::cart_table($slug); 
	 	$product_table = trim($arr['table']);
	 	$product_name = trim($arr['name']);
	 	$product_sales = trim($arr['sales']);
	 	$product_all = trim($arr['nums']);
	 	//设置加入购物车时的table_id,目的是支持不同表的产品加入购物车
	 	static::$cart_table_id = $arr['id'];
	 	//设置产品ID
	 	static::$product_id = $product_id;
	 	$one = DB::one($product_table,array(
	 		'where'=>array('id'=>$product_id)
	 	));
	 	$less = (int)($one[$product_all]  -  $one[$product_sales]);
	 	return $less;
	 }
	 /**
	* 取得 cart_table 设置购物车支持多个数据表，默认为default.
	*/
	static function cart_table($slug){ 
	    $cacheId = "table_cart_table"; 
	    $all = cache($cacheId);
	    if(!$all){
	    	$data = DB::all('cart_table');
	    	foreach($data as $v){
	    		$all[$v['slug']] = $v;
	    		$all[$v['id']] = $v;
	    	}
	    	cache($cacheId,$all);
	    } 
	    return $all[$slug];
	 }
}