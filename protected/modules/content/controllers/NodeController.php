<?php namespace app\modules\content\controllers;   
use app\modules\content\models\Field;
use app\modules\content\models\Widget;
use app\modules\content\models\FormBuilder;
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
		$this->view->title = __('create content');
		return $this->render('form',array(
			'name'=>$name,
			'one'=>$one
		));
	}
	public function actionUpdate($name,$id)
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
		   'name'=>$name,  
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
	public function actionIndex($name='posts')
	{    
	 	
		$data['types'] = Field::find()->where(array('pid'=>0))->all(); 
 		
		return $this->render('index' ,$data );
	}

	 
}
