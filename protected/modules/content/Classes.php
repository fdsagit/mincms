<?php 
namespace app\modules\content; 
use app\core\DB;  
use app\core\Arr;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	static function all($slug,$params=array()){ 
		$table = "node_".$slug;// node table   
		$all = DB::all($table,$params); 
		foreach($all as $model){
			$node = static::one($slug,$model['id']);
			$node->id = $model['id'];
			$node->uid = $model['uid'];
			$node->created = $model['created'];
			$node->updated = $model['updated'];
			$node->admin = $model['admin'];
			$node->display = $model['display']; 
			$out[] = $node;
		}
		return $out; 
	}
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
	static function one($slug,$nid){
		$cacheId = "module_content_node_{$slug}_{$nid}";
		$row = cache($cacheId);
		if(!$row){
			$row = static::_one($slug,$nid);
			// relate ship 
			$s = static::structure($slug); 
			foreach($row as $k=>$v){
				//get relation value
				$relate = $s[$k]['relate'];  
				if($relate){
					$row->$k = static::_relation($s , $k ,$v , $relate);
				}
			} 
		//	dump($row);
			
		//	cache($cacheId,$row);
		}
		return $row;
	}
	static function  _relation($s , $k ,$v , $relate){ 
		if($relate == 'file'){
			$all = DB::all('file',array(
				'where'=>array(
					'id'=>$v
				)
			));
			$return = $all; 
		}else{
			$relate = str_replace('node_' , '' ,$relate);  
			if(is_array($v) && count($v) > 0){ 
				foreach($v as $_v){
					$r = (array)static::_one($relate,$_v);   
					if($r)
						$vo[] = Arr::first($r);
				}
				$return = $vo;
			}else{
				$r = (array)static::_one($relate,$v);  
				if($r)
		 			$return = Arr::first($r);
			}
			
		}
 		return $return;
	}
	/**
	* load one full data
	*/
	static function _one($slug,$nid){   
		$table = "node_".$slug;// node table  
 		//data to [relate] like [node_post_relate]
 		$relate = $table.'_relate'; 
		$structs = static::structure($slug); 
		foreach($structs as $k=>$v){ 
			$fid = $v['fid'];//字段ID 
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
			 $value = Arr::first($value);
			 return image($value['path'],array(
			 	'resize'=>array(160,160)
			 ));
		} 
	}
	static function table_columns(){
	 
	 	$all = DB::all('content_type_field');
		unset($tables , $table);
		foreach($all as $v){   
			$slug = $v['slug'];
			$stuct =  Classes::structure($slug);
			if(!$stuct) continue;
	 		foreach($stuct as $field=>$config){
	 			$fs[] = $field; 
	 		}
	 		$tables['node_'.$slug] = Arr::first($fs); 
	 		$table['node_'.$slug] = 'node_'.$slug;
		}
	 
		$data = array('table'=>$table,'tables'=>$tables);		
		return $data;
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
 				'where'=>array('slug'=>$slug),
 				'orWhere'=>array('id'=>$slug),
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