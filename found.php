<?php
    $title = "探索发现 - ImgURL";
    include_once("./tpl/user/header.php");
    // 载入类
    include_once("config.php");
    
    //获取当前时间
    $thetime = date('Y-m',time());
    
    //初始化
    $domain = $config['domain'];
    $userdir = $config['userdir'];
    $sql = "SELECT `id`,`path` FROM `imginfo` WHERE (`dir` = '$userdir' AND `level` < 3 AND `date` LIKE '$thetime%') ORDER BY random() LIMIT 12";
    $datas = $database->query($sql)->fetchAll();
    
?>

<div class="layui-container" style = "margin-bottom:6em;">
    <div class="layui-row">
        <div class="msg"><i class="layui-icon">&#xe645;</i>  此页面随机显示本月12张图片，刷新页面可重新随机，如果不显示说明本月暂未上传图片。</div>
        <div id = "found-img" class = "layui-col-space20">
            <?php foreach ($datas as $img) {
                    $imgurl = $domain.$img['path'];
                    $imgid = $img['id'];
            ?>
            <div class="layui-col-lg4">
                <a href="javascript:;" onclick = "userpreview('<?php echo $imgurl ?>',<?php echo $imgid; ?>)"><img src="<?php echo $imgurl ?>"></a>
            </div>
            <?php } ?>
        </div>
        
    </div>  
</div>

<?php
    include_once("./tpl/user/footer.php");
?>