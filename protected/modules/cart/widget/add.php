<?php namespace app\modules\cart\widget;  
use app\core\DB;
/**
* 购物车的tip提示
* @author Sun < mincms@outlook.com >
*/
class Add extends \yii\base\Widget
{ 
 	public $slug = 'default';//需要在后台设置好
 	public $id;
 	public $price;
 	public $class = 'btn btn-primary btn-plan-select';
 	public $active = 'btn btn-danger btn-plan-select';
	function run(){ 
		$data['id'] = encode(json_encode(array('slug'=>$this->slug,'id'=>$this->id))); 
		$data['class'] = $this->class;
		$data['active'] = $this->active; 
		echo $this->render('@app/modules/cart/widget/views/add',$data);
	 
	}
}