layui.use(['form','element','layer','laydate'], function(){
    var form = layui.form;
	var element = layui.element;
	var layer = layui.layer;
	var laydate = layui.laydate;

	//执行一个laydate实例
	laydate.render({
		elem: '#start-time' //指定元素
		,done: function(value, date, endDate){
			start_time = value;
		}
	});
	laydate.render({
		elem: '#end-time' //指定元素
		,done: function(value, date, endDate){
			end_time = value;
		}
	});
    
    //监听提交
    // form.on('submit(formDemo)', function(data){
    //   layer.msg(JSON.stringify(data.field));
    //   return false;
	// });
	//相册层
	layer.photos({
		photos: '#showimgs'
		,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
	}); 
	//站点设置提交
    form.on('submit(formsite)', function(data){
      	console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
      	console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
		console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
		//return false;
	});
	//上传限制开关按钮
	form.on('switch(upswitch)', function(data){
		console.log(data.elem.checked);
		//开关关闭的时候
		if(data.elem.checked == false){
			$("#limit").val(0);
		}
		else if(data.elem.checked == true){
			$("#limit").val(10);
		}
	}); 
	//上传限制提交表单
	form.on('submit(formuplimit)', function(data){
		console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
		console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
		console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
		// return false;
	});
	//tinypng设置表单
	form.on('submit(formtiny)', function(data){
		// console.log(data.field)
		//  return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
	});
	//启用鉴黄按钮
	form.on('submit(formModerate)', function(data){
		
	});
	//更新localhost
	form.on('submit(formlocalhost)', function(data){
		
	});
});

//下面是同步执行
function urlup(){
	var arrurl = $("#arrurl").val();
	var remsg = '';
	if(arrurl == ''){
		layer.msg('请填写URL地址！');
		return false;
	}
	arrurl = arrurl.split("\n");
	layer.load();

	for(var j = 0,len = arrurl.length; j < len; j++){
		//同步请求
		$.ajax({
			type:'post',
			url:'/upload/url',
			data:"url=" + arrurl[j],
			async : true, 
			success : function(data){  
				var re = JSON.parse(data);
				remsg += re.msg + "\n";
				$("#urlupmsg").val(remsg);
			}  
		});
	}
	layer.closeAll('loading');
	//console.log(arrurl);
}

function up_load(){
	layer.load();
}
//显示图片链接
function showlink(url,thumburl){
    layer.open({
        type: 1,
        title: false,
        content: $('#imglink'),
        area: ['600px', '260px']
    });
    $("#img-thumb a").attr('href', thumburl);
    $("#img-thumb img").attr('src',thumburl);
    $("#url").val(url);
    $("#html").val("<img src = '" + url + "' />");
    $("#markdown").val("![](" + url + ")");
    $("#bbcode").val("[img]" + url + "[/img]");
    $("#imglink").show();
}
//复制链接
function copyurl(info){
    var copy = new clipBoard(document.getElementById('links'), {
        beforeCopy: function() {
            info = $("#" + info).val();
        },
        copy: function() {
            return info;
        },
        afterCopy: function() {

        }
    });
    layui.use('layer', function(){
          var layer = layui.layer;
      
          layer.msg('链接已复制！', {time: 2000})
    }); 
}
//显示图片信息
function imginfo(imgid,title){
	layer.open({
		type: 2, 
		title:title,
		area:['520px','360px'],
		content: '/manage/imginfo/' + imgid //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
	}); 
}
//删除单张图片
function del_img(id,imgid,path,thumbnail_path){
	layer.confirm('确认删除这张图片？', {icon: 3, title:'温馨提示！'}, function(index){
        $.post("/set/del_img",{imgid:imgid,path:path,thumbnail_path:thumbnail_path},function(data,status){
			var re = JSON.parse(data);
            if(re.code == 200) {
                $("#img"+id).remove();
                console.log("#img"+id);
            }
            else{
                layer.msg(data);
            }
        });
    
    layer.close(index);
    });
}
//压缩图片
function compress(id){
	//加载中
	var index = layer.load();
	$.get("/deal/compress/" + id,function(data,status){
		re = JSON.parse(data);
		if(re.code == 200){
			layer.close(index); 
			layer.msg(re.msg);
		}
		else if(re.code == 0){
			layer.close(index); 
			layer.msg(re.msg);
		}
		else{
			layer.close(index); 
			layer.msg(data);
		}
	});
}
//取消图片可疑状态
function cancel(id){
	layer.confirm('确定取消可疑状态？', {icon: 3, title:'温馨提示！'}, function(index){
        $.get("/set/cancel/" + id,function(data,status){
			var re = JSON.parse(data);
            if(re.code == 200) {
                layer.msg('操作成功，请手动刷新页面！');
            }
            else{
                layer.msg(data);
            }
        });
    
    layer.close(index);
    });
}
//删除多张图片
function del_more(){
	var chkIds = "";  
	$("input:checkbox:checked").each(function(i){  
		chkIds += $(this).val() + ",";  
	});
	//console.log(chkIds);
	ids = chkIds.split(',');
	layer.confirm('确认删除多张图片？（不可恢复）', {icon: 3, title:'温馨提示！'}, function(index){
        for(var i = 0;i < ids.length - 1;i++){
			$.get("/del/id/" + ids[i],function(data,status){
				var re = JSON.parse(data);
				if(re.code == 200) {
					$("#img" + re.id).remove();
					console.log("#img" + re.id);
				}
				else{
					layer.msg(data);
				}
			});
		}
    layer.close(index);
    });
	
}
//查看当前版本
function version(){
	layer.open({
		title:'当前版本：',
		area: ['240px', '100px'],
		type: 2, 
		content: '/maintain/version' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
	}); 
}

//全选按钮
$("#checkAll").click(function() {
	if (this.checked) {
		$("input[name='chk']:checkbox").each(function() { //遍历所有的name为selectFlag的 checkbox
					$(this).attr("checked", true);
				})
	} else {   //反之 取消全选 
		$("input[name='chk']:checkbox").each(function() { //遍历所有的name为selectFlag的 checkbox
					$(this).attr("checked", false);
					//alert("f");
				})
	}
})
//根据条件查找图片
function findimg(){
	var value = $("#value").val();
	var type = $("#type").val();

	if( type == ''){
		layer.msg('请选择筛选条件！');
		return false;
	}
	else if( value == ''){
		layer.msg('请输入值！');
		return false;
	}
	window.location.href = '/manage/images/' + type + '/?value=' + value;
	
}
//根据时间查找图片
function find_date_img(){
	//获取上传者
	var user = $("#user").val();
	
	//时间组合
	var date = start_time + '|' + end_time;
	if( user == ''){
		layer.msg('请选择筛选条件！');
		return FALSE;
	}
	else if( start_time == ''){
		layer.msg('请选择开始日期！');
		return FALSE;
	}
	else if(end_time == ''){
		layer.msg('请选择结束日期！');
		return FALSE;
	}
	window.location.href = '/manage/images/' + user + '/?date=' + date;
}
//$("#quanxuan").click(function(){ 
//	$("input[name='checkbox']").attr("checked","true"); 
//})

/*
下面几个操作的方法来源于：https://www.cnblogs.com/diony/p/8028424.html
*/
//全选按钮
function check_all(){
	$("input[name='chk']").attr("checked","true"); 
}
//取消全选
function cancel_all(){
	$("input[name='chk']").removeAttr("checked"); 
}
