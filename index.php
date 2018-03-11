<?php
	//载入header
	include_once('tpl/header.php');
	include_once('./config.php');
?>
<!--是否启用鉴黄-->
<?php
	//如果启用鉴黄
	if($identify['eroticism'] == true) {
		$eroticism = 1;
	}
	else{
		$eroticism = 0;
	}
	//判断启用图片压缩
	switch ( $config['tinypng'] )
	{	
		//为空，没启用
		case '':
			$tinypng = 0;
			break;		
		default:
			$tinypng = 1;
			break;
	}
	
?>
<div id="eroticism" style = "display: none;"><?php echo $eroticism; ?></div>
<!--是否启用鉴黄END-->
<!--是否启用图片压缩-->
<div id="tinypng" style = "display: none;"><?php echo $tinypng; ?></div>
<!--是否启用图片压缩END-->
	<div style = "clear:both;"></div>
	<div class="container" style = "margin-bottom:40px;">
		<div class="row">
			<div class="col-lg-10 col-md-offset-1">
				<div id="fileuploader">Upload</div>
			</div>
		</div>
	</div>
	<!--上传成功后-->
	<div class="container" style = "margin-bottom:40px;">
		<div class="row">
			<div class="col-lg-10 col-md-offset-1">
				<!--显示-->
					<div class="table-responsive" id = "relink">
					  <table class="table">
					    <tbody>
					      <tr>
					        <td width = "15%">URL</td>
					        <td width = "75%"><input type="text" id = "linkurl" class="form-control"></td>
					        <td width = "10%"><a href="javascript:;" class="btn btn-info" onclick = "copy('linkurl');">复制</a></td>
					      </tr>
					     <tr>
					        <td>HTML</td>
					        <td><input type="text" id = "htmlurl" class="form-control"></td>
					        <td><a href="javascript:;" class="btn btn-info" onclick = "copy('htmlurl');">复制</a></td>
					      </tr>
					      <tr>
					        <td>MarkDown</td>
					        <td><input type="text" id = "mdurl" class="form-control"></td>
					        <td><a href="javascript:;" class="btn btn-info" onclick = "copy('mdurl');">复制</a></td>
					      </tr>
					      <tr>
					        <td>BBcode</td>
					        <td><input type="text" id = "bbcode" class="form-control"></td>
					        <td><a href="javascript:;" class="btn btn-info" onclick = "copy('bbcode');">复制</a></td>
					      </tr>
					    </tbody>
					  </table>
					  <div id = "img-box">
						  <a href="" id = "img-url" target = "_blank"><img id = "show_img" src="" alt="" class = "img-responsive center-block img-thumbnail"></a>
					  </div>
					</div>
				<!--显示-->
			</div>
		</div>
	</div>
	<!--上传成功END-->
<?php
	//载入页脚
	include_once('tpl/footer.php');
?>