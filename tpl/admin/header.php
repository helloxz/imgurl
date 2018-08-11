<!DOCTYPE html>
<html lang="zh-cmn-Hans" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo $title; ?></title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico"  type="image/x-icon" />
	<link rel="Bookmark" href="../favicon.ico" />
    <link rel="stylesheet" href="../static/layui/css/layui.css">
    <link rel="stylesheet" href="../static/style.css?v=1.2">
    <script src = "https://libs.xiaoz.top/clipBoard.js/clipBoard.min.js"></script>
</head>
<body>
    <!-- 顶部导航栏 -->
    <div class = "header">
        <div class = "layui-container">
            <div class = "layui-row">
                <div class = "layui-col-lg12">
                    <div class="left-menu"><a href="../"><h1>ImgURL</h1></a></div>
                        <ul class="layui-nav menu" lay-filter="">
                            <li class="layui-nav-item"><a href="./"><i class="layui-icon">&#xe68e;</i> 后台首页</a></li>
                            <li class="layui-nav-item"><a href="./urlup.php"><i class="layui-icon">&#xe64c;</i> URL上传</a></li>
                        </ul>
                    <div class="right-menu">
                        <ul class="layui-nav menu" lay-filter="">
                        <?php 
                            if(isset($_COOKIE['user'])) {
                        ?>
                        <li class="layui-nav-item">
                            <a href=""><img src="../static/none.jpg" class="layui-nav-img"><?php echo $config['user']; ?></a>
                            <dl class="layui-nav-child">
                            <dd><a href="logout.php">退出</a></dd>
                            </dl>
                        </li>
                        <?php } else{ ?>
                            <li class="layui-nav-item"><a href="login.php"><i class="layui-icon">&#xe612;</i> 登录</a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 顶部导航栏END -->