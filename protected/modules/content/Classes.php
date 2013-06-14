<?php 
namespace app\modules\content; 
use app\core\DB;  
 
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	/**
	* create formBuilder need field structure
	*/
 	static function structure($slug){
 		$one = DB::one('content_field',array(
 				'where'=>array('slug'=>$slug)
 		));
 		$all = DB::all('content_field',array(
 			'where'=>array('pid'=>$one['id'])
 		));
 		foreach($all as $v){
 			//get widget . widget is input/text/dropDonwList ...
 			$w = DB::one('content_widget',array(
 				'where'=>array('field_id'=>$v['id'])
 			));
 			$out[$v['slug']]['widget'] = $w['name'];
 			//get validates
 			$vali = DB::one('content_validate',array(
 				'where'=>array('field_id'=>$v['id'])
 			));
 			$validates = unserialize($vali['value']);
 			$out[$v['slug']]['validates'] = $validates;
 		}
 		return $out;
 	}
 
}