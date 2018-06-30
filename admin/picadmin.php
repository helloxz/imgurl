<?php
    $title = "后台管理 - ImgURL";
    include_once("../functions/class/class.admin.php");
    // 载入头部
    include_once("../tpl/admin/header.php");

    // 获取类型
    $type = $_GET['type'];
    //获取页数
    $page = $_GET['page'];
    //查询图片
    $imgs = $pic->querypic($type,$page);
    
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
         <div class="layui-col-lg9 layui-col-space10">
            <?php foreach ($imgs as $img) {
                $imgurl = $config['domain'].$img['path'];
                $id = $img['id'];
            ?>
            <div class="layui-col-lg4 picadmin">
                <!-- <a id = "imgid<?php echo $id; ?>" href="javascript:;" onclick = "adminshow('<?php echo $imgurl ?>',<?php echo $id; ?>)"></a> -->
                <img lay-src="<?php echo $imgurl; ?>" layer-src="<?php echo $imgurl; ?>" alt="图片ID: <?php echo $id; ?>">
            </div>
            <?php } ?>
        </div>
        <!-- 翻页按钮 -->
        <div class="layui-col-lg9 layui-col-md-offset3">
            <div class="page">
                <a href="?type=<?php echo $type; ?>&page=<?php echo $up; ?>" class="layui-btn">上一页</a>
                <a href="?type=<?php echo $type; ?>&page=<?php echo $down; ?>" class="layui-btn">下一页</a>
                <!-- <a href="javascript:;" onclick = "delall()" class="layui-btn layui-btn-danger">删除本页</a> -->
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