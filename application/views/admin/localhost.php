<div class="layui-container site">
	<div class="layui-row">
        <div class="layui-col-lg12">
            <div class="setting-msg">
				请在下方填写localhost绑定域名（默认为站点域名），需要带有http(s)，注意末尾没有/
			</div>
        </div>
		<div class="layui-col-lg6">
			<div id="site">
			<form class="layui-form" action="/set/storage/localhost" method = "post">
				<div class="layui-form-item">
					<label class="layui-form-label">绑定域名</label>
					<div class="layui-input-block">
					<input type="text" name="domain" value = "<?php echo $domains; ?>" required  lay-verify="required|url" placeholder="请输入绑定域名" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
					<button class="layui-btn" lay-submit lay-filter="formlocalhost">保存</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>