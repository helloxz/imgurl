<?php
    include_once("../functions/class/class.admin.php");
    //获取图片ID
    $id = $_GET['id'];
    $id = (int) $id;

    if((!isset($id) || ($id == ''))) {
        echo 'ID错误';
        exit;
    }
    //删除图片
    $pic->delete($id);
?>