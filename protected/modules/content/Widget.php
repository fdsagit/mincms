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
  	public $slug;
  	public $structure;
  	function init(){
  		parent::init();
  		$name = $this->name;   
		$this->slug = $_GET['name'];
		$this->structure =  Classes::structure($this->slug);
		$this->_opt = $this->structure[$name]['widget_config']; 
  		if(!$this->value)
  			$this->value = $this->model->{$this->name};
  	}
  	 
}