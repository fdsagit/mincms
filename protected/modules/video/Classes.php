<?php 
namespace app\modules\video; 
use app\core\DB;  
use app\core\Arr;
use app\core\Str;
 
/**
* video comm class
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Classes
{
	static $youku_byme = "https://openapi.youku.com/v2/videos/by_me.json";
 	/**
	* get youku video from me
	* 
	* Example
	*
	* <code>
	*	use app\modules\video\Classes;
	*	use yii\helpers\Html;
	*	$videos = Classes::youku();
    *
	*	<?php 
	*	if($videos){
	*		foreach($videos as $v){
	*		 
	*	?>
	*		<a href="<?php echo url('site/video',array('id'=>$v->id));?>"> 
	*			<div class="image-container  ">
	*		        <?php echo Html::img($v->thumbnail);?>
	*		        <div class="overlay"> <?php echo $v->title;?> </div>
	*		    </div>
	*	    </a>
	*	    	
	*	<?php }}?>
    *
	*	echo Classes::youku_player($id);
    * </code>
	* @param  int $page   pagenum
	*/
 	static function youku($page=1){
 		$setting = cache('oauth_setting');
 		$u = static::build(static::$youku_byme, array(
 			'client_id'=>$setting['youku']['key1'],
 			'access_token'=>cache('oauth_youku'.cookie('guest_unique')),
 			'page'=>$page
 		));
 		$d = json_decode(@file_get_contents($u));
 		if($d){
 			return $d->videos;
 		}
 		return false;
 	}
 	/**
	* youku play video
	* 
	* @param  string $vid   vid from youku
	* @param  int $width   width default 400 
	* @param  int $height  height default 300 
	*/
 	static function youku_player($vid , $width = 400, $height = 300){
 		$setting = cache('oauth_setting');
 		$client_id = $setting['youku']['key1'];
echo <<<EOF
<div id="youkuplayer" style="width:{$width}px;height:{$height}px;"></div>
<script type="text/javascript" src="http://player.youku.com/jsapi">
player = new YKU.Player('youkuplayer',{
	client_id: '$client_id',
	vid: '$vid'
});
</script>
EOF;
 	}
 	/**
 	* http_build_query
 	*/
 	static function build($url,$params){
 		return $url.'?'.http_build_query($params);
 	}
 	/**
	* sohu play video
	* 
	* @param  string $id   vid from sohu
	* @param  int $width   width default 400 
	* @param  int $height  height default 300 
	*/
	static function sohu($id = 57769914 , $width=400,$height=300){
		$setting = cache('oauth_setting');
		$client_id = $setting['sohu']['key1'];
		//$fbarad = "&fbarad="; 广告
		
	return	'<object width='.$width.' height='.$height.'>
<param name="movie"
value="http://share.vrs.sohu.com/my/v.swf&id='.$id.'&skinNum=1&topBar=0&showRecommend=0&autoplay=true&api_key='.$client_id.'">
		</param>
<param name="allowFullScreen" value="true"></param>
<param name="allowscriptaccess" value="always"></param>
<param name="wmode" value="Transparent"></param>
<embed  width='.$width.' height='.$height.' wmode="Transparent"
allowfullscreen="true" allowscriptaccess="always" quality="high"
src="http://share.vrs.sohu.com/my/v.swf&id='.$id.'&skinNum=1&topBar=0&showRecommend=0&autoplay=true&api_key='.$client_id.$fbarad.'"
type="application/x-shockwave-flash" />
</embed>
</object>';
	}
	
 
 	 
	 

 	 
 
}