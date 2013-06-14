<?php namespace app\modules\content\controllers;   
use app\modules\content\models\Field;
use app\modules\content\models\Widget;
use app\modules\content\models\FormBuilder;
use app\modules\content\Classes;
/** 
* @author Sun < mincms@outlook.com >
*/
class NodeController extends \app\core\AuthController
{ 
 	
	function init(){
		parent::init();
		$this->active = array('content','content.node.index'); 
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
	public function actionIndex($name=null)
	{    
	 	if($name) {
	 		$data = Classes::pager($name,array('orderBy'=>'sort desc,id desc'));
	 		$data['name'] = $name;
	 	}
		$data['types'] = Field::find()->where(array('pid'=>0))->all(); 
 		
		return $this->render('index' ,$data );
	}

	 
}
