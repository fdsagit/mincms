<?php 
namespace app\modules\content; 
use app\modules\content\models\NodeActiveRecord;
class Widget extends \yii\base\Widget
{
	public $label;
    public $name;//field name
    public $model;
    public $form;
  	public $value;
  	public $_opt;
  	public $slug;
  	public $structure;
  	function init(){
  		parent::init();
  		$name = $this->name;   
		$this->slug = $_GET['name'];
		$this->structure =  Classes::structure($this->slug);
		$this->_opt = $this->structure[$name]['widget_config']; 
		if(!$this->model){
			$model =  new NodeActiveRecord;
			$model::$table = $this->name;
			$this->model = $model;
			$this->model->rules = array(); 
		} 
  		if($this->value)
  			$this->model->$name = $this->value;
  			
  	}
  	 
}