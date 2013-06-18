<?php namespace app\modules\content\controllers; 
use app\modules\content\models\Field;
use app\modules\content\models\FieldView;
use app\modules\content\models\Widget;
use app\modules\content\Classes;
use app\core\DB;
/** 
* @author Sun < mincms@outlook.com >
*/
class SiteController extends \app\core\AuthController
{ 
	public $widget;
	function init(){
		parent::init();
		$this->active = array('content','content.site.index');
		$this->widget = Field::widgets();
		$first[0] = __('please select');
		$this->widget = $first+$this->widget;
	}
	/**
	* set search filed
	*
	*/
	function actionSearch($slug , $name ,$type='search'){
	 	$one = DB::one('content_type_field',array(
	 		'where'=>array('slug'=>$slug,'pid'=>0)
	 	));
	 	if(!$one) exit('access deny');
	 	$fid = $one['id'];	  
	 	$model = FieldView::find()->where(array('fid'=>$fid))->one(); 
	  
	 	if(!$model){
	 		$model = new FieldView;
	 		$model->$type = array($name=>$name);
	 	}else{
	 		$search = $model->$type;
	 		if($model->$type && in_array($name , $model->$type )){  
	 			unset($search[$name]);
	 		 	$model->$type = $search;
	 		}else{
	 		 	$search[$name] = $name;
	 			$model->$type = $search;
	 		}
	 	} 
	 	$model->fid = $fid; 
	 	$model->save();
	 	flash('success',__('set success'));
	 	$cacheId = "modules_content_Class_structure{$slug}";
		cache($cacheId,false);
		
	 	$this->redirect(url('content/node/index',array('name'=>$slug)));
	 	
	}
	function actionAjax(){
		if(!is_ajax()) exit('access deny');
		/**
		* create relate table
		* autoload widget from content module.
		* 
		static function content_type(){  
			return "<input type='hidden' name='Field[relate]' value='file'>";
		}
		*/  
		$w = $_POST['w'];
		if($w){ 
			$selected = $_POST['selected'];	
			$new = \app\modules\content\models\Field::widgets(false,$selected);
		 
			return $new[$w];
		}
	}
	public function actionCreate()
	{  
		$this->view->title = __('create content type');
		$model = new Field();
	 	$model->scenario = 'all';
		if ($this->populate($_POST, $model) && $model->validate()) { 
		 	$model->save();
		 	flash('success',__('create sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model,
		   'name'=>'content', 
		   'widget'=>$this->widget
		));
	}
	public function actionUpdate($id)
	{  
		$this->view->title = __('update content type') ."#".$id;
		$model = Field::find($id);
	 	$model->scenario = 'all';
		if ($this->populate($_POST, $model) && $model->validate()) { 
		 	$model->save(); 
		 	flash('success',__('update sucessful'));
			refresh();
		} 
		return $this->render('form', array(
		   'model' => $model, 
		   'name'=>'content',
		   'widget'=>$this->widget
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
	public function actionIndex()
	{    
		$rt = \app\core\Pagination::run('\app\modules\content\models\Field','active');  
 		
		return $this->render('index', array(
		   'models' => $rt->models,
		   'pages' => $rt->pages,
		));
	}

	 
}
