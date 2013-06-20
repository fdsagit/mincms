<?php namespace app\core;  

/**
public static function active($query)
{
	$pid = (int)$_GET['pid']?:0;
    $query->andWhere('pid = '.$pid);
}
<div class='pagination'>
<?php  echo \yii\widgets\LinkPager::widget(array(
      'pagination' => $pages,
  ));?>
</div>
* @author Sun < mincms@outlook.com >
*/
class Pagination  
{  
	/**
	* support ckeditor pagebreak
	$node = node('post',1); 
 	$data = Pagination::innerPager($node->body);
 		
	<?php echo $row;?>
	<?php echo $pages;?>
	*
	*/
	static function innerPager($str,$pagerbar=null, $class='pagination'){
		if(!$pagerbar)
			$pagerbar = '<div style="page-break-after: always;"><span style="display:none">&nbsp;</span></div>';
		$arr = explode($pagerbar,$str);
		$page = count($arr);
		$p = (int)$_GET['page']?:1;
		$pages = "<div class='".$class."'>";
		$pages .= "<ul>";
	 
		for($i=1;$i<=$page;$i++){
			unset($cls);
			unset($_GET['page']);
			$params = array('page'=>$i);
			if($_GET){
				$params = array_merge($_GET,$params);
			}
			$url = url_action(null,$params);
			if($i==$p)
				$cls = "class='active'";
			$pages .= "<li  $cls ><a href='".$url."'>".$i."</a></li>";
		}
		$pages .= "</ul></div>";
		$row = $arr[$p-1]?:false;
		if($p>$page) return;
		return array('row'=>$row,'pages'=>$pages);
	}
	/**
	*
	 
 		
	*/
	static function next($count){
		$page = (int)$_GET['page']?:1;
		$next = $page+1;
		if($page<=$count){
			$params = array('page'=>$next);
			if($_GET){
				$params = array_merge($_GET,$params);
			}
			$url = url_action(null,$params);
			echo "<div   class='pagination' style='display:none;'><a href='".$url."'></a></div>";
		}else{
			throw new Exception('exception');
		}
	}
 
	/**
	$p = \Vendor\Pager::img($posts,1,true,"apple_pagination showimg");
	$posts = $p[0];
	$pager = $p[1];	
	$per 每页显示几条  $img 是否是图片
	*/
	static function img($arr,$per=2,$img=false, $class='pagination'){	 
		$current = (int)$_GET['page']?:1;
		$top = $current_page-1>0?:1;
		$next = $current_page+1;
		$num = count($arr);
		$page =  ceil($num/$per); 
		if($current>=$page)
			$current = $page;
 		$k=$i = ($current-1) * $per; 
	 	$j = $i+$per;
	 	if($j>= $num) $j = $num;
		foreach($arr as $k=>$v){
			$n[] = $v;	  
		} 
		for($i;$i<$j;$i++){
			$post[] = $n[$i];
		}
	 	$p = "<div class='".$class."'>";
		for($i=1;$i<=$page;$i++){
			unset($cls);
			if($i==$current)
				$cls = "class='current'";
			if($img==true){
				$p .= "<span><a href='?page=".$i."' $cls   data-content=\"<img src='".image($n[($i-1)*$per],array(400,300))."'/>\" >".$i."</a></span>";
			}
			else 
				$p .= "<span><a href='?page=".$i."' $cls >".$i."</a></span>";
		}
		$p .= "</div>";
		return array($post,$p);
	}
	/**
	*
	Controller:
	$rt = \app\core\Pagination::run('\app\modules\core\models\Config');  
 		
	return $this->render('index', array(
	   'models' => $rt->models,
	   'pages' => $rt->pages,
	));
	View:
	echo app\core\widget\Table::widget(array(
		'models'=>$models,
		'pages'=>$pages,
		'fields'=>array('slug','memo')	,
		'title'=>__('do you want remove config')
	));
	*
	*/
	static function run($model,$scope=null,$config=array('pageSize'=>10)){ 
		$query = $model::find(); 
		if($scope){
			if(is_string($scope)){
				$query = $query->$scope();
			}else{
				foreach($scope as $k=>$v){
					if(!is_numeric($k))
						$query = $query->$k($v);
					else
						$query = $query->$v();
				}
			}
		}
		$countQuery = clone $query;
		$pages = new \yii\data\Pagination($countQuery->count(),$config);
		$models = $query->offset($pages->offset)
		  ->limit($pages->limit);
		$models = $models->all();
		return (object)array(
			'pages'=>$pages,
			'models'=>$models
		);
	}
}