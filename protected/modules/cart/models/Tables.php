<?php namespace app\modules\cart\models;   
class Tables extends \app\core\ActiveRecord 
{ 
	public static function tableName()
    {
        return 'cart_table';
    } 
    function scenarios() {
		 return array( 
		 	'all' => array('table','name','price','nums','sales','slug'), 
		 );
	}
	public function rules()
	{ 
		return array(
			array('table,name,price,nums,sales,slug', 'required'), 
			array('slug','unique'),
			array('slug', 'match','pattern'=>'/^[a-z_]/', 'message'=>__('match')), 
		);
	}  
	function beforeSave($insert){
		parent::beforeSave($insert);
		$this->img = $_POST['Tables']['img'];
		return true;
	}
	 
}