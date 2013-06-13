<?php 
namespace app\modules\cart;  
use app\core\DB; 
use app\modules\member\Auth;
/**
 * 会员登录时自动把购物车转到会员下
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Hook
{
	static function cart_init($arr){
		$mid = $arr['mid'];
		$unique = \Yii::$app->controller->guest_unique;  
		$one = DB::one('cart',array(
			'where'=>array('unid'=>$unique)
		));
		if($one){
			DB::update('cart',array(
				'mid'=>$mid
			),'unid=:unid',array(':unid'=>$unique)); 
		} 
		 
	}
 
}