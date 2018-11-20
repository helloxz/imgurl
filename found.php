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
    //$sql = "SELECT `id`,`path` FROM `imginfo` WHERE (`dir` = '$userdir' AND `level` < 3 AND `date` LIKE '$thetime%') ORDER BY random() LIMIT 12";
    $sql = "SELECT `id`,`path` FROM `imginfo` WHERE (`dir` = '$userdir' AND `level` < 3 AND `date` LIKE '$thetime%') ORDER BY `id` DESC";
    $datas = $database->query($sql)->fetchAll();
    
?>

<div class="layui-container" style = "margin-bottom:6em;">
    <div class="layui-row" >
        <div class="msg"><i class="layui-icon">&#xe645;</i>  此页面显示本月上传图片，如果不显示说明本月暂未上传图片。</div>
        <div id = "found-img" class = "layui-col-space20">
            <?php foreach ($datas as $img) {
                    $imgurl = $domain.$img['path'];
                    $imgid = $img['id'];
            ?>
            <div id = "imgid<?php echo $imgid; ?>" class="layui-col-lg4" style = "height:220px;border:1px solid #ECECEC;margin-top:1em;" onmouseover = "show_imgcon(<?php echo $imgid; ?>)" onmouseout = "hide_imgcon(<?php echo $imgid; ?>)">
                <!-- <a href="javascript:;" onclick = "userpreview('<?php echo $imgurl ?>',<?php echo $imgid; ?>)"></a> -->
                <img lay-src="<?php echo $imgurl ?>" layer-src="<?php echo $imgurl ?>" src = "./static/loading32.gif">
                <!-- 图片按钮 -->
                <div class = "imgcon" id = "imgcon<?php echo $imgid; ?>">
                    <a href="javascript:;" title = "图片链接" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "adminshow('<?php echo $imgurl ?>',<?php echo $imgid; ?>)"><i class="layui-icon">&#xe64c;</i></a>
                </div>
                <!-- 图片按钮END -->
            </div>
            <?php } ?>
        </div>
        
    </div>  
</div>
<!--图片查看-->
<div id="adminshow">
	<div style = "margin-top:2em;"><center><img src="" alt=""></center></div>
	<div id = "copy">
		<center>
		<table class="layui-table" lay-skin="nob">
            <colgroup>
                <col width="80">
                <col width="520">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <td>URL</td>
                    <td><input type="text" class="layui-input" id="url" data-cip-id="url"></td>
                    <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="newcopy('url')">复制</a></td>
                </tr>
                <tr>
                    <td>HTML</td>
                    <td><input type="text" class="layui-input" id="html" data-cip-id="html"></td>
                    <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="newcopy('html')">复制</a></td>
                </tr>
                <tr>
                    <td>MarkDown</td>
                    <td><input type="text" class="layui-input" id="markdown" data-cip-id="markdown"></td>
                    <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="newcopy('markdown')">复制</a></td>
                </tr>
                <tr>
                    <td>BBcode</td>
                    <td><input type="text" class="layui-input" id="bbcode" data-cip-id="bbcode"></td>
                    <td><a href="javascript:;" class="layui-btn layui-btn-sm" onclick="newcopy('bbcode')">复制</a></td>
                </tr>
            </tbody>
        </table>
        </center>
	</div>
</div>
<!--图片查看-->
<?php
    include_once("./tpl/user/footer.php");
?>