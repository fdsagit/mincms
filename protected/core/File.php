<?php namespace app\core;  
use app\core\DB;
/**
*  
* 
* @author Sun < mincms@outlook.com >
*/
class File extends \yii\helpers\Html
{ 
	public $admin = 1;
	public $uid = 1;
	public $name; 
	function upload($http_url=null){
		$url = "upload/".date('Y').'/'.date('m').'/'.date('d');
		$dir = root_path().$url; 
		$temp_dir = root_path().'upload/temp';
		if(!is_dir($dir)) mkdir($dir,0775,true);
		if(!is_dir($temp_dir)) mkdir($temp_dir,0775,true);
		if($http_url) {
			return $this->_upload($http_url,array(
				'url'=>$url,
				'dir'=>$dir,
				'temp_dir'=>$temp_dir,
			));
		}
		if(!$_FILES)return; 
		foreach($_FILES as $k=>$f){
			$tmp_name = $f['tmp_name'];
			$name = $f['name'];
			$key = uniqid('', true).json_encode($f);
			$name = md5($key).".".File::extension($name);
			$to = $dir.'/'.$name;
			$old = $temp_dir.'/'.$name; 
			move_uploaded_file($tmp_name,$old); 
			$this->name = $name;
			$row = $this->_upload_db($old,$to,$url.'/'.$name,$f['size'],$f['type']);
			$ret[] = $row;
		}  
	 	return $row;	
	}
	function _upload($http_url,$ar){
		$name = uniqid('', true).md5($http_url).".".File::extension($http_url);
		$data = @file_get_contents($http_url);
		$old = $ar['temp_dir'].'/'.$name;
		@file_put_contents($old,$data);
	 	$to = $ar['dir'].'/'.$name;  
	 	$size = filesize($old);
	 	if($size<5) {
	 		@unlink($old);
	 		return;
	 	}
	 	$type = filetype($old); 
		$row = $this->_upload_db($old,$to,$ar['url'].'/'.$name,$size,$type);
		return $row;
	}
	function _upload_db($old,$to,$path,$size,$type){
		$data = file_get_contents($old);
		$uniqid =  md5($data); 
		$row = DB::one('file',array(
			'select'=>'id,path',
			'where'=>array('uniqid'=>$uniqid)
		)); 
		if(!$row){ 
			copy($old,$to);   
			$data = array(
					'path'=>$path,
					'uniqid'=>$uniqid,
					'size'=>$size,
					'type'=>$type,   
					'uid' =>$this->uid,
					'created' =>time(),
					'admin'=>$this->admin
				); 
			DB::insert('file', $data); 
		 
		}
		else if(!file_exists(root_path().$row['path'])){  
			copy($old,root_path().$row['path']);  
		} 
		$row = DB::one('file',array(
			'select'=>'id,path,type',
			'where'=>array('uniqid'=>$uniqid)
		));  
		@unlink($old);
		return $row;
	}
	/**
	* full name
	* upload/1.jpg
	*/
	static function name($name){ 
		return substr($name,0,strrpos($name,'.')); 
	}
	/**
	* upload/1.jpg
	* 1
	*/
	static function cute_name($name){ 
		$n = strlen(static::ext($name)); 
		return substr($name,strrpos($name,'/')+1,0-$n); 
	}
	static function ext($name){
		return '.'.static::extension($name);
	}
	static function extension($name){ 
		return substr($name,strrpos($name,'.')+1); 
	}
	static function dir($file_name){ 
		return substr($file_name,0, strrpos($file_name,'/'));
	}
	static function size($filesize) {
		 $filesize =  File::size($filesize);
		 if($filesize >= 1073741824) {
		  	$filesize = round($filesize / 1073741824 * 100) / 100 . ' gb';
		 } elseif($filesize >= 1048576) {
		  	$filesize = round($filesize / 1048576 * 100) / 100 . ' mb';
		 } elseif($filesize >= 1024) {
		 	 $filesize = round($filesize / 1024 * 100) / 100 . ' kb';
		 } else {
		 	 $filesize = $filesize . ' bytes';
		 }
		 return $filesize;
	}
	/**
	* 返回input
	*/
	static function input($files,$field){
	 	 if(!$files)return; 
	 	 foreach($files as $f){ 
		 	$tag .= static::input_one($f,$field);
 		}
 		 
 		return $tag;
	 }
	 static function input_one($f,$field,$is_tag = true){
	 	
	 	$f = (object)$f; 
	 	if(true === $is_tag){
		 	$tag = "<div class='file img-polaroid'><span class='icon-remove hander'></span>
			 	<input type='hidden' name='".$field."[]' value='".$f->id."' >";
		}
			$flag = false;
			if(strpos($f->type,'image')!==false){
				$flag = true;  
				$tag .= "<a href=".base_url().$f->path."  '>"
				.image($f->path,array(
					'resize'=>array(160,120)
				))."</a>";
			} 
			else if(in_array(File::extension($f->path),array('flv','mp4','avi','rmvb','webm'))){
				$flag = true;
				$tag .= "<img src='".image_url('img/video.png',array('resize'=>array(160,120,true)))."' />";
			}
			
			switch (File::extension($f->path)) {
				case 'zip': 
					$tag .= "<img src='".image_url('img/zip.png',array('resize'=>array(160,120,true)))."' />";
					break;
				case 'txt': 
					$tag .= "<img src='".image_url('img/txt.png',array('resize'=>array(160,120,true)))."' />";
					break;
				case 'pdf': 
					$tag .= "<img src='".image_url('img/pdf.png',array('resize'=>array(160,120,true)))."' />";
					break;
				case 'doc': 
					$tag .= "<img src='".image_url('img/word.png',array('resize'=>array(160,120,true)))."' />";
					break;
				default:
					if(false === $flag)
						$tag .= "<img src='".image_url('img/none.png',array('resize'=>array(160,120,true)))."' />";
					break;

			} 
			if(true === $is_tag){
				$tag .="</div>"; 
			}
			return $tag;
	 }
}