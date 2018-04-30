<?php
    // 控制器
    // 载入类
    include_once("class/class.user.php");
    $type = $_GET['type'];
    switch ($type) {
        case 'login':
            // 用户登录时输入的信息
            $user = array(
                "user"      =>  $_POST['user'],
                "password"  =>  $_POST['password']
            );
            // 配置文件里面的用户信息
            $admin = array(
                "user"      =>  $config['user'],
                "password"  =>  $config['password']
            );
            $basis->login($user,$admin);
            break;
        case 'check': 
            $basis->check($config);
            break;
        default:
            # code...
            break;
    }
?>