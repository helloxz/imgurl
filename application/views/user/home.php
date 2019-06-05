<div class="layui-container">
    <div class="layui-row">
        <!-- 首页主要区域 -->
        <div class="layui-col-lg12">
            <div id="main">
                <div class="alert alert-warning" role="alert">
                    <span class="alert-inner--icon"><i class="layui-icon"></i></span>
                    <span class="alert-inner--text"><strong>注意：</strong><?php echo $info; ?></span>
                </div>
                <!-- 选择按钮 -->
                <!-- 上传地址 -->
                <!-- <div id = "storage">
                    <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">存储方式</label>
                        <div class="layui-input-block">
                        <input type="radio" name="storage" value="localhost" title="本地" checked = "checked">
                        <input type="radio" name="storage" value="qiniu" title="七牛云">
                        <input type="radio" name="storage" value="upyun" title="又拍云">
                        <input type="radio" name="storage" value="oss" title="阿里OSS">
                        </div>
                    </div>
                    </form>
                </div> -->
                <!-- 选择按钮END -->
                <!-- 上传区域 -->
                <div class="layui-form-item">
                <div class="layui-upload-drag" id="upimg">
                    <i class="layui-icon"></i>
                    <p>将图片拖拽到此处，支持Ctrl + V粘贴上传</p>
                </div>
                </div>
                <!-- 上传区域END -->
            </div>
        </div>
        <!-- 首页主要区域END -->
    </div>
    <div class="layui-row">
        <div class="layui-col-lg12" id = "imgshow">
            <!-- 图片显示区域 -->
            <!-- 显示缩略图 -->
            <div class="layui-col-lg4">
                <div id = "img-thumb"><a href="" target = "_blank"><img src="" alt="点此可查看详情"></a></div>
            </div>
            <!-- 显示地址 -->
            <div class="layui-col-lg7 layui-col-md-offset1">
                <div id="links">
                    <table class="layui-table" lay-skin="nob" lay-size="sm">
                        <colgroup>
                            <col width="100">
                            <col width="450">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <td>URL</td>
                                <td><input type="text" class="layui-input" id="url" data-cip-id="url"></td>
                                <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('url')">复制</a></td>
                            </tr>
                            <tr>
                                <td>HTML</td>
                                <td><input type="text" class="layui-input" id="html" data-cip-id="html"></td>
                                <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('html')">复制</a></td>
                            </tr>
                            <tr>
                                <td>Markdown</td>
                                <td><input type="text" class="layui-input" id="markdown" data-cip-id="markdown"></td>
                                <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('markdown')">复制</a></td>
                            </tr>
                            <tr>
                                <td>BBCode</td>
                                <td><input type="text" class="layui-input" id="bbcode" data-cip-id="bbcode"></td>
                                <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('bbcode')">复制</a></td>
                            </tr>
                            <tr>
                                <td>Delete Link</td>
                                <td><input type="text" class="layui-input" id="dlink" data-cip-id="dlink"></td>
                                <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('dlink')">复制</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 图片显示区域END -->
        </div>
    </div>
</div>
<!--Ctrl + V粘贴上传-->
<script src = "/static/js/PasteUpload.js"></script>
<script>
	var load1 = document.querySelector("#upimg");

	// 实例化即可
	new ctrlVUtil({
	    uploadUrl: "/upload/parse",
	    targetElement: load1,
		isCompleteImg:false,
	    data:{
	        name:"imgurl",
	    },
	    success:function(data){
	        //转为对象
	        var res = data;
	        //上传成功
	        if(res.code == 200){
		        layer.closeAll('loading'); 
                //layer.closeAll('loading'); 
                $("#img-thumb a").attr('href','/img/' + res.imgid);
                $("#img-thumb img").attr('src',res.thumbnail_url);
                $("#url").val(res.url);
                $("#html").val("<img src = '" + res.url + "' />");
                $("#markdown").val("![](" + res.url + ")");
                $("#bbcode").val("[img]" + res.url + "[/img]");
                $("#imgshow").show();

                //对图片进行鉴黄识别
                $.get("/deal/identify/" + res.id,function(data,status){
                    var re = JSON.parse(data);
                    //状态码为400，说明该图片存在异常
                    if(re.code == 400){
                        layer.open({
                            title: '警告！'
                            ,content: '您的IP已被记录，请不要上传违规图片！'
                        }); 
                    }
                    else{
                        console.log(re.code);
                    }
                });
	        }
	        else{
		        layer.msg(res.msg);
		        layer.closeAll('loading');
	        }
	    },
		error: function(error){
			layer.closeAll('loading'); 
			layer.msg('上传失败！');
			layer.closeAll('loading');
		}
	});
</script>
<!--粘贴上传END-->