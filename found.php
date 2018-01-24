<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	//载入配置
	include_once('./config.php');
	//载入header
	include_once('tpl/header.php');
	
	//获取当前时间
	$thetime = date('Y-m',time());
	$query = "SELECT `id`,`dir` FROM `uploads` WHERE (`date` LIKE '%2018-01%') AND 'user' = 'user' ORDER BY random() LIMIT 10";
	$datas = $database->query($query)->fetchAll();
	//print_r($datas);
	//var_dump($datas);
	//var_dump( $database->log() );
	
	//$datas = $database->select("uploads",[
	//	"id",
	//	"dir"
	//],[
	//	"ORDER" => "random()",
	//	"LIMIT" => 10,
	//	"date[~]" 	=> $thetime,
	//	"user"	=> 'user'
	//]);
	//var_dump( $database->log() );
	$num = $database->count("uploads",["date[~]" => $thetime]);

	//如果图片大于10张
	if($num > 10){
		$num = 10;
	}
	//print_r($datas);
	
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
	for($i = 0;$i < $num;$i++) {
		//如果文件是空的，则终止循环
		$imgdir = $datas[$i]['dir'];
?>
				<tr id = "row<?php echo $i; ?>">
					<td onmouseover = "return view('<?php echo $config['domain'].$imgdir ?>');">
					<?php 
						echo "<a href = "."'".$config['domain'].$imgdir."' target = '_blank'>"."$imgdir</a>";
					 ?>
					 </td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
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
	include_once('tpl/footer.php');
?>