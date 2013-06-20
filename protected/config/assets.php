<?php

return array(
	'bootstrap' => array(
		'basePath' => '@wwwroot',
		'baseUrl' => '@www',
		'css' => array(
			'css/bootstrap.min.css',
			'css/bootstrap-responsive.min.css', 
		),
		'js' => array(
			'js/bootstrap.min.js',
			'js/jquery.form.js',
			'js/jquery-ui.js'
		),
		'depends' => array(
			'yii',
		),
	),
	'jq' => array(
		'basePath' => '@wwwroot',
		'baseUrl' => '@www', 
		'js' => array(
		 
			'js/jquery-ui.js'
		),
	 
	),
	'yii/jquery' => array(
		'basePath' => '@wwwroot',
		'baseUrl' => '@www', 
		'js' => array( 
		 	'js/jquery.js'
		),
	),
	 
);
