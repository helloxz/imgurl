<div class="layui-container site">
	<div class="layui-row">
		<div class="layui-col-lg12">
			<div id="site">
			<form class="layui-form" action = "/set/site" method = "post">
				<div class="layui-form-item">
					<label class="layui-form-label">Logo地址</label>
					<div class="layui-input-block">
					<input type="text" name="logo" required  lay-verify="required" placeholder="可输入绝对路径或URL地址" autocomplete="off" class="layui-input" value = "<?php echo $logo; ?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">网站标题</label>
					<div class="layui-input-block">
					<input type="text" name="title" required  lay-verify="required" placeholder="请输入网站标题标题" autocomplete="off" class="layui-input" value = "<?php echo $title; ?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">网站关键词</label>
					<div class="layui-input-block">
					<input type="text" name="keywords"  placeholder="多个关键词用英文状态下的逗号(,)分隔" autocomplete="off" class="layui-input" value = "<?php echo $keywords; ?>">
					</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">站点描述</label>
					<div class="layui-input-block">
<textarea name="description" placeholder="请输入网站描述" class="layui-textarea">
<?php echo $description; ?>
</textarea>
					</div>
				</div>
				
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">统计代码</label>
					<div class="layui-input-block">
						<textarea name="analytics" placeholder="请输入统计代码，目前仅测试过百度统计，其它统计代码可能会出错。" class="layui-textarea"><?php echo $analytics; ?></textarea>
					</div>
				</div>
				<!-- <div class="layui-form-item layui-form-text">
					<label class="layui-form-label">Disqus</label>
					<div class="layui-input-block">
						<textarea name="comments" placeholder="请输入统Disqus评论代码" class="layui-textarea"></textarea>
					</div>
				</div> -->
				<div class="layui-form-item">
					<div class="layui-input-block">
					<button class="layui-btn" lay-submit lay-filter="formsite">保存</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
