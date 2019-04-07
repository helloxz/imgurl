<div class="layui-container" style = "margin-top:1em;margin-bottom:4em;">
    <div class="layui-row layui-col-space20 img-main">
        <!-- 图片主要区域 -->
        <div class="layui-col-lg8">
            <div id = "onepic">
                <div class="onepic">
                    <div class="title"><h2><?php echo $title; ?></h2></div>
                    <div id = "lightgallery">
                        <img layer-src="<?php echo $url; ?>" src="<?php echo $url; ?>" alt="<?php echo $title; ?>">
                    </div>
                </div>
                <!-- 图片底部信息 -->
                <div class="picinfo">
                    <p>
                        <span><a href="javascript:;" title = "上传时间"><i class="fa fa-calendar-check-o"></i> <?php echo $date; ?></a></span>
                        <span><a href="javascript:;" title = "浏览次数"><i class="fa fa-eye"></i> <?php echo $views; ?>次</a></span>
                        <span><a href="<?php echo $url; ?>" download = ""><i class="fa fa-cloud-download"></i> 下载</a></span>
                    </p>
                    <div class = "statement">
                    <i class="fa fa-warning"></i> <?php echo $img_info; ?>
                    </div>
                </div>
                <!-- 评论按钮 -->
                <div id="comments">
                    <!--存在评论就加载  -->
                    <?php
                        //评论代码路径
                        $com_file = FCPATH.'application/views/user/comment.html';
                        if(file_exists($com_file)){
                            $comment = file_get_contents($com_file);
                            echo $comment;
                        }
                    ?>
                </div>
                <!-- 评论按钮END -->
            </div>
            <!-- 图片右侧 -->
            
            <!-- 图片右侧END -->
        </div>
        <div class="layui-col-lg4" id = "pic-right">
            <div class="sidebar">
            <!-- 右侧选项卡 -->
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <ul class="layui-tab-title">
                    <li class="layui-this">图片链接</li>
                    <li>图片信息</li>
                </ul>
                <div class="layui-tab-content">
                    <!-- 第一个选项卡 -->
                    <div class="layui-tab-item layui-show">
                        <div id="links">
                            <table class="layui-table" lay-skin="nob">
                                <colgroup>
                                    <col width="60">
                                    <col width="450">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>URL</td>
                                        <td><input type="text" class="layui-input" id="url" data-cip-id="url" value = "<?php echo $url; ?>"></td>
                                        <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('url')">复制</a></td>
                                    </tr>
                                    <tr>
                                        <td>HTML</td>
                                        <td><input type="text" class="layui-input" id="html" data-cip-id="html" value = "<img src = '<?php echo $url; ?>' />"></td>
                                        <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('html')">复制</a></td>
                                    </tr>
                                    <tr>
                                        <td>MarkDown</td>
                                        <td><input type="text" class="layui-input" id="markdown" data-cip-id="markdown" value = "![](<?php echo $url; ?>)"></td>
                                        <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('markdown')">复制</a></td>
                                    </tr>
                                    <tr>
                                        <td>BBcode</td>
                                        <td><input type="text" class="layui-input" id="bbcode" data-cip-id="bbcode" value = "[img]<?php echo $url; ?>[/img]"></td>
                                        <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="copyurl('bbcode')">复制</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- 第1个选项卡END -->
                    
                    <!-- 第二个选项卡 -->
                    <div class="layui-tab-item">
                    <table class="layui-table">
                        <colgroup>
                            <col width="150">
                            <col>
                        </colgroup>
                        <!-- <thead>
                            <tr>
                            <th>属性</th>
                            <th>对应值</th>
                            </tr> 
                        </thead> -->
                        <tbody>
                            <tr>
                                <td>分辨率</td>
                                <td><?php echo $width; ?> x <?php echo $height; ?></td> 
                            </tr>
                            
                            <tr>
                                <td>MIME类型</td>
                                <td><?php echo $mime; ?></td>
                            </tr>
                            <tr>
                                <td>扩展名</td>
                                <td><?php echo $ext; ?></td>
                            </tr>
                            <tr>
                                <td>上传日期</td>
                                <td><?php echo $date; ?></td> 
                            </tr>
                            <tr>
                                <td>浏览次数</td>
                                <td><?php echo $views; ?></td> 
                            </tr>
                            <tr>
                                <td>文件大小</td>
                                <td><?php echo $size; ?></td> 
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <!-- 第二个选项卡END -->
                </div>
                
            </div>
            <!-- 右侧选项卡END -->
                
            </div>
            <!-- 第二个sidebar -->
            <div class="sideba">
                <!-- <a href="https://e.aiguobit.com/?from=xiaoz"><img src="https://www.xiaoz.me/wp-content/uploads/2017/06/netssocks_300.png" alt=""></a> -->
            </div>
            <!-- 第二个sidebar结束 -->
        </div>
        <!-- 图片主要区域END -->
    </div>
</div>
<script>
//调用示例

</script>