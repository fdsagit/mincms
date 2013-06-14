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
	*
	$data = node_pager('post');
	<div class='pagination'>
		<?php  echo \app\core\LinkPager::widget(array(
		      'pagination' => $pages,
		  ));?>
	</div>
	<?php foreach($models as $model){?>
		<p><?php  dump($model);?> </p>
	<?php }?>
	*/
	static function pager($slug,$params=array(),$config=null,$route=null){
		$table = "node_".$slug;// node table   
		if(!is_array($config)) $config = array('pageSize'=>$config);
		$pager = DB::pagination($table,$params,$config,$route);
		$models = $pager->models;
		foreach($models as $model){
			$node = static::one($slug,$model['id']);
			$node->id = $model['id'];
			$node->uid = $model['uid'];
			$node->created = $model['created'];
			$node->updated = $model['updated'];
			$node->admin = $model['admin'];
			$node->display = $model['display']; 
			$out[] = $node;
		}
		return array(
			'models' => $out,
			'pages' => $pager->pages
		);
	}
	
	
	/**
	* load one full data
	*/
	static function one($slug,$nid){  
		$cacheId = "module_content_node_{$slug}_{$nid}";
		$row = cache($cacheId);
		if(!$row){
			$table = "node_".$slug;// node table  
	 		//data to [relate] like [node_post_relate]
	 		$relate = $table.'_relate'; 
			$structs = static::structure($slug); 
			foreach($structs as $k=>$v){ 
				$fid = $v['fid'];//×Ö¶ÎID
				$table = "content_".$v['mysql'];  
				$one = DB::one($relate,array(
					'where'=>array(
						'nid'=>$nid,
						'fid'=>$fid,
					)
				));
				$batchs[$table][$v['slug']] = $one['value'];  
	 		}
	 	 	$row = (object)array();
			foreach($batchs as $table=>$value_ids){
			 	foreach($value_ids as $field_name=>$_id){
					$one = DB::one($table,array(
						'where'=>array(
						 	'id'=>$_id
						)
					));
					$row->$field_name = $one['value']; 
				}
			} 
			cache($cacheId,$row);
		}
		return $row;
	}
 
	static function remove_cache($slug,$nid){
		$cacheId = "module_content_node_{$slug}_{$nid}";
		cache($cacheId,false);
	}
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
 			$n = $v['slug'];
 			//get widget . widget is input/text/dropDonwList ...
 			$w = DB::one('content_widget',array(
 				'where'=>array('field_id'=>$v['id'])
 			));
 			$out[$n]['widget'] = $widget = $w['name'];
 			//get validates
 			$vali = DB::one('content_validate',array(
 				'where'=>array('field_id'=>$v['id'])
 			));
 			$validates = unserialize($vali['value']);
 			$out[$n]['validates'] = $validates;
 			$out[$n]['slug'] = $v['slug'];
 			$out[$n]['name'] = $v['name'];
 			$out[$n]['fid'] = $v['id'];
 			$cls = "\app\modules\content\widget\\$widget\widget"; 
 			$out[$n]['mysql'] = $cls::node_type(); 
 		}
 	 
 		return $out;
 	}
 	 
 
}