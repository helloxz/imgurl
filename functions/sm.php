<?php
	//载入类
	include_once("./class/class.user.php");
	//获取sm.ms API返回数据
	$data = $_POST['data'];
	//获取访客IP
	$sm['ip'] = $basis->getip();
	//获取访客UA
	$sm['ua'] = $_SERVER['HTTP_USER_AGENT'];
	//获取当前时间
	$sm['date'] = date('Y-m-d',time());
	//获取图片URL
	$sm['url'] = $data['url'];
	//获取删除链接
	$sm['delete'] = $data['delete'];

	//进行基本的判断
	if((!isset($data)) || ($data == '') || (!is_array($data))) {
		echo '获取数据失败！';
		exit;
	}
	//再次判断地址是否合法
	if(!filter_var($sm['url'], FILTER_VALIDATE_URL)) {
		echo '不是合法的地址！';
		exit;
	}
	if(!filter_var($sm['delete'], FILTER_VALIDATE_URL)) {
		echo '不是合法的地址！';
		exit;
	}

	//写入数据库
	$last_user_id = $database->insert("sm", [
		"ip" 	=> $sm['ip'],
		"ua" 	=> $sm['ua'],
		"date"	=> $sm['date'],
		"url"	=> $sm['url'],
		"delete"=> $sm['delete']
	]);
	//返回ID
	$smid = $database->id();
	if($last_user_id) {
		$redata = array(
			"code"	=>	1,
			"id"	=>	$smid,
			"msg"	=>	"写入成功！"	
		);
		echo json_encode($redata);
		exit;
	}
	else{
		$redata = array(
			"code"	=>	0,
			"id"	=>	$smid,
			"msg"	=>	"该图片可能已经上传过！"	
		);
		echo json_encode($redata);
	}
?>