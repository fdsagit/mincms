<?php namespace app\modules\cart\widget;  
use app\core\DB;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class List extends \yii\base\Widget
{ 
 	public $img = true;
	function run(){ 
		
		echo $this->render('@app/modules/cart/widget/views/list',$data);
	 
	}
}