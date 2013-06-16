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
		$wh = $params['where'];
		$params['orderBy'] = $params['orderBy']?:"sort desc , id desc";
		$flag = false;
		if($wh){
			foreach($wh as $w=>$v){
				if(!in_array($w,static::default_columns())){
					$flag = true;
				}
			}
		}
		if($flag === false){ 
			$all = DB::all($table,$params); 
		}else{
			$_params = static::params($slug,$params); 
			$sql = "SELECT t.* FROM  $table t " . $_params['sql'] ;
			if($_params['where']) 
				$sql .= " WHERE ".$_params['where'];
			$sql .= " ORDER BY ".$_params['orderBy'];
			if($params['limit'])
				$sql .= " LIMIT  ".$params['limit'];
			$all = DB::queryAll($sql); 
		} 
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
	* where , orderBy , and so on conditions.
	* some fileds not in the master table. like node_post
	* it is in node_post_relate
	* 
	*/
	static function params($slug,$params){
		$structure = static::structure($slug); 
		$relate_table = "node_{$slug}_relate";
		/**
		'where'=>array(
			'type'=>1
		),
		*/
		$wh = $params['where'];
		if($wh){
			foreach($wh as $w=>$v){
				if(!in_array($w,static::default_columns())){
					$f = $structure[$w];  
					$fid = $f['fid'];
					$relate = $f['relate'];
					if($relate){
						$int_table = "content_int";
						$one = DB::one($int_table,array(
							'select'=>'id',
							'where'=>array(
								'value'=>$v
							)
						)); 
						$value = $one['id'];
					}
					$alias = $slug.'_'.$f['slug'];
				 	$sql .= "
				 		LEFT JOIN $relate_table $alias
				 		ON {$alias}.nid = t.id 
				 	";
				 	$where .= " {$alias}.fid = $fid
				 			AND `value` = $value";
					  
				}
			}
		}
		$orderBy = $params['orderBy']; 
		$arr = explode(',',$orderBy);
		unset($orderBy);
		foreach($arr as $v){
			$ar = explode(' ',$v); 
			foreach($ar as $k=>$v){
				if($v){
					$new[] = $v;
				}
			}
			
		}
		$i = 0; 
		foreach($new as $v){
			if($i%2 != 0 ){
				$field = $new[$i-1];
				$sort = $v;
			 	$orderBy .= $field . " ".$sort .",";
			}
			$i++;
		} 
		return array('sql'=>$sql,'where'=>$where ,'orderBy'=>substr($orderBy,0,-1));
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
		$wh = $params['where'];
		$params['orderBy'] = $params['orderBy']?:"sort desc , id desc";
		if(!is_array($config)) $config = array('pageSize'=>$config);
		$flag = false;
		if($wh){
			foreach($wh as $w=>$v){
				if(!in_array($w,static::default_columns())){
					$flag = true;
				}
			}
		}
		if($flag === false){  
			$pager = DB::pagination($table,$params,$config,$route);
			$models = $pager->models;
		}else{
			$_params = static::params($slug,$params); 
			$sql = "SELECT t.* FROM  $table t " . $_params['sql'] ;
			$count_sql = " SELECT count(*) count FROM  $table t  " .$_params['sql'] ;
			if($_params['where']) {
				$sql .= " WHERE ".$_params['where'];
				$count_sql .= " WHERE ".$_params['where'];
			} 
			$one = DB::queryRow($count_sql); 
			$count = $one['count'];  
			$pages = new \yii\data\Pagination($count,$config); 
			if($route)
				$pages->route = $route;
			$offset = $pages->offset > 0 ? $pages->offset:0;
			$limit = $pages->limit > 0 ? $pages->limit:10;     
			$sql .= " ORDER BY ".$_params['orderBy'];
			$sql .= " LIMIT $offset,$limit ";
			$models = DB::queryAll($sql);  
		} 
	 
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
		
			if(is_array($v) ){ 
				if( count($v) < 1 ) return ;
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
 			$widget =  $out[$n]['widget'] = $w['name'];
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
 	static function default_columns(){
 		return array(
			'id',
			'display',
			'sort',
			'created',
			'updated',
			'admin',
			'uid'
		);
 	}
 	 
 
}