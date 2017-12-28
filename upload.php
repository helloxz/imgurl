<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	include_once('./config.php');

	//验证用户，并设置上传目录
	$dir = check($_COOKIE['uid'],$config['username'],$config['password'],$config['userdir'],$config['admindir']);
	
	$img_name = $_FILES["file"]["name"];	//文件名称
	$suffix = substr(strrchr($img_name, '.'), 1);//文件后缀
	$suffix = strtolower($suffix);				//文件后缀转换为小写
	$rnum = date('dhis',time()).rand(1000,9999);		//生成一个随机数
	//$new_name = substr(md5($img_name.$rnum), 8, 16).'.'.$suffix;		//新的文件名
	$img_type = $_FILES["file"]["type"];	//文件类型
	$img_size = $_FILES["file"]["size"];	//文件大小
	$img_tmp = $_FILES["file"]["tmp_name"];	//临时文件名称
	//生成文件HASH
	$fhash = hash_file("md5",$img_tmp,FALSE);
	$fhash = substr($fhash,8,16);
	//新的文件名
	$new_name = $fhash.'.'.$suffix;
	$img_error = $_FILES["file"]["error"];	//错误代码
	$max_size = 2097152;		//最大上传大小2M
	$current_time = date('ym',time());	//当前月份
	$dir = $dir.'/'.$current_time;	//图片目录
	$dir_name = $dir.'/'.$new_name;		//完整路径
	
	//使用exif_imagetype函数来判断文件类型
	$file_type = exif_imagetype($img_tmp);
	switch ( $file_type )
	{
		case IMAGETYPE_GIF:
			$status = 1;
			break;
		case IMAGETYPE_JPEG:
			$status = 1;
			break;
		case IMAGETYPE_PNG:
			$status = 1;
			break;
		case IMAGETYPE_BMP:
			$status = 1;
			break;	
		default:
			$status = 0;
			break;
	}
	//判断文件后缀
	switch ( $suffix )
	{
		case jpg:
			$suffix_status = 1;
			break;
		case png:
			$suffix_status = 1;
			break;
		case jpeg:
			$suffix_status = 1;
			break;
		case bmp:
			$suffix_status = 1;
			break;
		case gif:
			$suffix_status = 1;
			break;						
		default:
			$suffix_status = 0;
			break;
	}
	//判断文件夹是否存在，不存在则创建目录
	if(!file_exists($dir)){
		mkdir($dir,0777,true);
	}
	
	//开始上传
	if(($img_size <= $max_size) && ($status == 1) && ($suffix_status == 1)) {
		if ($_FILES["file"]["error"] > 0)
	    {
	    	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    }
	    else {
		    //如果上传成功
		    if(move_uploaded_file($img_tmp,$dir_name)){
			   	//压缩图片
			    //tinypng($config['tinypng'],$dir_name);
			    $img_url = $config['domain'].$dir_name;		//自定义图片路径
			    $img_info = getimagesize($dir_name);
			    $img_width = $img_info['0'];	//图片宽度
			    $img_height = $img_info['1'];	//图片高度
			    $re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'ok');
			    //返回json格式
			    echo json_encode($re_data);
			    recordImageInfo($img_name , $dir_name, $img_url);// 记录文件原始名称，文件路径和文件url
			    exit;
		    }
		    //没有上传成功
		    else{
			    echo "上传失败！";
		    }
	    }
	}
	else{
		$re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'no');
		//返回json格式
		echo json_encode($re_data);
	}

	//判断用户是否登录,5个参数，cookie,用户名、密码、用户上传目录、管理员上传目录
	function check($cookie,$user,$pass,$udir,$adir){
		$loginid = $cookie;
		$userid = md5($user.$pass);
		
		if($loginid == $userid) {
			return $adir;
		}
		else {
			return $udir;
		}
	}

	// 记录图片信息并初始化数据库（如果不存在）
	function recordImageInfo($rawname, $path, $url) {
		global $config;
		include_once("./medoo.php");
		$db = new medoo([
			'database_type' => 'sqlite',
			'database_file' => $config['dbfile']
		]);
		$ret = $db->query("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='pictures'")->fetchAll();
		if ($ret[0][0] == 0) {
			$db->exec("CREATE TABLE [pictures] ([id] INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, [raw] VARCHAR, [path] VARCHAR, [url] TEXT)");
			$db->exec("CREATE INDEX [url] ON [pictures] ([url])");
		}
		$db->exec("insert into pictures (raw, path, url) values (".$db->pdo->quote($rawname).",\"$path\",\"$url\")");
	}
?>