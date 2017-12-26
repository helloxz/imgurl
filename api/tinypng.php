<?php
	/*
	@name:TinyPNG图片压缩接口
	@author:xiaoz.me
	*/
	
	//载入SDK
	require_once("../sdk/tinypng/Tinify/Exception.php");
	require_once("../sdk/tinypng/Tinify/ResultMeta.php");
	require_once("../sdk/tinypng/Tinify/Result.php");
	require_once("../sdk/tinypng/Tinify/Source.php");
	require_once("../sdk/tinypng/Tinify/Client.php");
	require_once("../sdk/tinypng/Tinify.php");
	//载入配置文件
	require_once("../config.php");

	//获取图片URL地址
	$imgurl = $_GET['url'];
	//获取URI
	$imguri = str_replace($config['domain'],"",$imgurl);
	//echo $imguri;
	//仅获取域名
	$domain = str_replace("http://","",$config['domain']);
	$domain = str_replace("https://","",$domain);
	$domain = explode("/",$domain);		//最终的目的是取出域名
	

	//搜索域名是否匹配
	$sdomain = strpos($imgurl,$domain[0]);

	if($sdomain == false) {
		echo '地址不合法';
		exit;
	}
	//合法的域名，那我们继续咯
	//在判断下目录是否合法
	$imgdir = explode("/",$imguri);
	//如果目录不是访客目录也不是管理员目录，那就不处理咯
	if(($imgdir[0] != $config['userdir']) && ($imgdir[0] != $config['admindir'])) {
		echo '地址不合法';
		exit;
	}
	//ok，上面都过了，判断下图片类型
	//使用exif_imagetype函数来判断文件类型
	$imguri = '../'.$imguri;
	$file_type = exif_imagetype($imguri);
	switch ( $file_type )
	{
		case IMAGETYPE_JPEG:
			tinypng($config['tinypng'],$config['domain'],$imguri,$imgurl);
			$redata = array("code" => 1,"type" => $file_type);
			echo json_encode($redata);
			break;
		case IMAGETYPE_PNG:
			tinypng($config['tinypng'],$config['domain'],$imguri,$imgurl);
			$redata = array("code" => 1,"type" => $file_type);
			echo json_encode($redata);
			break;
		default:
			$redata = array("code" => 0,"type" => $file_type);
			echo json_encode($redata);
			break;
	}
?>

<?php
	//压缩图片
	function tinypng($api,$host,$imgfile,$imgurl){
		if($api == '') {
			echo '未开启TinyPNG';
			exit;
		}
		else{
			Tinify\setKey($api);
			Tinify\fromFile($imgfile)->toFile($imgfile);
			//获取主机名
			$host = $host."/api/";
			//对压缩后的图片鉴黄
	        $ch = curl_init($host."identify.php?url=".$imgurl) ;
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证>证书和hosts
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
	        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
	        $output = curl_exec($ch) ;
	        curl_close($ch);
	        
			return $imgfile;
		}
	}
?>