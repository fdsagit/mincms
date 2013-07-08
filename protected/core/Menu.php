<?php namespace app\core;  
use app\core\Arr;
/**
*  Menu菜单
* <?php $this->widget(Menu::className(), array(
				'options' => array('class' => 'nav '),
				'activateParents'=>true,
				'submenuTemplate'=>'<ul class="dropdown-menu">{items}</ul>',
				'items' => app\core\Menu::get(),
			)); ?>
* @author Sun < mincms@outlook.com >
*/
class Menu
{ 
	static function active(){
		if(property_exists(\Yii::$app->controller,'active')){
			$active = \Yii::$app->controller->active;
			if(!is_array($active)) $active = array($active);
			if($active){
				foreach($active as $v){
					$v = str_replace('.','/',$v);
					if(strpos($v,'.')!==false)
						$ac[] = url($v);
					else
						$ac[] = $v;
				}
			}
			$active = $ac;
	 	}
	 	return $active;
	}
	/**
	*
	use yii\widgets\Menu;
	$action = \Yii::$app->controller->full_action;
	$menu = array(
		'cart list'=>array('cart/admin/index'),  
		'cart area'=>array('area/admin/index'), 
		'cart discount'=>array('cart/admin/discount'), 
		'cart email notice'=>array('cart/admin/notice'), 
		'cart set'=>array('cart/admin/set'), 
	);

	echo Menu::widget(array(
			'options' => array('class' => 'nav '), 
			'activateParents'=>true, 
			'items' => \app\core\Menu::next($menu,$action=='cart.admin.index'?true:false),
		));
	*/
	static function next($menus,$flag = true){ 
		if(property_exists(\Yii::$app->controller,'active')){
			$active = \Yii::$app->controller->active;
			if(!is_array($active)) $active = array($active);
			if($active){
				foreach($active as $v){
					$v = str_replace('.','/',$v);
					if(strpos($v,'.')!==false)
						$ac[] = url($v);
					else
						$ac[] = $v;
				}
			}
			$active = $ac;
	 	}  
	 	$i=0;
		foreach($menus as $key=>$val){ 
			unset($actived);  
			if(in_array($val[0],$active)){
				$actived = 'active';
			}     
			if($i==0 && $flag===false) $actived = '';
			$menu[$key] = array('label' => __($key), 'url' =>$val,'options'=>array(
					'class'=>"$actived",  
				), 
			);
			$i++; 
		} 
		return $menu;
	} 
	/**
	* 生成后台导航菜单
	*/
	static function get(){ 
		/**
		* 控制器中可设置当前启用的URL
		$this->active = array('system','i18n.site.index');
		*/
		if(property_exists(\Yii::$app->controller,'active')){
			$active = \Yii::$app->controller->active;
			if(!is_array($active)) $active = array($active);
			if($active){
				foreach($active as $v){
					$v = str_replace('.','/',$v);
					if(strpos($v,'.')!==false)
						$ac[] = url($v);
					else
						$ac[] = $v;
				}
			}
			$active = $ac;
	 	}
		$modules = cache_pre('all_modules'); 
		if($modules){
			foreach($modules as $k=>$v){
				$file = \Yii::$app->basePath."/modules/{$k}/Menu.php";
				if(file_exists($file)){
					$cls = "app\modules\\".$k."\Menu";
					$menus = $cls::add(); 
					foreach($menus as $key=>$val){
						if(!$menu[$key]){
							unset($actived); 
							if(Arr::array_in_array($key,$active)){
								$actived = 'active';
							}    
							$menu[$key] = array('label' => __($key), 'url' =>'#','options'=>array(
									'class'=>"dropdown $actived",  
								),
								'template'=>"<a href=\"{url}\" data-toggle='dropdown' class='dropdown-toggle'>{label}</a>",
							);
						}
						foreach($val as $_k=>$_u){
						 	unset($actived); 
							if(Arr::array_in_array($_u,$active)){
								$actived = 'active';
							}  
							$menu[$key]['items'][] = array('label' => __($_k), 'url' => ($_u),'options'=>array(
								'class'=>$actived,
							));
						}
					}
				}
			}
		}  
	     
		return $menu;
		 
	}
}