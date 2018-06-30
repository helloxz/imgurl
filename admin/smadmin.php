<?php
    $title = "后台管理 - ImgURL";
    include_once("../functions/class/class.admin.php");
    // 载入头部
    include_once("../tpl/admin/header.php");

    // 获取类型
    $type = $_GET['type'];
    //获取页数
    $page = $_GET['page'];
    //查询sm.ms图片
    $imgs = $pic->querysm($page);
    //var_dump($imgs);
    
    $up = (int)$page - 1;
    if($up <= 0){
        $up = 1;
    }
    $down = (int)$page +1;
?>

<div class="layui-container" style = "margin-top:2em;">
    <div class="layui-row layui-col-space20">
        <div class="layui-col-lg3">
           <!-- 载入左侧导航栏 -->
           <?php include_once("../tpl/admin/left.php"); ?>
        </div>
         <!-- 后台内容部分 -->
         <div id = "adminpic">
         <div class="layui-col-lg9">
            <?php if($type == 'preview') { ?>
            <!-- 预览图片 -->
            <div class="layui-col-lg9 layui-col-space10">
            <?php foreach ($imgs as $img) {
            ?>
            <div class="layui-col-lg4 picadmin">
                <img lay-src="<?php echo $img['url']; ?>" layer-src="<?php echo $img['url']; ?>" alt="ID: <?php echo $img['id']; ?>" />
            </div>
            <?php } ?>
            </div>
            <?php }else{ ?>
            <!-- 预览图片END -->
            <!-- 表格 -->
            <table class="layui-table">
                <colgroup>
                    <col width="60">
                    <col width="380">
                    <col width="150">
                    <col width="120">
                    <col>
                </colgroup>
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>图片路径（点击可查看）</th>
                    <th>IP</th>
                    <th>日期</th> 
                    <th>操作</th>
                    </tr> 
                </thead>
                <tbody>
                <?php foreach ($imgs as $img) {
                    
                ?>
                   <tr id = "imgid<?php echo $img['id']; ?>">
                        <td><?php echo $img['id']; ?></td>
                        <td><a id = "imgid<?php echo $img['id']; ?>" href="javascript:;" onclick = "smshow('<?php echo $img['url'] ?>',<?php echo $img['id']; ?>)"><?php echo $img['url']; ?></a></td>
                        <td><a href="javascript:;" onclick = "ipquery('<?php echo $img['ip']; ?>')"><?php echo $img['ip']; ?></a></td>
                        <td><?php echo $img['date']; ?></td>
                        <td>
                            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "copyurl('<?php echo $img['url']; ?>')">复制</a>
                            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-danger" onclick = "deletesm(<?php echo $img['id']; ?>)">删除</a>
                        </td>
                   </tr>
                   <?php } ?>
                </tbody>
            </table>
                <?php } ?>
            <!-- 表格END -->
        </div>
        <!-- 翻页按钮 -->
        <div class="layui-col-lg9 layui-col-md-offset3">
            <div class="page">
                <a href="?type=<?php echo $type; ?>&page=<?php echo $up; ?>" class="layui-btn">上一页</a>
                <a href="?type=<?php echo $type; ?>&page=<?php echo $down; ?>" class="layui-btn">下一页</a>
            </div>
        </div>
        <!-- 翻页按钮END -->
        
        <!-- 后台内容部分END -->
    </div>
</div>
<?php
    // 载入页脚
    // 载入头部
    include_once("../tpl/admin/footer.php");
?>