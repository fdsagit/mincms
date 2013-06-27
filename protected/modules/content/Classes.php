<?php 
namespace app\modules\content; 
use app\core\DB;  
use app\core\Arr;
use app\core\Str;
use app\modules\content\models\FieldView;
/**
 *  
 * @author Sun < mincms@outlook.com >
 * @Coprighty  http://mincms.com
 */
class Classes
{
	static function all($slug,$params=array(),$backend=false){ 
		$cacheID = "module_content_class_pager_list".$slug;
		if($params){
			$cacheID .=json_encode($params);
		} 
		$cacheID = md5($cacheID); 
		$out = cache($cacheID);
		if(!$out){
			
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
				if(true == $backend){
					$node = static::_one($slug,$model['id']);
				}else{
					$node = static::one($slug,$model['id']);
				}
				$node->id = $model['id'];
				$node->uid = $model['uid'];
				$node->created = $model['created'];
				$node->updated = $model['updated'];
				$node->admin = $model['admin'];
				$node->display = $model['display']; 
				$out[] = $node;
			}
			if(true !== YII_DEBUG)
				cache($cacheID,$out );
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
			$where = " 1=1 ";
			$i=1;
			foreach($wh as $w=>$v){ 
				$i++;
				if(is_array($v)){
					$w = $v[0];
				}
				if(!in_array($w,static::default_columns())){
					$f = $structure[$w];   
					$fid = $f['fid'];
					$relate = $f['relate'];  
					if(!$relate){ 
						$content_table = "content_".$f['mysql'];   
					} else{
						$content_table = $relate;  
					}
					$alias = $slug.'_'.$f['slug'].$i;
					if(is_array($v)){
						$a = $v[0];
						$b = $v[1];
						$c = $v[2];
						$c = Str::escape_str($c); 
						if(trim(strtolower($b))=='like'){
							$c = "%$c%";
						}
						if(!$relate){
							$all = DB::all($content_table,array(
								'select'=>'id',
								'where'=>array(
									$b ,'value', $c
								)
							)); 
						}else{
							/**
							* 此处在关联时有问题
							*
							*/
							/*$all = DB::all($relate,array(
								'select'=>'id',
								'where'=>array(
									'id' =>$v
								)
							)); */
						}
						if($all){
							$value = array();
							foreach($all as $al){
								$value[] = $al['id'];
							}
						}
						$sql .= "
					 		LEFT JOIN $relate_table $alias
					 		ON {$alias}.nid = t.id 
					 	";
					 	$where .= " AND {$alias}.fid = $fid	";
					 	if($value){ 
					 		$where .= " AND {$alias}.`value` in( ".implode(',',$value) .")";
					 	}else{
					 		$where .= " AND {$alias}.`value` = '' ";
					 	} 
						 
					} else{
						$v = Str::escape_str($v);
						if(!$relate){
							$one = DB::one($content_table,array(
								'select'=>'id',
								'where'=>array(
									'value'=>$v
								)
							)); 
							$value = $one['id']; 
							
						} else{
							 $value = $v;  
						}
						$sql .= "
					 		LEFT JOIN $relate_table $alias
					 		ON {$alias}.nid = t.id 
					 	";
					 	$where .= " AND {$alias}.fid = $fid	";
					 	if($value){ 
					 		$where .= " AND {$alias}.`value` = $value ";
					 	}else{
					 		$where .= " AND {$alias}.`value` = '' ";
					 	}
						
					 	
				 	}
					  
				}else{
					if(is_array($v)){
						$a = $v[0];
						$b = $v[1];
						$c = $v[2];
						$c = Str::escape_str($c); 
						if(trim(strtolower($b))=='like'){
							$c = "%$c%";
						}
						$where .= " AND t.$a $b $c	";
					} 
					else{
						$v = Str::escape_str($v);
						$where .= " AND t.$w = $v	";
					}
					 
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
	static function pager($slug,$params=array(),$config=10,$route=null){
		$cacheID = "module_content_class_pager_list".$slug;
		if($params){
			$cacheID .=json_encode($params);
		}
		if($config){
			if(is_array($config)){
				$cacheID .=json_encode($config);
			}else{
				$cacheID .=$config;
			}
		}
		$cacheID .= $route;
		$cacheID = md5($cacheID); 
		$row = cache($cacheID);
		if(!$row){
			$table = "node_".$slug;// node table   
			$wh = $params['where'];
			$params['orderBy'] = $params['orderBy']?:"sort desc , id desc";
			if(!is_array($config)) $config = array('pageSize'=>$config);
			$flag = false;
			if($wh){
				foreach($wh as $w=>$v){
					if(is_array($v)){
						$w = $v[0];
					}
					if(!in_array($w,static::default_columns())){
						$flag = true;
					} 
				}
			}
		 
			if($flag === false){  
				$pager = DB::pagination($table,$params,$config,$route);
				$models = $pager->models;
				$pages = $pager->pages;
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
			$row = array(
				'models' => $out,
				'pages' => $pages
			);
			if(true !== YII_DEBUG)
				cache($cacheID,$row );
		}
		return $row;
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
			if(true !== YII_DEBUG)
				cache($cacheId,$row);
		}
		return $row;
	}
	static function  _relation($s , $k ,$v , $relate){ 
		if($relate == 'file'){
			$condition['where']  = array(
				'id'=>$v
			);
			if(is_array($v))
				$condition['orderBy']  = array('FIELD (`id`, '.implode(',',$v).')'=>''); 
			
			$all = DB::all('file',$condition);
			$return = $all; 
		}else{
			$relate = str_replace('node_' , '' ,$relate);  
			if($relate && strpos($relate,'taxonomy:')!==false){
				$relate = substr($relate,0,strpos($relate,':'));
			} 
			if(is_array($v) ){ 
				if( count($v) < 1 ) return ;
				foreach($v as $_v){	
					$r = (array)static::_one($relate,$_v);   
					if($r)
						$vo[$_v] = Arr::first($r);
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
	// check field value is array
	static function _value_array($widget){
		$widget = 'app\modules\content\widget\\'.$widget.'\Widget';  
		return $widget::value_type(); 
	}
	/**
	* load one full data
	*/
	static function _one($slug,$nid){   
		$cacheId = "_one_module_content_node_{$slug}_{$nid}";
		$row = cache($cacheId);
		if(!$row){
			$table = "node_".$slug;// node table  
	 		//data to [relate] like [node_post_relate]
	 		$relate = $table.'_relate'; 
			$structs = static::structure($slug); 
		  	if(!$structs) return;
			foreach($structs as $k=>$v){  
				$fid = $v['fid'];//字段ID 
				$table = "content_".$v['mysql'];  
				$is_relate = $v['relate']; //判断是不是关联表的值
				if($is_relate && strpos($is_relate,'taxonomy:')!==false){
					$is_relate = substr($is_relate,0,strpos($is_relate,':'));
				} 
				unset($one); 
				 
				$all = DB::all($relate,array(
					'where'=>array(
						'nid'=>$nid,
						'fid'=>$fid,
					),
					'orderBy'=>'id asc'
				));  
				if(count($all) == 1){
					$one = $all[0]['value'];
				}else{ 
					foreach($all as $al){
						$one[$al['value']] = $al['value'];
					}
				} 
				
				$batchs[$table][$v['slug']] = $one;  
				if($is_relate)
					 $new_relate[$v['slug']]= $is_relate;
	 		} 
	 	 	$row = (object)array();   
	 	 	
			foreach($batchs as $table=>$value_ids){
			 	foreach($value_ids as $field_name=>$_id){ 
			 		$condition = array();
			 		$condition['where'] = array(
					 	'id'=>$_id
					); 
					if(is_array($_id)){ 
						$condition['orderBy']  = array('FIELD (`id`, '.implode(',',$_id).')'=>''); 
					} 
					if($new_relate[$field_name]) { 
					 	$one = $_id;
					}else{ 
						$all = DB::all($table,$condition);    
						if(count($all) == 1){
							$one = $all[0]['value'];
						}else{ 
							$one = array();
							foreach($all as $al){
								$one[] = $al['value'];
							}  
						}  
					}
					$rt = static::_value_array($structs[$field_name]['widget']);
					if($rt){
						$d = $one;
						unset($one);
						if($d){
							if(!is_array($d))
								$one[$d] = $d;
							else
								$one = $d;
						}
					}
					if($one)
						$row->$field_name = $one; 
				}
			} 
			if(true !== YII_DEBUG) 
				cache($cacheId,$row);
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
			 if(is_array($value) && $value['path']){
				 return \app\core\File::input_one($value,$field ,false);
			 }
		} else{
			if(is_array($value)){
				return implode($value,',');
			}
			return $value;
			
		}
	}
	static function table_columns(){ 
	 	$all = DB::all('content_type_field',array('where'=>array('pid'=>0)));
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
	 
	
	/**
	* create formBuilder need field structure
	*/
 	static function structure($slug){
 		$cacheId = "modules_content_Class_structure{$slug}";
		$out = cache($cacheId);
		if(!$out){
	 		$one = DB::one('content_type_field',array(
	 				'where'=>array('slug'=>$slug,'pid'=>0),
	 				'orWhere'=>array('id'=>$slug),
	 		));
	 		$all = DB::all('content_type_field',array(
	 			'where'=>array('pid'=>$one['id'])
	 		));   
	 		$field_id = $one['id'];
	 		$model = FieldView::find()->where(array('fid'=>$field_id))->one(); 
	 		$show_list = $model->list;
			$filter = $model->search;  
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
	 			$is_search = $is_list = 0;
	 			if($show_list && in_array($n,$show_list)){
	 				$is_list = 1;
	 			}
	 			if($filter && in_array($n,$filter)){
	 				$is_search = 1;
	 			}
	 			$out[$n]['list'] = $is_list;
	 			$out[$n]['filter'] = $is_search;
	 			$cls = "\app\modules\content\widget\\$widget\widget"; 
	 			$out[$n]['mysql'] = $cls::node_type(); 
	 		}
	 		cache($cacheId,$out);
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