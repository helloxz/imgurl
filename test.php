<?php
	require_once 'wxyt/index.php';
	use QcloudImage\CIClient;
	$client = new CIClient('', '', '', '');
	$client->setTimeout(30);
	$imginfo = ($client->pornDetect(array('urls'=>array('https://imgurl.org/upload/1712/caace16a4a5b0646.png'))));

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
	echo $re_data = json_encode($re_data);
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