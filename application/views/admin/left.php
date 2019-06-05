<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
	  	<li class="layui-nav-item layui-nav-itemed">
			<a href="javascript:;"><i class="layui-icon layui-icon-picture-fine"></i> 图片管理</a>
			<dl class="layui-nav-child">
            <dd><a href="/manage/images/all/0">所有图片</a></dd>
			<dd><a href="/manage/images/admin/0">管理员上传</a></dd>
			<dd><a href="/manage/images/visitor/0">游客上传</a></dd>
			<dd><a href="/manage/images/dubious/0">可疑图片</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;"><i class="layui-icon layui-icon-set"></i> 系统设置</a>
          <dl class="layui-nav-child">
            <dd><a href="/setting/site">站点设置</a></dd>
            <dd><a href="/setting/uplimit">上传限制</a></dd>
            <dd><a href="/setting/compress">图片压缩</a></dd>
            <dd><a href="/setting/identify">图片鉴黄</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;"><i class="layui-icon layui-icon-app"></i> 存储方案</a>
          <dl class="layui-nav-child">
            <dd><a href="/storage/localhost">localhost</a></dd>
            <!-- <dd><a href="javascript:;">FTP</a></dd> -->
            <!-- <dd><a href="">七牛云</a></dd>
            <dd><a href="">又拍云</a></dd>
            <dd><a href="">腾讯COS</a></dd>
            <dd><a href="">阿里OSS</a></dd> -->
          </dl>
		</li>
		<li class="layui-nav-item">
          <a href="javascript:;"><i class="layui-icon layui-icon-app"></i> 管理维护</a>
          <dl class="layui-nav-child">
          <dd><a href="javascript:;" onclick = "version()">当前版本</a></dd>
          <dd><a href="/maintain/upto2">1.x升级2.x</a></dd>
          <dd><a href="/maintain/upgrade">版本升级</a></dd>
			<!-- <dd><a href="/maintain/upto2">检查更新</a></dd> -->
            <!-- <dd><a href="javascript:;">FTP</a></dd> -->
            <!-- <dd><a href="">七牛云</a></dd>
            <dd><a href="">又拍云</a></dd>
            <dd><a href="">腾讯COS</a></dd>
            <dd><a href="">阿里OSS</a></dd> -->
          </dl>
        </li>
      </ul>
    </div>
  </div>
  <div class="layui-body">