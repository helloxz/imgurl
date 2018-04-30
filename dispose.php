<?php
    //载入配置文件
    include_once("./config.php");
    //载入TinyPNG
    require_once("functions/tinypng/Tinify/Exception.php");
    require_once("functions/tinypng/Tinify/ResultMeta.php");
    require_once("functions/tinypng/Tinify/Result.php");
    require_once("functions/tinypng/Tinify/Source.php");
    require_once("functions/tinypng/Tinify/Client.php");
    require_once("functions/tinypng/Tinify.php");

    //初始化值
    $dispose['compress'] = 0;
    $dispose['level']   = 0;

    //获取ID
    $id = $_GET['id'];
    $id = (int)$id;
    //获取tinypng key
    $tinykey = array_rand($tinypng['key']);     //取出数组键值
    $tinykey = $tinypng['key'][$tinykey];
    //获取ModerateContent key
    $mckey = $ModerateContent['key'];

    //如果ID不存在或为空
    if((!isset($id)) || ($id == '')) {
        echo 'ID错误！';
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
    if(($suffix == 'png') || ($suffix == 'jpg')) {
        $iscompress = 1;
    }
    
    //对图片进行压缩
    if(($tinypng['option'] == true) && ($iscompress == 1) && ($compress == 0)) {
        //初始化
        \Tinify\setKey($tinykey);
        $source = \Tinify\fromUrl($imgurl);
        //覆盖原有图片
        $source->toFile($info['path']);
        //更新数据库
        $database->update("imginfo",[
            "compress"  =>  1
        ],[
            "id"    => $id
        ]);
        $dispose['compress'] = 1;
    }
    //对图片进行鉴黄
    if(($ModerateContent['option'] == true) && ($level == 0)) {
        $apiurl = "https://www.moderatecontent.com/api/v2?key=".$mckey."&url=".$imgurl;
        $curl = curl_init($apiurl);

        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $html = curl_exec($curl);
        curl_close($curl);

        //更新数据库
        $html = json_decode($html);
        $level = $html->rating_index;
        $database->update("imginfo",["level" =>  $level],["id"   => $id]);
        $dispose['level'] = $level;
    }

    //返回json数据
    $dispose['code'] = 1;
    $dispose = json_encode($dispose);
    echo $dispose;
?>