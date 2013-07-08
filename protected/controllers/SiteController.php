<?php namespace app\controllers;
use app\core\DB;
use app\core\FrontController;
use app\models\LoginForm;
use app\models\ContactForm; 
use app\core\Pagination;
class SiteController extends FrontController
{ 
	function init(){
		parent::init();
		\Yii::$app->language = 'zh_cn';
	}
	public function actions()
	{
		return array(
			'captcha' => array(
				'class' => 'yii\web\CaptchaAction',
			),
		);
	}
	public function actionConnect()
	{
		$this->active = 'site.connect'; 
		return $this->render('connect');   
 	}
	public function actionIndex()
	{        
		$this->active = 'site.index';  
		$data['videos'] = node_all('video',array(
			'limit'=>6*2
		)); 
		$posts = node_all('posts',array(
			'limit'=>8,
			'where'=>array(
				'img'=>1
			)
		)); 
		 
		$data['posts'] = $posts;
		$data['imgs'] = node_all('ablum',array(
			'limit'=>6*2
		)); 
		return $this->render('index' , $data);
	}
	
	function actionPictures(){
 		$data = node_pager('ablum',null,6*5); 
		$this->active = 'site.pictures';  
		return $this->render('pictures' , $data);
	}
	function actionPicture($id){
		if($id < 1 ) throw new ExceptionClass(__('not work')); 
		$data['post'] = node('ablum',$id);
		$this->active = 'site.pictures';  
		return $this->render('picture',$data);
	}
	function actionMasters(){
 		$data = node_pager('master',null,10); 
		$this->active = 'site.masters';  
		return $this->render('masters' , $data);
	}
	function actionMaster($id){
		if($id < 1 ) throw new ExceptionClass(__('not work')); 
		$data['post'] = node('master',$id);
		$this->active = 'site.masters';  
		return $this->render('master',$data);
	}
	
	function actionPosts(){
 		$data = node_pager('posts',null,6*5); 
		$this->active = 'site.posts';  
		return $this->render('posts' , $data);
	}
	function actionPost($id){
 		$data['post'] = node('posts',$id); 
		$this->active = 'site.posts';  
		return $this->render('post' , $data);
	}
	function actionAbout(){
		$this->active = 'site.about';  
		return $this->render('about');
	}
 	function actionVideos(){
 		$data = node_pager('video',null,6*5); 
		$this->active = 'site.videos';  
		return $this->render('videos' , $data);
	}
	function actionVideo($id){
		$node = node('video',$id); 
		$data['id'] = $id;
		$data['post'] = $node;
		$this->active = 'site.videos';  
		return $this->render('video',$data);
	}
 
 
 
	 
}
