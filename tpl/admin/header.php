<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	include_once('../config.php');
	$uid = $_COOKIE['uid'];
	$loginid = md5($config['username'].$config['password']);
	if($uid != $loginid) {
		echo '权限不足';
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>ImgURL后台管理</title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="../static/layui/css/layui.css">
		<link rel="stylesheet" href="../static/admin.css">
	<script src = "../static/layui/layui.js"></script>
	<script src = "../static/admin.js"></script>
	<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
	<!--导航栏-->
	<div id="menu">
		<div class="layui-container">
			<div class="layui-row">
				<div class="layui-col-lg10 layui-col-md-offset1">
					<div style = "float: left;">
						<ul class="layui-nav" lay-filter="">
						  <li class="layui-nav-item"><a href="../index.php">首页</a></li>
						  <li class="layui-nav-item"><a href="../found.php">探索发现</a></li>
						  <li class="layui-nav-item"><a href="../pro.php">捐赠版</a></li>
						  <li class="layui-nav-item"><a href="https://wiki.xiaoz.me/docs/imgurl/">帮助文档</a></li>
						  <li class="layui-nav-item"><a href="../about.php">关于</a></li>
						</ul>
					</div>
					<div style = "float: right;">
						<ul class="layui-nav">
						  <li class="layui-nav-item">
						    <a href="../recycle.php">回收站<span class="layui-badge">9</span></a>
						  </li>
						  <li class="layui-nav-item">
						    <a href="">后台管理</a>
						    <dl class="layui-nav-child">
						      <dd><a href="../functions.php?type=logout">退出</a></dd>
						    </dl>
						  </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style = "clear:both;"></div>
	<!--导航栏END-->
	
	<!--侧边栏-->
	<div id = "sidebar">
		<div class="layui-container">
			<div class="layui-row">
				<div class="layui-col-lg10 layui-col-md-offset1">
					<div class="layui-col-lg3">
						<div class = "left-menu">
							<ul>
								<li><h2>后台管理</h2></li>
								<li><a href="./pics.php?type=user">游客上传</a></li>
								<li><a href="./pics.php?type=admin">管理员上传</a></li>
								<li><a href="">API上传</a></li>
								<li><a href="">API管理</a></li>
							</ul>
						</div>
					</div>