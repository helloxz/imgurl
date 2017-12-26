$(document).ready(function()
{	
	$("#fileuploader").uploadFile({
	url:"./upload.php",
	maxFileSize:"2097152",
	allowedTypes:"jpg,jpeg,png,gif,bmp",
	showStatusAfterSuccess:"false",
	dragdropWidth:"100%",
	
	
	//允许上传最大文件数量
	//showDone:"false"
	//showQueueDiv: "output"
	onSubmit:function(files)
	{
		$("#loading").show();
	},
	onSuccess:function(files,data,xhr,pd)
	{
		var eroticism = $("#eroticism").html();		//鉴黄状态
		var tinypng = $("#tinypng").html();			//压缩状态
		$("#loading").hide();
		$("#relink").show();
	    var imginfo = new Function("return" + data)();
	    document.getElementById("linkurl").value = imginfo.linkurl;
		document.getElementById("htmlurl").value = "<img src = '" + imginfo.linkurl + "' />";
		document.getElementById("mdurl").value = "![](" + imginfo.linkurl + ")";
		document.getElementById("bbcode").value = "[img]" + imginfo.linkurl + "[/img]";
		$("#show_img").attr('src',imginfo.linkurl);
		$("#img-url").attr('href',imginfo.linkurl);
		$("#img-box").show();
		//如果启用了鉴黄
		if(eroticism == 1) {
			identify(imginfo.linkurl);
		}
		//如果启用了图片压缩
		if(tinypng == 1) {
			compression(imginfo.linkurl);
		}
	}
	});
});

//复制按钮
function copy(url) {
	new clipBoard($("#url"),{
		copy: function() {
			return $("#" + url).val();	
		},
		afterCopy: function() {
			$("#msg").show();
			$("#msg").fadeOut(1500);
		}
	});
}
//鉴黄
function identify(imgurl) {
	$.get("./api/identify.php?url="+imgurl,function(data,status){
		var reinfo = new Function("return" + data)();
		if((reinfo.code == 0) && (reinfo.result >= 1)) {
			alert('请勿上传违规图片！');
			return false;
		}
		//请求失败，重复执行
		while(reinfo.code == null) {
			$.get("./api/identify.php?url="+imgurl,function(data,status){
				var reinfo = new Function("return" + data)();
				if((reinfo.code == 0) && (reinfo.result >= 1)) {
					alert('请勿上传违规图片！');
					return false;
				}
			});
		}
	});
}
//图片压缩
function compression(imgurl) {
	$.get("./api/tinypng.php?url="+imgurl,function(data,status){
		return true;
	});
}
