<div class="layui-container site">
	<div class="layui-row">
		<div class="layui-col-lg8">
			<div class="setting-msg">
				ImgURL需要使用Moderate Content提供的API来进行鉴黄识别，详细说明请参考帮助文档。
			</div>
			<div class = "identify-msg">
				<ol>
					<li>由于某些原因可能接口会超时或者识别错误，建议配合 crontab 来定时识别图片。</li>
					<li>鉴黄接口地址为：/deal/identify_more</li>
					<li>Moderate Content无法做到100%精准，可能存在误判,识别后的图片会标记为可疑图片。</li>
				</ol>
			</div>
		</div>
		<div class="layui-col-lg6">
			<div id="site">
			<form class="layui-form" action="/set/moderate" method = "post">
				<div class="layui-form-item">
					<label class="layui-form-label">API key</label>
					<div class="layui-input-block">
					<input type="text" name="api" value = "<?php echo $values; ?>" required  lay-verify="required" placeholder="请输入Moderate Content API KEY" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">启用鉴黄</label>
					<div class="layui-input-block">
					<input type="checkbox" name="switch" lay-filter="jhswitch" lay-skin="switch" lay-text="ON|OFF" <?php echo $switch; ?>>
					</div>
				</div>
				
				<div class="layui-form-item">
					<div class="layui-input-block">
					<button class="layui-btn" lay-submit lay-filter="formModerate">保存</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>