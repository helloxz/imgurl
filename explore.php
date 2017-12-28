<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	//载入配置
	include_once('./config.php');
	//载入header
	include_once('./header.php');

	// 获得一张随机图片
	function randompic() {
		global $config;
		include_once("./medoo.php");
		$db = new medoo([
			'database_type' => 'sqlite',
			'database_file' => $config['dbfile']
		]);
		$ret = $db->query("SELECT * FROM pictures ORDER BY RANDOM() LIMIT 1")->fetchAll();
		if ($ret[0]) {
			return array(
				"id" => $ret[0]['id'],
				"showname" => $ret[0]['raw'],
				"url" => $ret[0]['url']
			);
		} else
			return null;
	}

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
	}
	$pic="./static/view.jpg";
	$info=randompic();
	if ($info) 
		$pic = $info['url'];
?>
<div class="container" style = "margin-top:40px;">
	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
			<!--图片预览-->
			<div class="text-center">
				<img id = "viewid" src="<?php echo $pic?>" class="img-thumbnail img-responsive">
			</div>
			<!--图片预览END-->
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