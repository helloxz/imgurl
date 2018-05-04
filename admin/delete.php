<?php
    error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
    include_once("../functions/class/class.admin.php");
    //获取图片ID
    $id = $_GET['id'];
    $id = (int) $id;
    //获取类型
    $type = $_GET['type'];

    if((!isset($id) || ($id == ''))) {
        echo 'ID错误';
        exit;
    }

    // 判断类型
    switch ($type) {
        case 'sm':
            $pic->deletesm($id);
            break;
        
        default:
            //删除图片
            $pic->delete($id);
            break;
    }
    
?>