<?php
/*
	name:导入1.x数据
*/
	//载入数据库类
	include_once( './application/libraries/Medoo.php' );
	use Medoo\Medoo;
	$db1 = new Medoo([
        'database_type' => 'sqlite',
        'database_file' => './data/temp/imgurl.db3'
    ]);

	@$id = (int)$_GET['id'];
	$nextid = $id + 1;
	
    $query1 = $db1->get("imginfo","*",[
		"id"	=>	$id
    ]);

	$endid = $db1->get("imginfo","id",[
		'LIMIT' => 1,
		"ORDER" => [
			"id" => "DESC"
		]
    ]);
    if($id > $endid){
	    echo '全部导入完毕，请关闭此页面！';
	    exit;
    }
    if(!$query1){
	    echo '【请不要关闭此页面】没有查询成功，执行下一个！';
	    header("Refresh:0.1;url=import.php?id=$nextid");
	    exit;
    }
    //var_dump($query1);
	//对imgurl 1.x数据进行处理
	//文件路径
	$data['path']	=	'/'.$query1['path'];
	//文件上传日期
	$data['date']	=	$query1['date'].' 00:00';
	//文件所有者
	if($query1['dir'] == 'temp'){
		$data['user'] = 'visitor';
	}
	else{
		$data['user'] = 'admin';
	}
	//图片是否压缩
	$data['compression'] = $query1['compress'];
	$query1['level'] = (int)$query1['level'];
	//图片等级
	if($query1['level'] === 3){
		$data['level'] = 'adult';
	}
	else{
		$data['level'] = 'everyone';
	}
	//获取imgid
	$file_name = basename($query1['path']);
	//分割为数组
	$file_arr = explode('.',$file_name);
	//获取imgid
	$data['imgid']	=	$file_arr[0];
	@$data['ext']	=	'.'.$file_arr[1];

	//设置存储引擎
	$data['storage']	=	'localhost';
	//图片水印
	$data['watermark']	=	0;

	//获取图片MIME类型
	switch ( @$file_arr[1] )
	{
		case 'jpg':
			$data['mime']	=	'image/jpeg';
			break;	
		case 'png':
			$data['mime']	=	'image/png';
			break;
		case 'gif':
			$data['mime']	=	'image/gif';
			break;
		case 'bmp':
			$data['mime']	=	'image/bmp';
			break;
		default:
			$data['mime']	=	'image/jpeg';
			break;
	}

	//获取图片尺寸
	@$sizeinfo = getimagesize($query1['path']);
	$data['width']	=	$sizeinfo[0];
	$data['height']	=	$sizeinfo[1];

	//将数据写入到IimgURL 2.x
	$db2 = new Medoo([
        'database_type' => 'sqlite',
        'database_file' => './data/imgurl.db3'
    ]);

	if($id <= $endid){
		//数据插入到img_images
	    $db2->insert("img_images", [
			"imgid"		=>	$data['imgid'],
			"path"		=>	$data['path'],
			"storage"	=>	$data['storage'],
			"ip"		=>	$query1['ip'],
			"ua"		=>	$query1['ua'],
			"date"		=>	$data['date'],
			"user"		=>	$data['user'],
			"compression"	=>	$data['compression'],
			"watermark"	=>	0,
			"level"		=>	$data['level']
		]);
		//数据插入到imginfo
		$db2->insert("img_imginfo", [
			"imgid"		=>	$data['imgid'],
			"mime"		=>	$data['mime'],
			"width"		=>	$data['width'],
			"height"	=>	$data['height'],
			"views"		=>	0,
			"ext"		=>	$data['ext'],
			"client_name"	=>	$file_name
		]);
		echo '【请不要关闭此页面】导入成功，执行下一个！';
		header("Refresh:0.1;url=import.php?id=$nextid");
	}
	else{
		echo '全部导入完成！';
		exit;
	}
	
?>