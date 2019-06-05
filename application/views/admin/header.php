<?php
    //获取版本号
    $ver_file = FCPATH.'data/version.txt';
    if(is_file($ver_file)){
        @$version = file_get_contents($ver_file);
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php echo $admin_title; ?> - ImgURL后台管理</title>
  	<link rel="stylesheet" href="/static/layui/css/layui.css">
  	<link rel="stylesheet" href="/static/font-awesome/css/font-awesome.min.css">
	  <link rel="stylesheet" href="/static/css/admin.css?v=<?php echo $version; ?>">
	<script src = "/static/js/jquery.min.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo"><a href="/admin/index">ImgURL后台管理</a></div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="/"><i class="layui-icon layui-icon-home"></i> 前台首页</a></li>
      <li class="layui-nav-item"><a href="/home/multiple"><i class="layui-icon layui-icon-upload"></i> 多图上传</a></li>
      <li class="layui-nav-item"><a href="/admin/urlup"><i class="layui-icon layui-icon-link"></i> URL上传</a></li>
      <!-- <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li> -->
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="/static/images/touxiang_100.jpg" class="layui-nav-img">
          <?php echo $_COOKIE['user']; ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="/user/resetpass">修改密码</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="/user/logout">退出</a></li>
    </ul>
  </div>