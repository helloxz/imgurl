<?php
    $title = "ImgURL - 简单、纯粹的图床程序。";
    include_once("./tpl/user/header.php");
?>

<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-lg12 layui-col-xs12">
        <div class="msg"><i class="layui-icon">&#xe645;</i>  注意：您上传的图片将会公开显示，勿上传隐私图片。游客限制每天10张，最大支持2M</div>
            <!-- 上传图片表单 -->
            <div class="layui-upload-drag" id="upimg">
                <i class="layui-icon">&#xe67c;</i>
                <p>将图片拖拽到此处，支持Ctrl + V粘贴上传</p>
            </div>
            <!-- 上传图片表单END -->
        </div>
    </div>
    <div style = "clear:both;"></div>
    <!-- 图片上传成功 -->
    <div class="layui-row" id = "upok"> 
        <div>
            <div id="showpic" class = "layui-col-lg5"><a href="" target = "_blank"><img src="./static/loading32.gif"></a></div>
            <div id="piclink" class = "layui-col-lg6 layui-col-md-offset1">
            <table class="layui-table" lay-skin="nob">
                <colgroup>
                    <col width="80">
                    <col width="400">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <td>URL</td>
                        <td><input type="text" class="layui-input" id = "url"></td>
                        <td><a href="javascript:;" class = "layui-btn layui-btn-sm" onclick = "copy('url')">复制</a></td>
                    </tr>
                    <tr>
                        <td>HTML</td>
                        <td><input type="text" class="layui-input" id = "html"></td>
                        <td><a href="javascript:;" class = "layui-btn layui-btn-sm" onclick = "copy('html')">复制</a></td>
                    </tr>
                    <tr>
                        <td>MarkDown</td>
                        <td><input type="text" class="layui-input" id = "markdown"></td>
                        <td><a href="javascript:;" class = "layui-btn layui-btn-sm" onclick = "copy('markdown')">复制</a></td>
                    </tr>
                    <tr>
                        <td>BBcode</td>
                        <td><input type="text" class="layui-input" id = "bbcode"></td>
                        <td><a href="javascript:;" class = "layui-btn layui-btn-sm" onclick = "copy('bbcode')">复制</a></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>       
    </div>
    <!-- 图片上传成功END -->
</div>
<!--Ctrl + V粘贴上传-->
<script>
	var load1 = document.querySelector("#upimg");

	// 实例化即可
	new ctrlVUtil({
	    uploadUrl: "functions/cvupload.php",
	    targetElement: load1,
		isCompleteImg:false,
	    data:{
	        name:"alanzhang",
	    },
	    success:function(data){
	        //转为对象
	        var res = data;
	        //上传成功
	        if(res.code == 1){
		        layer.closeAll('loading'); 
                $("#showpic a").attr('href',res.url);
                $("#showpic img").attr('src',res.url);
                $("#url").val(res.url);
                $("#html").val("<img src = '" + res.url + "' />");
                $("#markdown").val("![](" + res.url + ")");
                $("#bbcode").val("[img]" + res.url + "[/img]");
                $("#upok").show();
                //请求接口处理图片
                $.get("./dispose.php?id="+res.id,function(data,status){
                    var obj = eval('(' + data + ')');
                    if(obj.level == 3){
                        layer.open({
                            title: '温馨提示'
                            ,content: '请勿上传违规图片！'
                        }); 
                    }
                    if(obj.level == null){
	                    $.get("./dispose.php?id="+res.id,function(data,status){
		                    var obj = eval('(' + data + ')');
		                    if(obj.level == 3){
		                        layer.open({
		                            title: '温馨提示'
		                            ,content: '请勿上传违规图片！'
		                        }); 
		                    }
	                    });
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
<?php
    include_once("./tpl/user/footer.php");
?>