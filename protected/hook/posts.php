<?php
namespace app\hook;
use app\core\Img;
class Posts{
	
	static function beforeSave($insert){
		$body = $insert->body;
		$img = Img::get_local_img($body);
		if($img){
			$insert->img = true;
		}else {
			$insert->img = false;
		}
		return $insert;
	}
	static function afterFind(){
		
	}
}