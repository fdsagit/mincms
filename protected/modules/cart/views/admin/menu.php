<?php  
use yii\widgets\Menu;
$action = \Yii::$app->controller->full_action;
$menu = array(
	'cart list'=>array('cart/admin/index'),  
	'cart area'=>array('area/admin/index'), 
	'cart discount'=>array('cart/admin/discount'), 
	'cart email notice'=>array('cart/admin/notice'), 
	'cart set'=>array('cart/admin/set'), 
);


?>
<div class="navbar">
  <div class="navbar-inner">
    <?php
		echo Menu::widget(array(
			'options' => array('class' => 'nav '), 
			'activateParents'=>true, 
			'items' => \app\core\Menu::next($menu,$action=='cart.admin.index'?true:false),
		));
	?>
  </div>
</div>

