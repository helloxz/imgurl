$(document).ready(function()
{
	$("#fileuploader").uploadFile({
	url:"./upload.php",
	maxFileSize:"2097152",
	allowedTypes:"jpg,png,gif,bmp",
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