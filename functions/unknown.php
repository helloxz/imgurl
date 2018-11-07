<?php
	//此页面需要配置定时任务（crontab）完成
	include_once("./class/class.user.php");

	//获取密码
	@$pass = $_GET['pass'];
	if($pass != $config['password']){
		echo '密码错误！';
		exit;
	}

	$datas = $basis->unknown();
	
	//遍历数据
	foreach( $datas as $key => $value )
	{
		$url = $config['domain'].'dispose.php?id='.$value['id'];

		//echo $url;

		//请求鉴黄接口
		$curl = curl_init($url);

	    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36");
	    curl_setopt($curl, CURLOPT_FAILONERROR, true);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    #设置超时时间，最小为1s（可选）
	    curl_setopt($curl , CURLOPT_TIMEOUT, 3);

	    $html = curl_exec($curl);
	    curl_close($curl);
	}
	echo '处理完成！';
?>