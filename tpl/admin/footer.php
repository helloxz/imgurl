 <div style = "clear:both;"></div>
 <!-- 底部 -->
 <div class = "footer">
		<div class = "layui-container">
			<div class = "layui-row">
				<div class = "layui-col-lg12">
				Copyright © 2017-2018 Powered by <a href="https://imgurl.org/" target = "_blank">ImgURL</a>. | Author <a href="https://www.xiaoz.me/" target = "_blank">xiaoz.me</a>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部END -->

    <script src="../static/jquery.min.js"></script>
	<script src="../static/layui/layui.js"></script>
	<script src="../static/embed.js?v=1.31"></script>
	<script>
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
	  
	  //执行一个laydate实例
	  laydate.render({
	    elem: '#starttime' //指定元素
	  });
	  laydate.render({
	    elem: '#endtime' //指定元素
	  });
	});
	</script>
</body>
</html>