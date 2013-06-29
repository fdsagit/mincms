# MinCMS 快速入门

- [安装](#installation)
- [路由](#routing)
- [皮肤及视图](#view)
- [控制器](#controller)
- [数据库操作](#eloquent-orm) 

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
由于路由有顺序关系，请在后台直接拖拽以更新路由规则的顺序 
```
<a name="view"></a>
## 皮肤及视图
请在后台安装并启用theme模块。以方便切换前端皮肤。
无须手动更改当前皮肤。




