<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	include_once('./config.php');
	require_once( 'sdk/Medoo.php' );
	
	//用户IP
	$ip = $_SERVER["REMOTE_ADDR"]; 
	//获取当前时间
	$thetime = date('Y-m-d',time());
	//获取浏览器信息
	$ua = $_SERVER['HTTP_USER_AGENT'];
	

	//验证用户，并设置上传目录
	$dir = check($_COOKIE['uid'],$config['username'],$config['password'],$config['userdir'],$config['admindir']);
	if($dir == $config['userdir']) {
		$theuser = 'user';
	}
	if($dir == $config['admindir']) {
		$theuser = 'admin';
	}
	
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
			    $img_url = $config['domain'].$dir_name;		//自定义图片路径
			    $img_info = getimagesize($dir_name);
			    $img_width = $img_info['0'];	//图片宽度
			    $img_height = $img_info['1'];	//图片高度
			    $re_data = array("linkurl" => $img_url,width => $img_width,"height" => $img_height,"status" => 'ok');
			    //查询图片是否存在
			    $isdir = $database->count("uploads",["dir" => $dir_name]);
			    //var_dump( $database->log());
			    //如果图片存在
			    if($isdir >= 1) {
				    echo json_encode($re_data);
				    exit;
			    }
			    //图片不存在继续执行
			    $last_id = $database->insert("uploads",["dir" => $dir_name,"date" => $thetime,"ip" => $ip,"method" => $ua,"user" => $theuser]);
			    //写入成功
			    if($last_id) {
				    //返回json格式
				    echo json_encode($re_data);
				    exit;
			    }
			    else{
				    echo "写入数据库失败！";
			    }
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
?>