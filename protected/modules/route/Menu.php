<?php 
namespace app\modules\route; 
class Menu
{
	static function add(){
		$menu['system'] = array( 
			'route'=>array('route/site/index'), 
		); 
		return $menu;
	}
}