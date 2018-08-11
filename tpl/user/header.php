<?php error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo $title; ?></title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="xiaoz.me" />
	<meta name="keywords" content="ImgURL,免费图床,图床程序,小z图床,XZ Pic" />
    <meta name="description" content="ImgURL是一个简单、纯粹的图床程序，让个人图床多一个选择。" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico"  type="image/x-icon" />
	<link rel="Bookmark" href="favicon.ico" />
    <link rel="stylesheet" href="./static/layui/css/layui.css">
    <link rel="stylesheet" href="./static/style.css?v=1.2">
    <script src = "https://libs.xiaoz.top/clipBoard.js/clipBoard.min.js"></script>
</head>
<body>
    <!-- 顶部导航栏 -->
    <div class = "header">
        <div class = "layui-container">
            <div class = "layui-row">
                <div class = "layui-col-lg12">
                    <div class="left-menu"><a href="./"><h1>ImgURL</h1></a></div>
                    <div class = "layui-hide-xs">
                        <ul class="layui-nav menu" lay-filter="">
                            <li class="layui-nav-item"><a href="./"><i class="layui-icon">&#xe68e;</i> 首页</a></li>
                            <li class="layui-nav-item"><a href="found.php"><i class="layui-icon">&#xe60d;</i> 探索发现</a></li>
                            <li class="layui-nav-item"><a href="sm.php"><i class="layui-icon">&#xe681;</i> SM.MS</a></li>
                            <li class="layui-nav-item"><a href="https://doc.xiaoz.me/docs/imgurl" target = "_blank" rel = "nofollow"><i class="layui-icon">&#xe705;</i> 帮助文档</a></li>
                            <li class="layui-nav-item"><a href="https://github.com/helloxz/imgurl" target = "_blank" rel = "nofollow"><i class="layui-icon">&#xe857;</i> 源码</a></li>
                            <li class="layui-nav-item"><a href="about.php"><i class="layui-icon">&#xe60b;</i> 关于</a></li>
                        </ul>
                    </div>
                    <div class = "layui-hide-lg layui-hide-xs">
                        <ul class="layui-nav menu" lay-filter="">
                            <li class="layui-nav-item"><a href="found.php">探索发现</a></li>
                        </ul>
                    </div>
                    <div class="right-menu" class = "layui-hide-xs">
                        <ul class="layui-nav menu" lay-filter="" class = "layui-hide-xs">
                        <?php 
                            if(isset($_COOKIE['user'])) {
                        ?>
                        <li class="layui-nav-item">
                            <a href=""><img src="./static/none.jpg" class="layui-nav-img"><?php echo $_COOKIE['user']; ?></a>
                            <dl class="layui-nav-child">
                                <dd><a href="./admin/index.php">后台管理</a></dd>
                                <dd><a href="./admin/logout.php">退出</a></dd>
                            </dl>
                        </li>
                        <?php } else{ ?>
                            <li class="layui-nav-item"><a href="./admin/login.php"><i class="layui-icon">&#xe612;</i> 登录</a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 顶部导航栏END -->