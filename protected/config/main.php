<?php   
/**
* load modules
* 加载模块
*/
$modules = cache_pre('all_modules'); 
//默认系统模块
$modules['core'] = 1;
$modules['auth'] = 1;
$modules['imagecache'] = 1;
$modules['file'] = 1;
$modules['route'] = 1; 
$module['debug'] = array(
	 'class' => "yii\debug\Module"
); 
if($modules){
	foreach($modules as $k=>$v){
		$module[$k] = array(
			 'class' => 'app\modules\\'.$k.'\Module'
	    );
	}
} 
$modules = $module;	  
$route = cache_pre('route')?:array();
$default_route = array(
	'admin'=>'core/config/index',
	'imagine'=>'imagecache/site/index',
	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
);
$routes = array_merge( $route , $default_route);
 
return array(
	'id' => 'hello',
	'timeZone'=>'Asia/Shanghai',
	'language'=>'zh_cn', 
	'basePath' => dirname(__DIR__),
	'preload' => array('log'), 
	'modules' => $module,
	'components' => array(  
		'cache' => array(
			'class' => 'yii\caching\FileCache', 
		), 
		'assetManager' => array(
			'bundles' => require(__DIR__ . '/assets.php'),
		),
		'log' => array(
			'class' => 'yii\logging\Router',
			'targets' => array(
				/*array(
					'class' => 'yii\logging\FileTarget',
					'levels' => array('error', 'warning'),
				),*/
				array(
					'class' => 'yii\logging\DebugTarget',
				)
			),
		),
	
		/**
		*
		*/
		'db' => array(
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=books',
			'username' => 'test',
			'password' => 'test',
			'charset' => 'utf8', 
			'enableSchemaCache'=> !YII_DEBUG,
		),
			
		'urlManager' => array(
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl'=>true,
			'suffix'=>'.html',
			'rules'=>$routes,  
		), 
		'user' => array(
			'class' => 'yii\web\User',  
			'autoRenewCookie'=>false,
			'identityCookie'=>array('name' => 'admin_identity', 'httponly' => true),
			'identityClass' => 'app\modules\auth\models\User',
		),
		'view' => array( 
            'theme' => array(
            	'class' => 'app\core\Theme' 
		    ), 
        ),
			
	),
	'params' => require(__DIR__ . '/params.php'),
);
