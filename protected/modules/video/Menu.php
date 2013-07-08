<?php 
namespace app\modules\video; 
class Menu
{
	static function add(){
		$menu['extend'] = array( 
			'video'=>array('video/admin/index'), 
		); 
	 
		return $menu;
	}
}