
<?php
    //获取版本号
    $ver_file = FCPATH.'data/version.txt';
    if(is_file($ver_file)){
        @$version = file_get_contents($ver_file);
    }
?>
	<!-- 底部 -->
	<div class = "footer">
		<div class = "layui-container">
			<div class = "layui-row">
				<div class = "layui-col-lg12">
					Copyright © 2017-2019 Powered by <a href="https://imgurl.org/" target = "_blank">ImgURL</a> | Author <a href="https://www.xiaoz.me/" target = "_blank">xiaoz.me</a> | 
					<!-- 简单判断用户是否登录 -->
					<?php if((isset($_COOKIE['user'])) && (isset($_COOKIE['token']))){ ?>
						<a href="/user/logout">logout</a>
					<?php }else{ ?>
						<a href="/user/login">login</a>
					<?php } ?>
					<!-- 简单判断用户是否登录END -->
				</div>
			</div>
		</div>
	</div>
	<!-- 底部END -->
	<script src="/static/layui/layui.js"></script>
	<script src="/static/embed.js?v=<?php echo $version; ?>"></script>
	<script src="/static/clipBoard.min.js?v=1.40"></script>
</body>
</html>