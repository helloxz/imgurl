<?php
	echo "<h1>请将以下信息填写到配置文件config.php</h1>";
	//获取当前端口
	$port = $_SERVER["SERVER_PORT"];
	//对端口进行判断
	switch ( $port )
	{
		case 80:
			$protocol = "http://";
			$port = '';
			break;	
		case 443:
			$protocol = "https://";
			$port = '';
			break;
		default:
			$protocol = "http://";
			$port = ":".$port;
			break;
	}
	//获取项目绝对路径
	$thedir = __DIR__;
	$thedir = str_replace("\\","/",$thedir).'/';
	echo "项目绝对路径：".$thedir."<br />";

	//或如URI
	$uri =  $_SERVER["REQUEST_URI"];
	$uri = str_replace("check.php","",$uri);
	//组合为完整的URL
	$domain = $protocol.$_SERVER['SERVER_NAME'].$port.$uri;
	echo "当前域名为：".$domain;
	
	echo "<h1>配置完成后测试网站功能正常，请删除此文件。</h1>";
?>