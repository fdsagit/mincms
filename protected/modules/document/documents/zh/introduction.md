# MinCMS 快速入门

- [安装](#installation)
- [路由](#routing)
- [皮肤及视图](#view)
- [控制器](#controller)
- [数据库操作](#db) 

<a name="installation"></a>
## 安装

#### linux下安装 Composer

	php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"

进入项目目录并执行

	php composer.phar install 

	 
#### windows下安装 Composer
下载 [Composer.exe](http://getcomposer.org/Composer-Setup.exe)
进入项目目录并执行

	composer install 

如果 composer 安装超时请尝试以下方式

	COMPOSER_PROCESS_TIMEOUT=4000  composer update

<a name="routing"></a>
## 路由

路由有对应的route模块。默认已启用。
在系统中找到 url路由 点击，可以创建需要的路由
	
	第一个参数为
	list-[id:\d+]-[page:\d+]
	第二个参数为对应的控制器动作
	default/list
```
由于路由有顺序关系，请在后台直接拖拽以更新路由规则的顺序.
```

```
如何因为设置路由导致网站不能访问，请确认路由是否正确
```
<a name="view"></a>
## 皮肤及视图
请在后台安装并启用theme模块。以方便切换前端皮肤。
无须手动更改当前皮肤。

<a name="controller"></a>
## 控制器
以oauth模块为例，`SiteController.php` 的代码如下

	<?php namespace app\modules\oauth\controllers; 
	use app\modules\oauth\models\OauthConfig;
	use app\core\DB; 
	class SiteController extends \app\core\AuthController
	{ 
	}

其中需要后台权限的控制必须继承 `\app\core\AuthController` 

如是前端共用页面请继承 `\app\core\FrontController`

<a name="db"></a>
## 数据库

 
	use app\core\DB; 
	DB::one($table,$getway=array());
	DB::all($table,$getway=array());
	DB::insert(nsert($table,$data=array()));
	DB::batchInsert($table, $columns, $rows);
	DB::update($table, $columns, $condition = '', $params = array());
	DB::delete($table, $condition, &$params); 
 

	$data = DB::pagination($table,$params=array(),$route=null);
	返回数组的KEY 分别为pages 与 models
	 
	<?php  echo \yii\widgets\LinkPager::widget(array(
	      'pagination' => $pages,
	  ));?>
 
