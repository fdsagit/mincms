<?php namespace app\modules\content\controllers; 
use app\modules\content\models\Field;
use app\modules\content\models\FieldView;
use app\modules\content\models\Widget;
use app\modules\content\Classes;
use app\core\DB;
/**
* plugin controller
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class PluginController extends \app\core\AuthController
{ 
 
	function init(){
		parent::init();
		 
	}
	function actionIndex(){  
		$this->layout = 'default';
	 	$class = base64_decode($_GET['class']);
	 	$arr = explode('::',$class);
	 	$class =  $arr[0];
	 	$cls = '\app\plugin\\'.$arr[0];
	 	$method = $arr[1];
	 	$view = $arr[2];
	 	$field = $arr[3]; 
  		$data =  $cls::$method(); 
  		if($field){
  			$data['field'] = $field;
  		}
  		if($view){
  			echo $this->render('@app/plugin/'.$class.'/'.$view , $data);
  		}
	}
 
	 
}
