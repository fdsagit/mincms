<?php 
namespace app\modules\content; 
class Widget extends \yii\base\Widget
{
	public $label;
    public $name;//field name
    public $model;
    public $form;
  	public $value;
  	public $_opt;
  	function init(){
  		parent::init();
  		$name = $this->name;  
		if($_GET['name']){
			$st = Classes::structure($_GET['name']);
			$this->_opt = $st[$name]['widget_config'];
		}
  		if(!$this->value)
  			$this->value = $this->model->{$this->name};
  	}
  	 
}