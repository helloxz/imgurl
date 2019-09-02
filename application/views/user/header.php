<?php
    //获取版本号
    $ver_file = FCPATH.'data/version.txt';
    if(is_file($ver_file)){
        @$version = file_get_contents($ver_file);
    }
?>
<!DOCTYPE html>
<html lang="zh-cn" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo @$title; ?></title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="<?php echo @$keywords; ?>" />
	<meta name="description" content="<?php echo @$description; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico"  type="image/x-icon" />
	<link rel="Bookmark" href="/favicon.ico" />
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/style.css?v=<?php echo $version; ?>">
    <script src="/static/jquery.min.js"></script>
    <!-- 统计代码 -->
    <?php echo @$analytics; ?>
    <!-- 统计代码END -->
</head>
<body>
    <div id="left-gg"></div>
    <div id="right-gg"></div>
	<!-- 顶部导航栏 -->
    <div class = "header">
        <div class = "layui-container">
            <div class = "layui-row">
                <div class = "layui-col-lg12">
                    <div class="left-menu">
                        <a href="/">
                            <div id="logo">
                                <img src="<?php echo @$logo; ?>">
                            </div>
                        </a>
                    </div>
                    <div class = "layui-hide-xs menu">
                        <ul class="layui-nav" lay-filter="">
                            <li class="layui-nav-item"><a href="/home/multiple"><i class="layui-icon layui-icon-upload"></i> 多图上传</a></li>
                            <li class="layui-nav-item"><a href="/found"><i class="layui-icon layui-icon-search"></i> 探索发现</a></li>
                            <li class="layui-nav-item"><a href="https://dwz.ovh/9" target="_blank" rel="nofollow"><i class="layui-icon layui-icon-rmb"></i> 购买专业版</a></li>
                            <li class="layui-nav-item">
                                <a href="javascript:;" target = "_blank" rel = "nofollow"><i class="layui-icon layui-icon-tabs"></i> 其它选项</a>
                                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                                    <dd><a href="https://dwz.ovh/imgurldoc" rel = "nofollow" target = "_blank">帮助文档</a></dd>
                                    <dd><a href="/home/log" rel = "nofollow" target = "_blank">更新日志</a></dd>
                                    <dd><a href="https://github.com/helloxz/imgurl" rel = "nofollow" target = "_blank">源码下载</a></dd>
                                </dl>
                            </li>
                            <!-- 简单判断用户是否登录 -->
                            <?php if((isset($_COOKIE['user'])) && (isset($_COOKIE['token']))){ ?>
                                <li class="layui-nav-item"><a href="/admin/index"><i class="layui-icon layui-icon-console"></i> 后台管理</a></li>
                            <?php }?>
                            <!-- 简单判断用户是否登录END -->
                        </ul>
                    </div>
                    <div class = "menu layui-hide-lg layui-hide-md layui-hide-sm">
                        <ul class="layui-nav" lay-filter="">
                            <li class="layui-nav-item"><a href="/found"><i class="layui-icon layui-icon-search"></i> 发现</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 顶部导航栏END -->