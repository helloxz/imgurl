<?php
    $title = "后台管理 - ImgURL";
    include_once("../functions/class/class.admin.php");
    // 载入头部
    include_once("../tpl/admin/header.php");
    //获取统计数据
    $data = $pic->data();
?>

<div class="layui-container" style = "margin-top:2em;">
    <div class="layui-row">
        <div class="layui-col-lg3">
           <!-- 载入左侧导航栏 -->
           <?php include_once("../tpl/admin/left.php"); ?>
        </div>
        <!-- 后台内容部分 -->
        <div class="layui-col-lg9">
            <h1 style = "margin-bottom:0.8em;color:#515151">数据统计：</h1>
            <!-- 后台数据统计 -->
            <div id="tongji" class="layui-row layui-col-space18">
                <div class="layui-col-lg4">
                    <div class="item">
                        <p></p><h2>累计上传</h2><p></p>
                        <p><?php echo $data['all']; ?> 张</p>
                    </div>
                </div>
                <div class="layui-col-lg4">
                    <div class="item">
                        <p></p><h2><i class="fa fa-street-view fa-fw"></i> 本月上传</h2><p></p>
                        <p><?php echo $data['month']; ?> 张</p>
                    </div>
                </div>
                <div class="layui-col-lg4">
                    <div class="item">
                        <p></p><h2><i class="fa fa-exclamation-triangle fa-fw"></i> 当日上传</h2><p></p>
                        <p><?php echo $data['day']; ?> 张</p>
                    </div>
                </div>
                <div class="layui-col-lg4">
                    <div class="item">
                        <a href="./senioradmin.php?type=dubious&page=1">
                            <p></p><h2><i class="fa fa-exclamation-triangle fa-fw"></i> 可疑图片</h2><p></p>
                            <p><?php echo $data['level']; ?> 张</p>
                        </a>
                        
                    </div>
                </div>
                
            </div>
            <!-- 后台数据统计END -->
        </div>
        <!-- 后台内容部分END -->
    </div>
</div>

<?php
    // 载入页脚
    // 载入头部
    include_once("../tpl/admin/footer.php");
?>