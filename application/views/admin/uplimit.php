<div class="layui-container setting">
	<div class="layui-row">
		<div class="layui-col-lg4">
			<div id="site">
			<form class="layui-form" action = "/set/uplimit" method = "post">
				<div class="layui-form-item">
					<label class="layui-form-label">游客上传</label>
					<div class="layui-input-block">
						<input type="checkbox" lay-filter="upswitch" name="switch" lay-skin="switch" <?php echo $switch;?>>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">上传数量</label>
					<div class="layui-input-block">
					<input type="text" id = "limit" name="limit" required  lay-verify="required" placeholder="指的是游客每日上传数量" autocomplete="off" class="layui-input" value = "<?php echo $limit; ?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">上传大小</label>
					<div class="layui-input-block">
					<input type="text" name="max_size" required  lay-verify="required" placeholder="后端上传大小，单位为Mb" autocomplete="off" class="layui-input" value = "<?php echo $max_size; ?>">
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
					<button class="layui-btn" lay-submit lay-filter="formuplimit">保存</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>