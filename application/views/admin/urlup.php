<div class="layui-container site">
	<div class="layui-row layui-col-space30">
        <div class="layui-col-lg12">
            <div class="setting-msg">
				请输入图片地址，一行一个，一次不超过10个
			</div>
        </div>
		<div class="layui-col-lg6">
			<div class="urltext">
				<label>输入链接</label>
				<textarea rows="10" id="arrurl" name="desc" placeholder="请输入图片地址，一行一个" class="layui-textarea"></textarea>
			</div>
			<div style="margin-top:1em;">
				<a href="javascript:;" class="layui-btn" onclick="urlup()">开始上传</a>
			</div>
		</div>
		<div class="layui-col-lg6">
			<div class="urlupmsg">
				<label>上传结果（返回结果顺序可能有偏差）</label>
				<textarea rows="10" id="urlupmsg" class="layui-textarea" placeholder="这里返回上传结果" readonly="readonly"></textarea>
			</div>
		</div>
	</div>
</div>