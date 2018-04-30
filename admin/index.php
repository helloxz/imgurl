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
           <div>
           <table class="layui-table">
                <colgroup>
                    <col width="33%">
                    <col width="33%">
                    <col>
                </colgroup>
                <thead>
                    <tr>
                    <th>本月上传数量</th>
                    <th>今日上传</th>
                    <th>可疑图片</th>
                    </tr> 
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $data['month']; ?></td>
                        <td><?php echo $data['day']; ?></td>
                        <td><?php echo $data['level']; ?></td>
                    </tr>
                </tbody>
            </table>
           </div>
        </div>
        <!-- 后台内容部分END -->
    </div>
</div>

<?php
    // 载入页脚
    // 载入头部
    include_once("../tpl/admin/footer.php");
?>