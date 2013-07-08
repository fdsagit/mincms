<?php

return array(
	'bootstrap' => array(
		'basePath' => '@wwwroot',
		'baseUrl' => '@www',
		'css' => array(
			'misc/bootstrap/css/bootstrap.min.css',
			'misc/bootstrap/css/bootstrap-responsive.min.css', 
		),
		'js' => array(
			'misc/bootstrap/js/bootstrap.min.js',
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
		 	'js/jquery.js',
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
