<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>ImgURL - 简单、纯粹的图床程序。</title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="xiaoz.me" />
	<meta name="keywords" content="ImgURL,免费图床,图床程序,小z图床,XZ Pic" />
	<meta name="description" content="ImgURL是一个简单、纯粹的图床程序，让个人图床多一个选择。" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="./static/uploadfile.css" rel="stylesheet">
	<link href="./static/style.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="./static/jquery.uploadfile.min.js"></script>
	<script src = "https://libs.xiaoz.top/clipBoard.js/clipBoard.min.js"></script>
	<script src = "./static/embed.js"></script>
</head>
<body>
	<div id="msg">
		<div class = "msg">复制成功！</div>
	</div>
	<div id = "loading"><center><img src="./static/ajax-load.gif" alt="" class = "img-responsive center-block"></center></div>
	<!--导航栏-->
	<div id="menu">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-md-offset-1">
					<nav class="navbar navbar-inverse" role="navigation">
						<div class="container-fluid"> 
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse"
									data-target="#example-navbar-collapse">
								<span class="sr-only">切换导航</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="./index.php">ImgURL</a>
						</div>
						<div class="collapse navbar-collapse" id="example-navbar-collapse">
							<ul class="nav navbar-nav">
								<li><a href="./explore.php">探索发现</a></li>
								<li><a href="./pro.php">捐赠版</a></li>
								<li><a href="./about.php">关于</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<?php
									if(isset($_COOKIE['uid'])) {
										include_once('./config.php');
										$mydir = $config['admindir'];
										echo "<li><a href='./explore.php?dir=$mydir'>管理员</a></li>";
										echo " | ";
										echo "<li><a href='./functions.php?type=logout'>退出</a></li>";
									}
									else {
										echo "<li><a href='./login.php'>登录</a></li>";
									}
								?>
								
							</ul>
						</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!--导航栏END-->