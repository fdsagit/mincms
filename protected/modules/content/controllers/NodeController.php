<?php namespace app\modules\content\controllers;   
use app\modules\content\models\Field;
use app\modules\content\models\Widget;
use app\modules\content\models\FormBuilder;
use app\modules\content\Classes;
use app\core\DB;
/** 
* @author Sun < mincms@outlook.com >
*/
class NodeController extends \app\core\AuthController
{ 
 	
	function init(){
		parent::init();
		$this->active = array('content','content.node.index'); 
	}
	function actionSort(){ 
 		$ids = $sort = $_POST['ids']; 
 	 	$slug = $_POST['name']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "node_{$slug}";
 		$fid = $id; 
 		foreach($ids as $k=>$id){ 
 		 	DB::update($table,
	 			array(
	 				'sort'=>$sort[$k]
	 			),'id=:id', array(':id'=>$id)
 		 	); 
 		}   
 		return 1; 
	}
	function actionDisplay($name,$id){
		$id = (int)$id;
		if($id<1) exit;
		$table = "node_{$name}";
		$one = DB::one($table,array(
			'where'=>array('id'=>$id)
		));
		$display = $one['display']==1?0:1;
		DB::update($table,array(
			'display'=>$display
		),'id=:id',array(':id'=>$id)); 
		flash('success',__('sucessful'));
		$this->redirect(url('content/node/index',array('name'=>$name)));
	}
	
	public function actionCreate($name)
	{  
		$one = Field::find()->where(array('slug'=>$name))->one();
		$this->view->title = __('create');
		return $this->render('form',array(
			'name'=>$name,
			'one'=>$one
		));
	}
	public function actionUpdate($name,$id)
	{  
		$one = Field::find()->where(array('slug'=>$name))->one();
		$this->view->title = __('update').' #'.$id;
		return $this->render('form',array(
			'name'=>$name,
			'one'=>$one,
			'id'=>$id
		));
	}
	public function actionDelete($id){
		if($_POST['action']==1){ 
			$model = Field::find($id); 
			$model->delete();
			echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete success')));
			exit;
		} 
	}
	/***
	* content list
	*/
	public function actionIndex($name=null,$rest=null)
	{    
	 	if($name) {
	 		/**
		 	* set filter cookie.
		 	* if no post [NodeActiveRecord] will try use cookie
		 	*/
		 	$filterCookieId = "filter_cookie_".md5(cookie('guest_unique').uid().$name); 
		 	$filters =  cookie($filterCookieId);  
		 	if($rest){
		 		remove_cookie($filterCookieId);  
		 		flash('success',__('reset filter success'));
		 		redirect(url('content/node/index',array('name'=>$name)));
		 	}
		 	if($_POST['NodeActiveRecord']){ 
		 		$post = $_POST['NodeActiveRecord'];
		 	 	$filters = array();
		 	 	$hidden = $_POST['hidden']; 
		 		foreach($post as $k=>$v){
		 			if($v){ 
		 				if($hidden[$k]){
		 					$filters[] = array($k,'like',trim($v));
		 				}
		 				else{
		 					$filters[$k] = trim($v);
		 				}
		 			}
		 		} 
		 		if($filters)
		 			cookie($filterCookieId,$filters); 
		 		flash('success',__('set filter success'));
		 	}
		 	$condition['orderBy'] = 'sort desc,id desc';
		 	if($filters){
		 		$condition['where'] = $filters;
		 	}
		 	  
		 	/**
		 	* load pager data
		 	*/
	 		$data = Classes::pager($name,$condition);
	 		$data['name'] = $name;
	 		$one = DB::one('content_type_field',array(
		 		'where'=>array('slug'=>$name,'pid'=>0)
		 	)); 
		 	if(!$one['id']) {
		 		
		 		exit;
		 	}
		 	$fid = $one['id'];	
		 	$data['fid']  = $fid;
		 	$data['filters']  = $filters;
		  
		 	
	 	}
		$data['types'] = Field::find()->where(array('pid'=>0))->all(); 
 		
		return $this->render('index' ,$data );
	}

	 
}
