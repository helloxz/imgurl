<?php
	/*
	@name:万象优图API处理接口
	@author:xiaoz.me
	*/
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	//载入配置
	include_once('../config.php');
	
	//载入万象优图SDK
	require_once '../sdk/wxyt/index.php';
	use QcloudImage\CIClient;
	$client = new CIClient($identify['APP_ID'], $identify['SECRET_ID'], $identify['SECRET_KEY'], $identify['BUCKET']);
	$client->setTimeout(60);

	//获取图片地址
	$url = $_GET['url'];
	//获取上级目录地址
	
	//对URL进行替换
	$url = str_replace($config['domain'],'',$url);
	$imgdir = explode('/',$url);//对目录进行分割

	//如果链接是管理员目录则不鉴黄
	if($imgdir[0] == $config['admindir']) {
		$re_data = array(
		"code" 		=> 0,
		"result"	=> 0,
		"confidence"=> 0
		);

		echo $re_data = json_encode($re_data);
		exit;
	}
	//如果不是游客目录
	if($config['userdir'] != $imgdir[0]) {
		//echo $imgdir[0];
		echo '非法请求';
		exit;
	}
	//重组完整图片
	$imgurl = $config['domain'].$url;
	$imginfo = ($client->pornDetect(array('urls'=>array($imgurl))));

	$imginfo = json_decode($imginfo);

	//获取状态码,0为成功
	//$code = $imginfo->http_code;
	//转换为数组
	$imginfo = object2array($imginfo);
	//状态码，0为成功
	$code = $imginfo['result_list']['0']->code;
	$imginfo = object2array($imginfo['result_list']['0']->data);
	//识别结果,0 正常，1 黄图，2 疑似图片
	$result = $imginfo['result'];
	//识别评分，分数越高，越可能是黄图
	$confidence = $imginfo['confidence'];

	//重新返回json数据
	$re_data = array(
		"code" 		=> $code,
		"result"	=> $result,
		"confidence"=> $confidence
	);
	
	//严格模式，如果是色情图片或疑似色情图片均放到回收站
	if(($re_data['result'] == 1) || ($re_data['result'] == 2)) {
		//获取图片地址
		$url = dirname(dirname(__FILE__)).'/'.$url;
		//回收站地址
		$recycle = dirname(dirname(__FILE__))."/recycle/".end($imgdir);
		//移动到回收站
		if(copy($url,$recycle)){
			unlink($url);		//删除图片
		}
	}
	
	echo $re_data = json_encode($re_data);
	exit;
?>

<?php
	//对象转数组
	function object2array($object) {
	  if (is_object($object)) {
	    foreach ($object as $key => $value) {
	      $array[$key] = $value;
	    }
	  }
	  else {
	    $array = $object;
	  }
	  return $array;
	}
?>