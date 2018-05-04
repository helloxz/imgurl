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
         <div class="layui-col-lg9">
            <!-- 表格 -->
            <table class="layui-table">
                <colgroup>
                    <col width="30">
                    <col width="280">
                    <col width="120">
                    <col width="120">
                    <col width="120">
                    <col>
                </colgroup>
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>图片路径（点击可查看）</th>
                    <th>IP</th>
                    <th>日期</th>
                    <th>是否压缩</th>
                    <th>操作</th>
                    </tr> 
                </thead>
                <tbody>
                <?php foreach ($imgs as $img) {
                    $imgurl = $config['domain'].$img['path'];
                    $id = $img['id'];
                    $size = filesize('../'.$img['path']);     //文件大小计算
                    $size = round($size / 1024)."kb";
                    if($img['compress'] == 0) {
                        $compress = array(
                            "css"       =>  "layui-btn layui-btn-xs layui-btn-danger",
                            "content"   =>  "否"
                        );
                    }
                    else{
                        $compress = array(
                            "css"       =>  "layui-btn layui-btn-xs layui-btn-normal",
                            "content"   =>  "是"
                        );
                    }
                ?>
                   <tr id = "imgid<?php echo $id; ?>">
                        <td><?php echo $id; ?></td>
                        <td><a id = "imgid<?php echo $id; ?>" href="javascript:;" onclick = "adminshow('<?php echo $imgurl ?>',<?php echo $id; ?>)"><?php echo $img['path']; ?></a></td>
                        <td><a href="javascript:;" onclick = "ipquery('<?php echo $img['ip']; ?>')"><?php echo $img['ip']; ?></a></td>
                        <td><?php echo $img['date']; ?></td>
                        <td>
                            <a href="javascript::" class = "<?php echo $compress['css']; ?>"><?php echo $compress['content']; ?></a>
                            <a href="javascript:;" class = "layui-btn layui-btn-xs layui-btn-disabled"><?php echo $size; ?></a>
                        </td>
                        <td>
                            <?php if($type == 'dubious'){ ?>
                            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "cdubious(<?php echo $id; ?>)">非可疑</a>
                            <?php }else{ ?>
                            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "compress(<?php echo $id; ?>)">压缩</a>
                            <?php } ?>
                            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "copyurl('<?php echo $imgurl; ?>')">复制</a>
                            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-danger" onclick = "deleteimg(<?php echo $id; ?>)">删除</a>
                        </td>
                   </tr>
                   <?php } ?>
                </tbody>
            </table>
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