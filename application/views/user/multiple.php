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
                    <li>Delete Link</li>
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
                    <!-- 返回删除链接 -->
                    <div class="layui-tab-item" id = "re-dlink">
                        <pre></pre>
                    </div>
                </div>
            </div>
            <!-- 导出txt按钮 -->
            <!-- <a href="" class="layui-btn layui-btn-sm"><i class="layui-icon layui-icon-download-circle"></i> 导出txt</a> -->
            <!-- 导出txt按钮end -->
        </div>
        <!-- 多图上传结果END -->
        <!-- 首页主要区域END -->
    </div>
</div>