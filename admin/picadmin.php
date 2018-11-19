<?php
    $title = "后台管理 - ImgURL";
    include_once("../functions/class/class.admin.php");
    // 载入头部
    include_once("../tpl/admin/header.php");

    // 获取类型
    $type = $_GET['type'];
    //获取时间
    @$date = $_GET['date'];
    //如果时间不为空
    if($date != ''){
	    $thedate = explode("|",$date);
	    $starttime = $thedate[0];
	    $endtime = $thedate[1];
	    //翻页选项
	    $thepage = '&date='.$date;
    }
    else{
	    $starttime = '';
	    //获取当前日期
	    $endtime = date("Y-m-d",time());
	    //翻页选项
	    $thepage = '';
    }
    //获取页数
    $page = $_GET['page'];
    //查询图片
    $imgs = $pic->newquery($type,$date);
    
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
         <div class="layui-col-lg9 layui-col-space10" style="margin-bottom:6em;">
	        <!--时间筛选-->
			<div id="date">
				<table class="layui-table" lay-skin="nob">
					<tbody>
						<tr>
							<td>按时间筛选：</td>
							<td><input type="text" class="layui-input" id="starttime" value = "<?php echo $starttime; ?>"></td>
							<td> - </td>
							<td><input type="text" class="layui-input" id="endtime" value = "<?php echo $endtime; ?>"></td>
							<td><button lay-submit class="layui-btn" onclick = "screen('picadmin.php')">筛选</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		    <!--时间筛选END-->
            <?php foreach ($imgs as $img) {
                $imgurl = $config['domain'].$img['path'];
                $id = $img['id'];
            ?>
            <div id = "imgid<?php echo $id; ?>" class="layui-col-lg4 picadmin" onmouseover = "show_imgcon(<?php echo $id; ?>)" onmouseout = "hide_imgcon(<?php echo $id; ?>)">
                <!-- <a id = "imgid<?php echo $id; ?>" href="javascript:;" onclick = "adminshow('<?php echo $imgurl ?>',<?php echo $id; ?>)"></a> -->
                <img lay-src="<?php echo $imgurl; ?>" layer-src="<?php echo $imgurl; ?>" alt="图片ID: <?php echo $id; ?>" src = "../static/loading32.gif">
                <!-- 删除按钮 -->
                <div class = "imgcon" id = "imgcon<?php echo $id; ?>">
                    <a href="javascript:;" title = "图片链接" class="layui-btn layui-btn-xs layui-btn-normal" onclick = "adminshow('<?php echo $imgurl ?>',<?php echo $id; ?>)"><i class="layui-icon">&#xe64c;</i></a>
                    <a href="javascript:;" title = "删除这张图片" class="layui-btn layui-btn-xs layui-btn-danger" onclick="deleteimg(<?php echo $id; ?>)"><i class="layui-icon">&#xe640;</i></a>
                </div>
                <!-- 删除按钮END -->
            </div>
            <?php } ?>
        </div>
        <!-- 翻页按钮 -->
        
        <!-- 翻页按钮END -->
        <!-- 后台内容部分END -->
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
    // 载入页脚
    // 载入头部
    include_once("../tpl/admin/footer.php");
?>