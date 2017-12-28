<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	//载入配置
	include_once('./config.php');
	//载入header
	include_once('./header.php');
	//获取页数
	$page = $_GET['page'];
	
	$current_time = date('ym',time());	//当前月份

	$time = $_GET['time'];
	$mydir = $_GET['dir'];

	//时间不存在，用当前时间
	if(!isset($time)) {
		$time = $current_time;
	}
	//目录不存在，使用普通用户目录
	if(!isset($mydir)) {
		$mydir = $config['userdir'];
	}
	//目录存在，但是既不是用户目录也不是管理员目录
	if(($mydir != $config['userdir']) && ($mydir != $config['admindir'])) {
		$mydir = $config['userdir'];
	}
	//目录存在,并且是管理员目录
	if($mydir == $config['admindir']) {
		$mydir = $config['admindir'];
		//改变下管理员链接地址
		$geturl = "&dir=$mydir";
	}
?>
<div class="container" style = "margin-top:40px;">
	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
			<!--图片预览-->
			<div class="col-lg-6">
				<img id = "viewid" src="./static/view.jpg" class="img-thumbnail img-responsive">
			</div>
			<!--图片预览END-->
			<div class="col-lg-6">
			<table class="table table-striped">
			<tbody>
<?php
	function get_files($dir) {
    $files = array();
 
    for (; $dir->valid(); $dir->next()) {
        if ($dir->isDir() && !$dir->isDot()) {
            if ($dir->haschildren()) {
                $files = array_merge($files, get_files($dir->getChildren()));
            };
        }else if($dir->isFile()){
            $files[] = $dir->getPathName();
        }
    }
    return $files;
	}

	//如果页数不存在或者小于1
	if((!isset($page)) || ($page <= 1)) {
		$page = 1;
		$i = 0;
		$num = 15;
	}
	if($page > 1) {
		$i = ($page - 1) * 15;
		$num = $i + 15;
	}
	 
	$path = $mydir.'/'.$time;
	$dir = new RecursiveDirectoryIterator($path);
	$fname = get_files($dir);
	$allnum = count($fname) - 1;		//文件总数
	//echo $allnum;
	//最大页数
	$allpage = round($allnum / 15,0);
	$uppage = $page - 1;			//上一页
	$downpage = $page + 1;			//下一页
	
	$downpage = ($page >= $allpage) ? $page : $downpage;
	//echo $allpage;
	
	//如果文件数小于15
	//$num = count($allnum < 15) ? $allnum : $num;
	if($allnum <= 15) {
		$num = $allnum;
	}
	
	for($i;$i <= $num;$i++) {
		$fname[$i] = str_replace("\\","/",$fname[$i]);
		//如果文件是空的，则终止循环
?>
				<tr id = "row<?php echo $i; ?>">
					<td onmouseover = "return view('<?php echo $config['domain'].$fname[$i] ?>');">
					<?php 
						echo "<a href = "."'".$config['domain'].$fname[$i]."' target = '_blank'>"."$fname[$i]</a>";
					 ?>
					 </td>
					<td>
						<?php
							if(isset($_COOKIE['uid'])) {
								echo "<a href = \"javascript:;\" onclick = \"del('$fname[$i]',$i);\">删除</a>";
							}
						?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<a href="?page=<?php echo $uppage.$geturl; ?>" class = "btn btn-primary"><span class = "glyphicon glyphicon-chevron-left"></span> 上一页</a>  
		<a href="?page=<?php echo $downpage.$geturl; ?>" class = "btn btn-primary">下一页 <span class = "glyphicon glyphicon-chevron-right"></span></a>
		</div>
		</div>
	</div>
</div>
<script>
	function view(imgurl) {
		$("#viewid").src;
		$("#viewid").attr('src',imgurl); 
	}
	//删除图片
	function del(filedir,rowid) {
		//行id
		var rowid = 'row' + rowid;
		//确认删除？
		var msg = "确认删除？";
		if (confirm(msg)==true){ 
			$.get("./functions.php?type=delete&dir="+filedir,function(data,status){
				//删除成功
				if(data == 'ok') {
					$("#"+rowid).remove();
				}
				else{
					alert(data);		//删除失败，弹出报错
				}
			});
		}else{ 
			return false; 
		}
	}
</script>

<?php
	//载入页脚
	include_once('./footer.php');
?>