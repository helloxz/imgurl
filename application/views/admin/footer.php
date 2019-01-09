<?php
    //获取版本号
    $ver_file = FCPATH.'data/version.txt';
    if(is_file($ver_file)){
        @$version = file_get_contents($ver_file);
    }
?>
</div>
<div class="layui-footer">
      	<!-- 底部固定区域 -->
      	Copyright © 2017-2019 Powered by <a href="https://imgurl.org/" target = "_blank">ImgURL</a> | Author <a href="https://www.xiaoz.me/" target = "_blank">xiaoz.me</a>
  </div>
</div>
<script src="/static/layui/layui.js"></script>
<script src="/static/js/admin.js?v=<?php echo $version; ?>"></script>
<script src="/static/clipBoard.min.js"></script>
<!-- 获取图片链接 -->
<div class="layui-row" id = "imglink">
<div class="layui-col-lg10 layui-col-md-offset1">
    <!-- 显示地址 -->
    <div class="layui-col-lg12">
        <div id="links">
            <table class="layui-table" lay-skin="nob">
                <colgroup>
                    <col width="80">
                    <col width="320">
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
                </tbody>
            </table>
        </div>
    </div>
    <!-- 图片显示区域END -->
</div>
</div>
<!-- 获取图片链接END -->
</body>
</html>