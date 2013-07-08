<?php 
namespace app\modules\oauth;  
use app\core\DB;
use app\core\Str;
class Hook
{
	static function action_init(){
		$d = cache('oauth_setting');
		if(!$d){
			$d = DB::all('oauth_config');
			if($d){
				foreach($d as $v){
					$out[$v['slug']] = array('key1'=>$v['key1'],'key2'=>$v['key2']);
				}
				cache('oauth_setting' , $out);
			}
		}
	}
	 
}