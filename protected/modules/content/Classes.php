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
				$all = DB::all($relate,array(
					'where'=>array(
						'nid'=>$nid,
						'fid'=>$fid,
					)
				));
				if(count($all) == 1){
					$one = $all[0]['value'];
				}else{
					foreach($all as $al){
						$one[] = $al['value'];
					}
				}
				$batchs[$table][$v['slug']] = $one;  
	 		}
	 	 	$row = (object)array(); 
			foreach($batchs as $table=>$value_ids){
			 	foreach($value_ids as $field_name=>$_id){ 
					$all = DB::all($table,array(
						'where'=>array(
						 	'id'=>$_id
						)
					)); 
					if(count($all) == 1){
						$one = $all[0]['value'];
					}else{ 
						$one = array();
						foreach($all as $al){
							$one[] = $al['value'];
						} 
						
					} 
					$row->$field_name = $one; 
				}
			} 
			
			// relate ship 
			$s = static::structure($slug); 
			foreach($row as $k=>$v){
				$relate = $s[$k]['relate'];  
				if($relate){
					if($relate == 'file'){
						$all = DB::all('file',array(
							'where'=>array(
								'id'=>$v
							)
						));
						$row->$k = $all; 
					}
				}
			}
		//	dump($row);
			
		//	cache($cacheId,$row);
		}
		return $row;
	}
	/**
	* set value for /node/index field. 
	* value is string or array
	*/
	static function field_show_list($slug,$field,$value){
		if(!is_array($value)) return $value;
		$s = static::structure($slug);
		$relate = $s[$field]['relate'];   
		if($relate == 'file'){
			 $value = static::array_first($value);
			 return image($value['path'],array(
			 	'resize'=>array(160,160)
			 ));
		}
					
		
	}
	static function array_first($arr){
		foreach($arr as $ar){
			return $ar;
		}
	}

	 
 
	static function remove_cache($slug,$nid){
		$cacheId = "module_content_node_{$slug}_{$nid}";
		cache($cacheId,false);
	}
	/**
	* create formBuilder need field structure
	*/
 	static function structure($slug){
 		$one = DB::one('content_type_field',array(
 				'where'=>array('slug'=>$slug)
 		));
 		$all = DB::all('content_type_field',array(
 			'where'=>array('pid'=>$one['id'])
 		)); 
 		foreach($all as $v){
 			$n = $v['slug'];
 			//get widget . widget is input/text/dropDonwList ...
 			$w = DB::one('content_type_widget',array(
 				'where'=>array('field_id'=>$v['id'])
 			));
 			$out[$n]['widget'] = $widget = $w['name'];
 			$out[$n]['widget_config'] = unserialize($w['memo']);
 			//get validates
 			$vali = DB::one('content_type_validate',array(
 				'where'=>array('field_id'=>$v['id'])
 			));
 			$validates = unserialize($vali['value']);
 			$out[$n]['validates'] = $validates;
 			$out[$n]['slug'] = $v['slug'];
 			$out[$n]['name'] = $v['name'];
 			$out[$n]['fid'] = $v['id'];
 			$out[$n]['relate'] = $v['relate'];
 			$out[$n]['list'] = $v['list'];
 			$cls = "\app\modules\content\widget\\$widget\widget"; 
 			$out[$n]['mysql'] = $cls::node_type(); 
 		}
 	 
 		return $out;
 	}
 	 
 
}