<?php
	//载入header
	include_once('./header.php');
?>
<!--登录页面-->
<div class="container" style = "margin-top:40px;">
	<div class="row">
		<div class="col-lg-6 col-md-offset-3">
			<form class="form-horizontal" role="form" method = "post">
				<div class="form-group">
					<label class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id = "user">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">密 码</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="pass">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-default" id = "login">登 录</button> <label for="" id = "loading" style = "color:#3E9827;display:none;">注册中...</label>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#login").click(function(){
			var user = $("#user").val();
			var pass = $("#pass").val();

			$.post("./functions.php?type=login",{user:user,pass:pass},function(data,status){
				if(data == 'ok') {
					window.location.href = "./index.php";
				}
				else{
					alert('用户名或密码不对');
				}
			});
		});
	});
</script>
<!--登录页面end-->
<?php
	//载入页脚
	include_once('./footer.php');
?>