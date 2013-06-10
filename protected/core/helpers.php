<?php
/**
* Yii 2.0 Helpers
* 
* @author Sun < mincms@outlook.com >
* @since Yii 2.0
*/

/**
* create clean url
* @param  string $url 
* @param  array $parmas 
*/
function redirect($url,$parmas=null){ 
	return \Yii::$app->response->redirect($url,$parmas);
}
function refresh(){ 
	return Yii::$app->response->refresh();
}
/**
* show widget from @app/widget
*/
function widget($name,$params=null){
	if(strpos($name,'::')!==false){
		$arr  = explode('::',$name);
		$name = $arr[0];
		$file = $arr[1];
	}else{
		$file = 'widget';
	}
	$cls = "app\widget\\$name\\$file";
	return $cls::widget($params);
}
function core_widget($name,$params=null){
	$cls = "app\core\widget\\$name";
	return $cls::widget($params);
}
function module_widget($module,$name,$params=null){
	if(strpos($name,'::')!==false){
		$arr  = explode('::',$name);
		$name = $arr[0];
		$file = $arr[1];
	}
	$cls = "app\modules\\$module\widget\\$name";
	if($file) $cls = $cls."\\$file";
	return $cls::widget($params);
}
/**
* 设置及取得上级URL
*/
function return_url($url=null){
	if($url)
		return \Yii::$app->user->setReturnUrl($url);
	return host().\Yii::$app->user->returnUrl;
}

function is_ajax(){ 
	return \Yii::$app->request->isAjax ? true:false;
}
function ip(){
	return \Yii::$app->request->userHostAddress;
}

/**
* setting language
*/
function language($name='language'){
	if($_GET[$name] || cookie($name) ){
 		if($_GET['language']){
 			cookie($name,$_GET['language']);
 		}
 		return \Yii::$app->language = cookie($name);
 	}
}
function host(){
	return \Yii::$app->request->hostInfo;
}
 
 
/**
* setFlash/getFlash
* @param  string $type 
* @param  string $message 
*/
function flash($type,$message=null){ 
	if($message)
		return Yii::$app->session->setFlash($type,$message);
	return Yii::$app->session->getFlash($type);
}
/**
* logined uid
*/
function uid(){
	return \Yii::$app->user->identity->id;
}
/**
* Check Flash Message Exists Or Not
* @param  string $type  
*/
function has_flash($type){ 
	return Yii::$app->session->hasFlash($type); 
}
/**
* Assets Manage
*/
function publish($assets){
	$base = \Yii::$app->view->getAssetManager()->publish($assets);
	return $base[1];
}
function css_file($url, $options = array(), $key = null){
	\Yii::$app->view->registerCssFile($url, $options , $key); 
}
function js_file($url, $options = array(), $key = null){
	\Yii::$app->view->registerJsFile($url, $options , $key); 
}
function css($css){
	\Yii::$app->view->registerCss($css); 
}
function js($js){
	\Yii::$app->view->registerJs($js); 
}

/**
* create clean url
* @param  string $url 
* @param  array $parmas 
*/
function url($url,$parmas=null){ 
	if(true===$url || false===$url){
		$url = \Yii::$app->controller->id.'/'.\Yii::$app->controller->action->id;
		$module = \Yii::$app->controller->module->id; 
		if($module && $module!=\Yii::$app->id)
			$url = $module.'/'.$url;  
	}
	return app\core\Html::url($url,$parmas);
}
function theme_url(){
	return Yii::$app->view->theme->baseUrl.'/';
}
function base_url(){
	return Yii::$app->request->baseUrl.'/';
}
function base_path(){
	return Yii::$app->basePath.'/';
}
function root_path(){
	return Yii::$app->basePath.'/../public/';
}

function url_action($url,$parmas=null){ 
	$url = \Yii::$app->controller->id.'/'.$url;
	$module = \Yii::$app->controller->module->id; 
	if($module && $module!=\Yii::$app->id)
		$url = $module.'/'.$url;  
	return app\core\Html::url($url,$parmas);
}
/**
* i18n translation
* @param  string $str 
* @param  string $file 
*/
function __($message,$category='app',  $params = array(), $language = null){
	return Yii::t($category, trim($message), $params = array(), $language = null);
}
/**
* set cookie or get cookie
*/
function cookie($name,$value=null,$expire=null){
	if(!$value){ 
		return \Yii::$app->request->cookies->getValue($name); 
	}
	$options['name'] = $name;
	$options['value'] = $value;
	$options['expire'] = $expire?:time()+86400*365; 
	$cookie = new \yii\web\Cookie($options);
	\Yii::$app->request->cookies->add($cookie); 
}
function remove_cookie($name){ 
	$options['name'] = $name;
	$options['value'] = null;
	$options['expire'] = 1; 
	$cookie = new \yii\web\Cookie($options);
	\Yii::$app->request->cookies->add($cookie);  
}
/**
* 加载hook
* @ $name 一般为 controller model
*/
function hook($name){
	$hooks = cache_pre('hooks');
	if(!$hooks) return;
	$h = $hooks[$name];
	if($h){
		foreach($h as $li){
			$cls = "\app\modules\\$li\\Hook";
			$cls::$name();
		} 
	} 
 
}
/**
* print_r
* @param  string/object/array $str  
*/
function dump($str){
	print_r('<pre>');
	print_r($str);
	print_r('</pre>');
} 
/**
* before app start run.
* set cache
*/
function cache_pre($name,$value=null){ 
 	return MinCache::set($name,$value);
}
function cache_pre_delete($name){ 
 	return MinCache::delete($name);
}
function cache($name,$value=null,$expire=0){  
	if($value===false) return \Yii::$app->cache->delete($name);
	$data = \Yii::$app->cache->get($name);
	if(!$value) return $data; 
	\Yii::$app->cache->set($name,$value,$expire); 
}
/**
* 判断是否是只能操作自己添加的记录
*/
function self($value){
	$in = app\modules\auth\Auth::in(); 
	if(false === $in){
		return false;
	}else if(in_array($value,$in)){
		return true;
	} 
}
function get_config($name){
	$model = \app\modules\core\models\Config::find(array('slug'=>$name));
	return $model->body;
}
/**
* module_class('image.Classes.image',$file,$option);
namespace app\modules\image;  
class Classes
{
	 static function image($args){
	    $file = $args[1];
	    $option = $args[2]; 
		if(is_array($option)){
			$s = base64_encode(json_encode($option));
		} 
		return "/imagine/".$s.$file;
	}
} 
*/
function module_class(){
	$args = func_get_args(); 
	$classes = $args[0];
	unset($args[0]);  
	$arr = explode('.',$classes);
	$module = $arr[0];
	$class=$arr[1];
	$method=$arr[2];
	$cls = "\app\modules\\$module\\$class";
	return $cls::$method($args);

}

