<?php
    error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
    /*
    图像处理类
    */
    include_once("../../config.php");
    //载入TinyPNG
    require_once(APP."functions/tinypng/Tinify/Exception.php");
    require_once(APP."functions/tinypng/Tinify/ResultMeta.php");
    require_once(APP."functions/tinypng/Tinify/Result.php");
    require_once(APP."functions/tinypng/Tinify/Source.php");
    require_once(APP."functions/tinypng/Tinify/Client.php");
    require_once(APP."functions/tinypng/Tinify.php");

    //初始化值
    $dispose['compress'] = 0;
    $dispose['level']   = 0;

    //获取ID
    $id = $_GET['id'];
    $id = (int)$id;
    //获取tinypng key
    $tinykey = array_rand($tinypng['key']);     //取出数组键值
    $tinykey = $tinypng['key'][$tinykey];
    $iscompress = 0;

    //如果ID不存在或为空
    if((!isset($id)) || ($id == '')) {
        echo 'ID错误！';
        exit;
    }

    //如果没有启用压缩
    if($tinypng['option'] != true){
        echo '未启用压缩功能！';
        exit;
    }

    //查询对应信息
    $info = $database->get("imginfo",[
        "id",
        "path",
        "compress",
        "level"
    ],[
        "id"    =>  $id
    ]);

    
	
    //组合为完整的URL地址
    $imgurl = $config['domain'].$info['path'];
    //获取压缩状态
    $compress = $info['compress'];
    //获取图片等级
    $level  = $info['level'];
    //获取文件后缀名
    $suffix =  substr(strrchr($info['path'], '.'), 1);
    //后缀改为小写
    $suffix = strtolower($suffix);
    if(($suffix == 'png') || ($suffix == 'jpg') || ($suffix == 'jpeg')) {
        $iscompress = 1;
    }
    if($iscompress == 0){
        echo '该后缀不支持压缩！';
        exit;
    }
    if($compress == 1){
        echo '该图片已经压缩！';
        exit;
    }

    
    //对图片进行压缩
    if(($tinypng['option'] == true) && ($iscompress == 1) && ($compress == 0)) {
        //初始化
        \Tinify\setKey($tinykey);
        $source = \Tinify\fromUrl($imgurl);
        //覆盖原有图片
        $source->toFile(APP.$info['path']);
        //更新数据库
        $database->update("imginfo",[
            "compress"  =>  1
        ],[
            "id"    => $id
        ]);
        $dispose['compress'] = 1;
        echo '压缩成功！';
    }
?>