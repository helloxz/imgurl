<?php
    //载入配置文件
    include_once("./class/class.user.php");
    //检查用户是否登录
    $status = $basis->check($config);

    //检查用户是否登陆来判断上传目录
    if($status == 'islogin') {
        //设置上传路径
        $updir = $config['admindir'];
    }
    else{
        $updir = $config['userdir'];
        //限制用户上传数量
        $basis->limitnum();
    }

    //获取上传者信息
    $ip = $basis->getip();
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $date = date('Y-m-d',time());

    //根据IP、ua、时间生成一个唯一的md5值
    $picname = md5($ip.$ua.date('Y-m-d H:i:s',time()));
    //截取16个字符
    $picname = substr($picname,8,16).'.png';
	$onepath = $updir.'/'.date('ym',time()).'/'.$picname;
    //图片完整存储路径
    $picpath = APP.$onepath;

    //echo $picpath;
    //替换一下，以免windows出现问题
    $picpath = str_replace("\\","/",$picpath);

    //echo $picpath;

    //接接收ase64图片
    $picfile = $_POST['content'];
    $picfile = base64_decode($picfile);
    //echo $picfile;
    //存储图片
    file_put_contents($picpath, $picfile);

    //获取文件mime类型
    //如果不是图片文件，终止执行
    if(!$basis->mime($picpath)){
	    unlink($picpath);
	    $arr = array(
	    	"code"	=>	0,
	    	"msg"	=>	'不允许的文件类型'
	    );
	    $json = json_encode($arr);
	    echo $json;
	    exit;
    }
    
    
    //继续执行并写入数据库
    $last_user_id = $database->insert("imginfo", [
        "path"      =>  $onepath,
        "ip"        =>  $ip,
        "ua"        =>  $ua,
        "date"      =>  $date,
        "dir"       =>  $updir,
        "compress"  =>  0,
        "level"     =>  0
    ]);
    //var_dump($database->log());
    //返回最后的ID
    $account_id = $database->id();
    //写入数据库成功，返回json数据
    if($last_user_id){
	    $url = $config['domain'].$onepath;
	    rejson(1,$url,$account_id);
    }
	//echo $picpath;
	//var_dump($picfile);
    
?>
<?php
	//返回json数据
	function rejson($code,$url,$id = 0){
		$arr = array(
			"code"	=>	$code,
			"url"	=>	$url,
			"id"	=>	$id
		);
		$json = json_encode($arr);
		echo $json;
	}
?>