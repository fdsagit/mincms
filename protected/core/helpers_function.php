<?php
/**
* 非系统内置函数
* 用户可在这里添加自己的function
* @author Sun < mincms@outlook.com >
* @since Yii 2.0
*/
function image_url($file,$option=null){
	$url =  module_class('imagecache.Classes.image',$file,$option);
	return $url;
}
function image($file,$option=null,$params=null){
	$url =  module_class('imagecache.Classes.image',$file,$option);
	return \yii\helpers\Html::img($url,$params);
}

function node($name,$id){
	if(is_array($id)){
		$id['where']['display'] = 1;
		$all = \app\modules\content\Classes::all($name,$id); 
		return $all[0]; 
	}
	return \app\modules\content\Classes::one($name,$id); 
}
/**
*
$data = node_pager('post',array(
	'where'=>array(
		'type'=>$id
	), 
),10); 
return $this->render('list',$data);		
foreach($models as $model){
}
echo \app\core\LinkPager::widget(array(
      'pagination' => $pages,
)); 
*/
function node_pager($slug,$params=array(),$config=null,$route=null){
	$params['where']['display'] = 1;
	return \app\modules\content\Classes::pager($slug,$params,$config,$route); 
}
function node_all($slug,$params=array()){
	$params['where']['display'] = 1;
	return \app\modules\content\Classes::all($slug,$params); 
}
/**
*
$node = node_save('post',array(
 	'title'=>1,
 	 'body'=>$str
 ));
 if $array['id'] will update
*/
function node_save($name,$array=array(),$nid=null){ 
	return \app\modules\content\classes\Node::save($name,$array,$nid); 
}