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

    //图片存储路径
    $picpath = $updir.'/'.date('ym',time()).'/'.'dsdds.png';

    //接受base64图片
    $picfile = $_POST['content'];
    $picfile = base64_decode($picfile);
    //echo $picfile;
    //存储图片
    var_dump(file_put_contents("D:/wwwroot/imgurl/upload/1809/dsd.png", $picfile));
    

	//echo $picpath;
	//var_dump($picfile);
    
?>
<?php
	function base64_image_content($base64_image_content,$path){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path."/".date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $new_file = $new_file.time().".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return '/'.$new_file;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
?>