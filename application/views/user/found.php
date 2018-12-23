<?php
    // 很无奈的将逻辑写到这里
    // 写一个获取缩略图的函数
    $this->load->helper('basic');
?>
<div class="layui-container" style = "margin-top:2em;margin-bottom:6em;">
    <div class="layui-row layui-col-space5" id = "found">
        <?php 
                foreach ($imgs as $img)
                {
                    //一些简单的逻辑处理 
                    //获取缩略图地址
                    $thumbpath = thumbnail($img);
                    $thumburl = $domain.$thumbpath;
                    //源图像地址
                    $img_url = $domain.$img['path'];
            ?>
            <div class="layui-col-lg3" id = "img<?php echo $img['id']; ?>">
                <div class = "img_thumb" onmouseover = "show_imgcon(<?php echo $img['id']; ?>)" onmouseout = "hide_imgcon(<?php echo $img['id']; ?>)">
                    <img src="<?php echo $thumburl; ?>" alt="<?php echo $img['client_name']; ?>" layer-src= "<?php echo $img_url; ?>" lay-src = "<?php echo $thumburl; ?>">
                    <div class="imgcon" id="imgcon<?php echo $img['id']; ?>">
                        <!-- 图片链接 -->
                        <a href="javascript:;" title="图片链接" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "showlink('<?php echo $img_url; ?>','<?php echo $thumburl; ?>')"><i class="fa fa-link"></i></a>
                        <a href="/img/<?php echo $img['imgid']; ?>" target = "_blank" class="layui-btn layui-btn-xs layui-btn-normal"><i class="fa fa-globe"></i></a>
                    </div>
                </div>
            </div>
            <?php
            } 
        ?>
    </div>
</div>

<div class="layui-row" id = "imglink">
<div class="layui-col-lg10 layui-col-md-offset1">
    <!-- 图片显示区域 -->
    <!-- 显示缩略图 -->
    <div class="layui-col-lg12">
        <div id = "img-thumb"><a href="" target = "_blank"><center><img src="" alt=""></center></a></div>
    </div>
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