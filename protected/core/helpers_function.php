<?php
/**
* 非系统内置函数
* 用户可在这里添加自己的function
* @author Sun < mincms@outlook.com >
* @since Yii 2.0
*/

function image($file,$option=null,$params=null){
	$url =  module_class('imagecache.Classes.image',$file,$option);
	return \yii\helpers\Html::img($url,$params);
}