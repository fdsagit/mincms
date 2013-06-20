<?php namespace app\widget\gallery;  
use yii\helpers\Json;
/**
* 
 
<?php widget('gallery',array(
	'tag'=>'#galleria',
	'theme'=>'classic',// classic , azur ,dots,fullscreen,twelve
));
?>

<div id="galleria" style="width:800px;height:600px;">
    <a href="#"><img src="#"    data-big="/img/big1.jpg" data-title="My title" data-description="My description"></a>
</div>
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; 
 	// classic , azur ,dots,fullscreen,twelve
 	public $theme = 'classic';
	function run(){  
		 if($this->options)
			$opts = Json::encode($this->options);
		$base = publish(__DIR__.'/assets');  
 		if(!$this->tag) return; 
 		js(" 
 			Galleria.loadTheme('".$base."/themes/".$this->theme."/galleria.".$this->theme.".js');
			Galleria.configure(".$opts.");
			Galleria.run('".$this->tag."');
 		");  
 		js_file($base."/galleria-1.2.8.min.js");
 		css_file($base."/themes/".$this->theme."/galleria.".$this->theme.".css");
	}
}