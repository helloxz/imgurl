<?php
	include_once('../tpl/admin/header.php');
	$type = $_GET['type'];

	switch ( $type )
	{
		case 'user':
			$listpic = $database->select("uploads",["id","dir","date"],["user" => "user","ORDER" => ["id" => "DESC"],"LIMIT" => 12]);
			break;	
		case 'admin':
			$listpic = $database->select("uploads",["id","dir","date"],["user" => "admin","ORDER" => ["id" => "DESC"],"LIMIT" => 12]);
			break;
		default:
			;
			break;
	}
	
?>
<!--内容区域-->
<div class="layui-col-lg8 layui-col-md-offset1" id = "showpic">
	<table class = "layui-table">
		<thead>
		    <tr>
		      <th width = "60%">图片路径</th>
		      <th width = "20%">上传时间</th>
		      <th width = "20%">选项</th>
		    </tr> 
		 </thead>
		<tbody>
			<?php for($i = 0;$i < 12;$i++){ 
				$imgurl = $config['domain'].$listpic[$i]['dir'];
			?>
			<tr>
				<td><a href="javascript:;" onclick = "showimg('<?php echo $imgurl ?>');"><?php echo $listpic[$i]['dir']; ?></a></td>
				<td><a href="javascript:;"><?php echo $listpic[$i]['date']; ?></td>
				<td><a href="javascript:;" class = "layui-btn layui-btn-danger layui-btn-xs" onclick = "delimg();">删除</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<!--内容区域END-->
<?php
	include_once('../tpl/admin/footer.php');
?>
<script>
	function showimg(imgurl){
		layui.use('layer', function(){
	  	var layer = layui.layer;
	  	layer.open({
		  	type: 1,
		  	title:"图片预览",
		  	area: ['600px', '400px'],
		  	content: "<img width = '100%' src = '" + imgurl + "' />"
		});
	}); 
	}
	//删除图片
	function delimg(){
		layer.confirm('纳尼？', {
		  btn: ['按钮一', '按钮二', '按钮三'] //可以无限个按钮
		  ,btn3: function(index, layero){
		    //按钮【按钮三】的回调
		  }
		}, function(index, layero){
		  //按钮【按钮一】的回调
		}, function(index){
		  //按钮【按钮二】的回调
		});
	}
	
</script>