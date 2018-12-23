<div class="layui-container site">
	<div class="layui-row">
		<div class="layui-col-lg8">
			<div class="setting-msg">
				ImgURL需要使用TinyPNG提供的API来压缩图片，可同时设置2个API KEY，详细说明请查看帮助文档。
			</div>
		</div>
		<div class="layui-col-lg6">
			<div id="site">
			<form class="layui-form" action="/set/tinypng" method = "post">
				<div class="layui-form-item">
					<label class="layui-form-label">API key 1</label>
					<div class="layui-input-block">
					<input type="text" name="api1" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value = "<?php echo @$values->api1; ?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">API key 2</label>
					<div class="layui-input-block">
					<input type="text" name="api2" lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input" value = "<?php echo @$values->api2; ?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">启用压缩</label>
					<div class="layui-input-block">
					<input type="checkbox" name="switch" lay-skin="switch" lay-text="ON|OFF" <?php echo $switch; ?>>
					</div>
				</div>
				
				<div class="layui-form-item">
					<div class="layui-input-block">
					<button class="layui-btn" lay-submit lay-filter="formtiny">保存</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>