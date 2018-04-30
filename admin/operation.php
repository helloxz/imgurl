<?php
    include_once("../functions/class/class.admin.php");
    //获取操作类型
    $type = $_GET['type'];

    //获取图片ID
    $id = $_GET['id'];
    $id = (int) $id;

    if((!isset($id) || ($id == ''))) {
        echo 'ID错误';
        exit;
    }
    
    //判断需要操作的类型
    switch ($type) {
        case 'cdubious': 
            //取消图片可疑状态      
            $pic->cdubious($id);
            break;
        
        default:
            # code...
            break;
    }
?>