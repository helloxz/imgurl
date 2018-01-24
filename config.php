<?php
	require_once( 'sdk/Medoo.php' );
	use Medoo\Medoo;
	$database = new medoo([
	    'database_type' => 'sqlite',
	    'database_file' => 'data/imgurl.db3'
	]);
	
	$config = array(
		'domain' 	=> 'http://localhost/imgurl/',			//网站域名
		'watermark' => 'false',		//文字水印
		'userdir'	=>	'temp',		//访客上传目录，一般保持默认
		'admindir'	=>	'upload',	//管理员上传目录，一般保持默认
		'username'	=>	'xiaoz',	//管理员账号
		'password'	=>	'xiaoz.me',	//管理员密码
		'tinypng'	=>	''			//使用TinyPNG压缩图片，填写TinyPNG KEY，为空则不启用压缩
	);
	//是否启用腾讯万象优图鉴黄识别
	$identify = array(
		'eroticism'		=>		false,		//如果此项为true则下面必须填写，请参考帮助文档。
		'APP_ID'		=>		'',
		'SECRET_ID'		=>		'',
		'SECRET_KEY'	=>		'',
		'BUCKET'		=>		''
	)
?>