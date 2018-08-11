<?php
    $title = "URL批量上传 - ImgURL";
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
	            <div class="msg" style = "margin-top:0;"><i class="layui-icon"></i>  请输入图片地址，一行一个，一次不超过10个</div>
                <div class="urltext">
			      <textarea rows="10" id = "arrurl" name="desc" placeholder="请输入图片地址，一行一个" class="layui-textarea"></textarea>
			    </div>
			    <div style = "margin-top:1em;">
				    <a href="javscript:;" class="layui-btn" onclick = "urlup()">开始上传</a>
			    </div>
            </table>
                <?php } ?>
            <!-- 表格END -->
        </div>
        
        
        <!-- 后台内容部分END -->
    </div>
</div>
<?php
    // 载入页脚
    // 载入头部
    include_once("../tpl/admin/footer.php");
?>