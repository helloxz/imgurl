<?php
    //载入类
    //echo __DIR__."/functions/class/class.install.php";
    include_once(__DIR__."/functions/class/class.install.php");
    @$setup = (int)$_GET['setup'];

    $install = new Install;
    $statusarr = $install->check();

    $info = $install->info();

    switch ($setup) {
        case 1:
            //载入模板
            include_once("./tpl/user/header.php");
            include_once("./tpl/user/install1.php");
            include_once("./tpl/user/footer.php");
            break;
        case 2:
            include_once("./tpl/user/header.php");
            include_once("./tpl/user/install2.php");
            include_once("./tpl/user/footer.php");
            break;
        case 3:
            //获取用户名
            @$data['user'] = $_POST['user'];
            //获取用户密码
            @$data['pass1'] = $_POST['pass1'];
            @$data['pass2'] = $_POST['pass2'];
            @$data['domain'] = $_POST['domain'];
            @$data['homedir'] = $_POST['homedir'];
            $install->setup($data);
            include_once("./tpl/user/header.php");
            include_once("./tpl/user/install3.php");
            include_once("./tpl/user/footer.php");
        break;
        default:
            header("location:./install.php?setup=1");
            break;
    }
?>