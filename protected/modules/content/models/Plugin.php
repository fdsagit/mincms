<?php namespace app\modules\content\models; 

use yii\helpers\Html;
class Plugin extends \app\core\ActiveRecord 
{
 
 
	public static function tableName()
    {
        return 'content_type_plugin';
    } 
    function scenarios() {
		 return array( 
		 	'default' => array('field_id','name','memo'),
		   
		 );
	}
	public function rules()
	{ 
		return array(
			array('field_id, name', 'required'),  
		);
	} 
	 
 
	 
}