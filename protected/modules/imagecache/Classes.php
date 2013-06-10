<?php 
namespace app\modules\imagecache; 
use app\core\DB; 
use app\core\File;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	 static function image($args){ 
	    $file = $args[1];
	    $option = $args[2]; 
	    if(!is_array($option)){
	    	$option = static::get_image($option);
	    } 
	    if(!$option) $option = array('resize'=>array(300,200));
		if(is_array($option)){
			$s = base64_encode(json_encode($option));
		} 
		$name = File::name($file);
		$ext = File::ext($file);
		//如果有upload/ 则替换
		if(substr($name,0,7)=='upload/'){
			$name = substr($name,7);
		} 
		return base_url()."imagine/".$name."=$s{$ext}";
	}
	
	static function get_image($id){
		$cacheId = "table_imagecache_".$id;
		$one = cache($cacheId);
		if(!$one){
			$one = DB::one("imagecache",array(
				'where'=>array(
					'id'=>$id
				),
				'orWhere'=>array(
					'slug'=>$id
				),
			));
			if(!$one){
				return array();
			}
			$one['memo'] = unserialize($one['memo']);
			foreach($one['memo'] as $k=>$v){
				if(!in_array($k,$one['memo']['_type']))
					unset($one['memo'][$k]);
			}
			unset($one['memo']['_type']);
			$one = $one['memo'];
			cache($cacheId,$one);
		}
		return $one;
	}
}