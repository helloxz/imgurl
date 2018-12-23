<div class="layui-container" style = "">
    <div class="layui-row">
        <!-- 首页主要区域 -->
        <div class="layui-col-lg12">
            <div id="main">
                <div class="alert alert-warning" role="alert">
                    <span class="alert-inner--icon"><i class="layui-icon"></i></span>
                    <span class="alert-inner--text"><strong>注意：</strong>游客限制每日上传10张，单张图片不能超过5M，上传的图片将公开显示，使用之前请先阅读《<a href="/page/use">使用协议</a>》</span>
                </div>
                <!-- 上传区域 -->
                <div class="layui-form-item">
                <div class="layui-upload-drag" id="multiple">
                    <i class="layui-icon layui-icon-upload"></i>
                    <p>点击这里可选择多张图片，支持拖拽。</p>
                </div>
                </div>
                <!-- 上传区域END -->
            </div>
        </div>
        <!-- 多图上传结果 -->
        <div class="layui-col-lg12" id = "multiple-re">
            <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                <li class="layui-this">URL</li>
                <li>HTML</li>
                <li>Markdown</li>
                <li>BBCode</li>
            </ul>
            <div class="layui-tab-content" style="height: 100px;">
                <!-- 第一个选显卡结果 -->
                <div class="layui-tab-item layui-show" id = "re-url">
                    <pre></pre>
                </div>
                <!-- 返回HTML结果 -->
                <div class="layui-tab-item" id = "re-html">
                    <pre></pre>
                </div>
                <!-- 返回Markdown结果 -->
                <div class="layui-tab-item" id = "re-md">
                    <pre></pre>
                </div>
                <!-- 返回BBCode结果 -->
                <div class="layui-tab-item" id = "re-bbc">
                    <pre></pre>
                </div>
            </div>
            </div>
        </div>
        <!-- 多图上传结果END -->
        <!-- 首页主要区域END -->
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
	        name:"alanzhang",
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
	        }
	    },
		error: function(error){
			layer.closeAll('loading'); 
			layer.msg('上传失败！');
		}
	});
</script>
<!--粘贴上传END-->