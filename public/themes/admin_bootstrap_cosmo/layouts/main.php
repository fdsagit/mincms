<?php
use yii\helpers\Html;
use yii\widgets\Menu; 
 
/**
 * @var $this \yii\base\View
 * @var $content string
 */
$this->registerAssetBundle('bootstrap');
//select2

widget('select2');
js("$(function(){
	$('.flash-message,.info').delay(2500).fadeOut();
});");
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo __('backend admin'); ?></title>
	<?php $this->head(); 
	css_file('css/admin.css');
	css_file(theme_url().'css.css');
	js_file('js/admin.js');
	css_file('misc/bootstrap/css/cosmo.css'); 
	css("
	.label{
	 min-height: 25px;
	 line-height: 36px;	
	}		
	a.label-info{
		min-height: 25px;
		line-height: 36px;
		padding: 0 0 0 6px;
		color: black;
	}
	blockquote span.label-info{
		min-height: 25px;
		line-height: 36px;
		padding: 0 0 0 6px; 
	}
	");
	?>
 
</head>
<body>
<?php if(uid() == 1){?>
<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
		    <div class="container"> 
			      <a class="brand" href="<?php echo url('core/config/index');?>"><?php echo __('backend admin');?></a>
			      <div class="nav-collapse collapse"> 
			    		<?php echo Menu::widget(array(
							'options' => array('class' => 'nav '), 
							'activateParents'=>true,
							'submenuTemplate'=>'<ul class="dropdown-menu">{items}</ul>',
							'items' => app\core\Menu::get(),
						)); ?> 
						<div style="padding-top: 6px; float:right;">	
							<?php echo widget('switchlanguage'); ?>
						</div>
			      </div><!--/.nav-collapse -->  
		  </div>  
	</div>

<?php }?>
<div class="navbar <?php if(uid()!=1){?>navbar-fixed-top<?php }?>">
	  <div class="navbar-inner"   >
		  	   <div class="container">  
				    <ul class="nav">
				    <?php 
				    $all = \app\modules\content\Classes::cck_list();
				    $active = \app\core\Menu::active(); 
				    foreach($all as $vo){
				    	
				    ?>
				      <li <?php if($active && in_array('content/node/cck/'.$vo['slug'] , $active)){ ?>
				        	class="active" <?php }?>
				      ><a href="<?php echo url('content/node/index',array('name'=>$vo['slug']));?>#table"><?php echo $vo['name'];?></a></li>
				    <?php } ?>
				    </ul>
				    	
				    <ul class="nav pull-right">
                     	 
                       	 <li class="dropdown">
                       	 	 	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo \Yii::$app->user->identity->username;?></a> 
                       			<ul class="dropdown-menu">
                       				<li><a href="#"><?php echo __('change password');?></a></li>
                       				<li><a href="<?php echo url('auth/open/logout');?>"><?php echo __('logout');?></a></li>
                       			
                       			</ul>
                       	</li>
                    </ul>
		  </div>
	</div>	  
</div>
 </div>
    
<div class="container" <?php if(uid()==1){?>style="margin-top:120px;"<?php }?>>
	<?php $this->beginBody(); ?> 
	<?php echo \yii\widgets\Breadcrumbs::widget(array(
		'homeLink'=>array('label'=>__('home'),'url'=>array('core/config/index')),
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : array(),
	)); ?>
 	 
	<?php 
		//显示flash message
		foreach(array('success','error') as $type){
		if(has_flash($type)){?>
		<div class="alert alert-<?php echo $type;?> flash-message"><?php echo flash($type);?></div>
	<?php }}?>
	<div id='update' class='alert alert-success' style='display:none'></div>		
	<?php echo $content; ?>

	

	<?php $this->endBody(); ?>
</div>
<footer class="footer">
  <div class="container">
    <p><?php echo copyRight();?></p>
    <p>Template by <a href="http://twitter.github.io/bootstrap/" target='_blank'>Twitter Bootstrap</a></p>
  </div>
</footer>  
</body>
</html>
<?php $this->endPage(); ?>
