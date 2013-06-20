<?php namespace app\modules\content\classes; 
use app\modules\content\models\Field;
use app\modules\content\models\NodeActiveRecord;
use app\modules\content\Classes;
use app\core\DB;
use app\core\Arr; 
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Node{ 
	/**
	* 
	$node = node_save('post',array(
  	 	'title'=>1,
  	 	 'body'=>$str
  	 ));
	*/
	static function save($name,$array=array(),$nid=null){
		if($array['id']) {
			$nid = $array['id'];
			unset($array['id']);
		}
		$model = new NodeActiveRecord;
	 	$structure = Classes::structure($name); 
		$model::$table = $name;
		if($nid>0){
			$row = Classes::_one($name,$nid);
	 		foreach($row as $k=>$v){
	 			$model->$k=$v;
	 		} 
		}
		$data = Node::set_rules($structure);
		//加载插件
		if($plugins) {
			/*foreach($plugins as $pk=>$plugin)
			widget($pk,$plugin);*/
		}
		$attrs_data = $data['attrs'];  
	 	/**
	 	* 验证规则赋值给Model中的ruels属性
	 	*/
		$model->rules = $data['rules']; 
		$attrs = array();
 		foreach($attrs_data as $get){
 			$attrs[$get] = trim($array[$get]);
 		}
 		$return = static::save_model($name,$model,$attrs,$nid,true);
 		return str_replace('##ajax-form-alert##','',$return);
	}
	/**
 	*  save content base on FormBuilder
 	* @params $name content_type_name
 	* @params $model Model
 	* @params $attrs 属性
 	* @params $return 为true时返回nid
 	*/
 	static function save_model($name,$model,$attrs,$nid=null,$return=false){   
 		foreach($attrs as $key=>$value){
 			$model->$key = $value; 
 		} 
 		$out = "##ajax-form-alert##:";
 		if(!$model->validate()){
 			$errors = $model->getErrors(); 
 			$out.= "<ul class='alert alert-error info'>";
 			foreach($errors as $key=>$e){
 				foreach($e as $r)
 					$out.= '<li>'.$r.'</li>';
 			}
 			$out.="</ul>"; 
 			if(true === $return){
 				return $out;
 			}
 			exit($out);
 		}  
 		// get  structure 
 		$structs = Classes::structure($name); 
 		$table = "node_".$name;// node table  
 		//data to [relate] like [node_post_relate]
 		$relate = $table.'_relate'; 
 		if($nid>0){   
 		 	$display = 1;
 		 	if($model->display)
 				$display = $model->display; 
 		    	DB::update($table,array( 
			 			'updated'=>time(),
			 			'display'=>$display, 
			 		),'id=:id',array( ':id'=>$nid)
			 		);  
 		 
 		}else{ 
	 		DB::insert($table,array(
		 			'created'=>time(),
		 			'updated'=>time(),
		 			'uid'=>uid()
		 		)); 
	 		$nid = DB::id();
 		}   
 		foreach($structs as $k=>$v){ 
 			if($value = $model->$k){ //属性有值时 才会查寻数据库
 				$fid = $v['fid'];//字段ID
 				$table = "content_".$v['mysql'];  
 				unset($_check_relate[$table][$fid]);
 				if($v['relate']){
 					$_check_relate[$table][$fid] = true;  
 				}
 				$batchs[$table][$fid][] = $value;  
 				$wherein[$table][] = $value;  
 			} 
 		}   
 		/**  
		[content_text] => Array
		    (
		        [3] => Array
		            (
		                [0] => 222
		            )

		    ) 
 		*/  
 	   
 		foreach($batchs as $table=>$values){ 
 			//echo Arr::deep($value); 
 		 	foreach($values as $fid=>$v){ //$k  filed_id
 		 		foreach($v as $_v){ // $_v value  
 		 			if(is_array($_v)){
 		 				$_v = array_unique ($_v); 
 		 				if($nid>0){
 		 					DB::delete($relate,'nid=:nid and fid=:fid',
	 		 					array( 
					 				':nid'=>$nid ,
					 				':fid'=>$fid 
					 			)
				 			); 
				 		}  
 		 				foreach($_v as $_nv){ 
 		 					if(! $_check_relate[$table][$fid] )
 		 						$value = static::__save_array($table , $_nv ,$relate ,$fid ,$nid); 
 		 					else
 		 			 			$value = $_nv;
 		 					DB::insert($relate,array( 
				 				'nid'=>$nid ,
				 				'fid'=>$fid,
				 				'value'=>$value
				 			)); 
 		 				} 
 		 			}else{  
 		 				if(! $_check_relate[$table][$fid] )
 		 					$value = static::__save_array($table , $_v ,$relate ,$fid ,$nid);  
 		 			 	else
 		 			 		$value = $_v; 
 		 				$one = DB::one($relate,array( 
				 				'where'=>array(
					 				'nid'=>$nid ,
					 				'fid'=>$fid,
				 			 	)
				 			));  
						//$value  is node value id
						if(!$one){ 
							DB::insert($relate,array( 
				 				'nid'=>$nid ,
				 				'fid'=>$fid,
				 				'value'=>$value
				 			)); 
						}elseif($one['value']!=$value){
							 DB::update($relate,array(  
				 				'value'=>$value
				 			 ),'nid=:nid and fid=:fid',array(
				 			 	':nid'=>$nid ,
				 				':fid'=>$fid,
				 			 ));
						}
 		 			}
 		 			 
 		 		}
 		 	} 
 		}  
 		$out.= 1; 
		//remove cache
		$cacheId = "_one_module_content_node_{$name}_{$nid}";
		cache($cacheId,false);
		$cacheId = "module_content_node_{$name}_{$nid}";
		cache($cacheId,false);
		// create cache
		
		Classes::one($name,$nid);
	 	Classes::_one($name,$nid);
		if(true === $return){ 
			return $nid;
		}
		exit($out);  
 	}
 	static function __save_array($table , $_v ,$relate ,$fid ,$nid){
 		$one = DB::one($table,array(
			'where'=>array(
				'value'=>$_v
			)
		));
		//$value  is node value id
		if(!$one){ 
			DB::insert($table,array( 
 				'value'=>$_v 
 			));
 			$value = DB::id(); 
		}else{
			$value = $one['id'];
		} 
		return $value;
 	}
	/**
	 * 设置验证规则
	 */
	 function set_rules($data){
	 	//set validate rules && plugins
	 	$i=0;  
		foreach($data as $field=>$value){
			/**
			* 对设置中的插件参数进行加载
			*
			*/
			$plugins = $value['plugins'];
			if($plugins){  
				foreach($plugins as $pk=>$plugin){
					/**
					* TAG参数是常规参数，
					* 如对应的是ID，则可以tag:id 或tag:#
					* 如对应的是NAME,则可以tag:name 
					*/
					if($plugin['tag']){
						if(in_array(strtolower($plugin['tag']),array('#','id'))){
							$plugin['tag'] = '#'.$field;
						}elseif(in_array(strtolower($plugin['tag']),array('name'))){
							$plugin['tag'] = $field;
						}
					}
					$out_plugins[$pk] = $plugin;
					//加载插件
					$this->controller->plugin($pk,$plugin);
				}
			}
			/**
			* 设置字段对应的验证规则，
			* 至少有一个验证规则。
			* 如果都没有验证规则，则无法显示表单。
			* 因为数据库不需要保留全为空的值
			*/
			$attrs[] = $field;
			$validates = $value['validates'];
			if(!$validates) continue;
			foreach($validates as $k=>$v){  
				if(is_bool($v) || is_numeric($v) ){
					$rules[$i] = array($field,$k);
				}else if(is_array($v)){ 
					$rules[$i][] = $field; 
					$rules[$i][] = $k; 
					foreach($v as $_k=>$_v){  
						$rules[$i][$_k] = $_v;
					} 
				} 
				$i++;
			}
		} 
		/**
		* 无规则直接报错
		*/
	 	if(!$rules){
	 		exit(__('admin','No Validate Rules'));
	 	} 
		return array(
			'rules'=>$rules,
			'attrs'=>$attrs,
			'plugins'=>$out_plugins,
		);

	 }
	   
	static function delete_cache($name,$nid){
		$cache_id = "node_{$name}_{$nid}"; 
		\Yii::$app->cache->delete($cache_id);
	}  
 	
}