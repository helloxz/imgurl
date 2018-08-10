<?php
    $title = "ImgURL - 简单、纯粹的图床程序。";
    include_once("./tpl/user/header.php");
?>

<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-lg12 layui-col-xs12">
        <div class="msg"><i class="layui-icon">&#xe645;</i>  注意：您上传的图片将会公开显示，勿上传隐私图片。游客限制每天5张，最大支持2M</div>
            <!-- 上传图片表单 -->
            <div class="layui-upload-drag" id="upimg">
                <i class="layui-icon">&#xe67c;</i>
                <p>点击上传，或将图片拖拽到此处</p>
            </div>
            <!-- 上传图片表单END -->
        </div>
    </div>
    <div style = "clear:both;"></div>
    <!-- 图片上传成功 -->
    <div class="layui-row" id = "upok"> 
        <div>
            <div id="showpic" class = "layui-col-lg5"><a href="" target = "_blank"><img src=""></a></div>
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

<?php
    include_once("./tpl/user/footer.php");
?>