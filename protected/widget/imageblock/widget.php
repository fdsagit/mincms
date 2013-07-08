<?php namespace app\widget\imageblock;  
/**
* imageblock widget
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses 
* @link http://mincms.com/demo-imageblock.html   demo
* @version 2.0.1
*/
class Widget extends \yii\base\Widget
{  
 	public $rows; 
 	public $blue = true;
 	public $width = 225;
 	public $height = 170;
 	/**
 	* Example  
 	*
 	* <code>
	* 	$rows[] = array(
	*		'title'=>'test',
	*		'body'=>'test',
	*		'img'=>'http://responsivewebinc.com/premium/metro/purple/img/photos/tn_2.jpg',
	*		'url'=>'test',
	*	);	
	*	echo widget('imageblock',array(
	*		'rows'=>$rows
	*	));
	* </code>
 	*/
	function run(){  
		 $top = $this->height - 28;
		 $posts = $this->rows;
		 js("$('ul.hover-block li').hover(function(){
        $(this).find('.hover-content').animate({top:'-3px'},{queue:false,duration:500});
      }, function(){
        $(this).find('.hover-content').animate({top:'".$top."px'},{queue:false,duration:500});
      });");
      if($this->blue===true){
      	css(".b-lblue:hover {
background: #1789c1;
-webkit-transition: background 1s ease;
-moz-transition: background 1s ease;
-o-transition: background 1s ease;
transition: background 1s ease;
}
.b-lblue {
background: #1ba1e2;
color: #fff;
margin: 3px 0px;
display: inline-block;
-webkit-transition: background 1s ease;
-moz-transition: background 1s ease;
-o-transition: background 1s ease;
transition: background 1s ease;
cursor: default;
}");
      }
css("/* Image blocks */

ul.hover-block li{
	list-style:none;
	float:left;
	width:".$this->width."px; 
	height: ".$this->height."px;
	position: relative;
	margin: 5px 4px;
}

ul.hover-block li a {
	display: block;
	position: relative;
	overflow: hidden;
	width:".$this->width."px; 
	height: ".$this->height."px;
	color: #000;
}

ul.hover-block li a { 
	text-decoration: none; 
}

ul.hover-block li .hover-content{
	width: 100%;
	position: absolute;
	z-index: 1000;
	height: ".$this->height."px;
	top: ".$top."px;
	color: #fff;
	padding: 5px 10px;
	cursor: pointer;
}
ul.hover-block{margin:0;}
ul.hover-block li .hover-content h6{
	color: #fff;
}

ul.hover-block li img {
	position: absolute;
	top: 0;
	left: 0;
	border: 0;
	z-index: 500;
}
");
echo $this->render('@app/widget/imageblock/views/index',array(
	'posts'=>$posts,
	'top'=>$top
));
	}
}