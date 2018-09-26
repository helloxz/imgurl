<?php
    //载入配置文件
    include_once("./class/class.user.php");
    //阻止用户直接访问
	if( !strstr($_SERVER['HTTP_REFERER'],$config['domain']) )
	{
		$basis->re_error('非法请求！');
	}
    
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
    //载入上传类
    include('./class/class.upload.php');

    //上传方法
    $handle = new upload($_FILES['file']);
    if ($handle->uploaded) {
        $handle->file_new_name_body   = 'image_resized';
        //允许上传大小2m
        $handle->file_max_size = '2097152';
        //允许的MIME类型，仅运行上传图片
        $handle->allowed = array('image/*');

        // 当前月份
        $current_time = date('ym',time());
        //上传路径：目录 + 时间
        $handle->process('../'.$updir.'/'.$current_time."/");
        if ($handle->processed) {
            //获取站点域名
            $domain = $config['domain'];
            //生成文件hash
            $fhash = hash_file("md5",$handle->file_dst_pathname,FALSE);
            $fhash = substr($fhash,8,16);
            //新的文件名(../temp/1804/\d64c8036c0605175.jpg)
            $new_img = $handle->file_dst_path.$fhash.'.'.$handle->file_dst_name_ext;
            //图片URL地址
            $imgurl = $domain.$updir.'/'.$current_time.'/'.$fhash.'.'.$handle->file_dst_name_ext;
            //图片路径(temp/1804/d64c8036c0605175.jpg)
            $imgdir = $updir.'/'.$current_time.'/'.$fhash.'.'.$handle->file_dst_name_ext;

            //判断文件是否已经存在
            if(!is_file($new_img)) {
                //对文件更名
                rename($handle->file_dst_pathname,$new_img);
            }
            else{
                //删除原始文件
                unlink($handle->file_dst_pathname);
            }

            //检查某张图片是否已经上传过，如果已经上传了，直接返回数据并终止操作
            $basis->isupload($imgdir);

            //没有上传过的图片，继续写入数据库
            $last_user_id = $database->insert("imginfo", [
                "path"      =>  $imgdir,
                "ip"        =>  $ip,
                "ua"        =>  $ua,
                "date"      =>  $date,
                "dir"       =>  $updir,
                "compress"  =>  0,
                "level"     =>  0
            ]);
            //返回最后的ID
            $account_id = $database->id();
            //上传成功，返回json数据
            $redata = array(
                "code"      =>  1,
                "id"        =>  $account_id,
                "url"       =>  $imgurl,
                "width"     =>  $handle->image_dst_x,
                "height"    =>  $handle->image_dst_y
            );
            echo $redata = json_encode($redata);
            $handle->clean();
        } else {
            //上传出现错误，返回报错信息
            $redata = array(
                "code"  =>  0,
                "msg"   =>  $handle->error
            );
            echo json_encode($redata);
        }
    }
?>