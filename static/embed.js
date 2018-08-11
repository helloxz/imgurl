//layui 根目录配置
layui.config({
    base: '/static/layui/',
})
//载入layui组建
layui.use(['layer', 'form','element','upload','flow'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var element = layui.element;
    var upload = layui.upload;
    var flow = layui.flow;
    //图片懒加载
 	flow.lazyimg({
    	elem:'#found-img img'
 	}); 
 	flow.lazyimg({
    	elem:'#adminpic img'
     });
     //图片查看器
    layer.photos({
        photos: '#adminpic'
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    }); 
    layer.photos({
        photos: '#found-img'
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    }); 

    //首页拖拽上传
    upload.render({
        elem: '#upimg'
        ,url: 'functions/upload.php'
        ,size: 2048         //限制上传大小为2M
        ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
            layer.load(); //上传loading
        }
        ,done: function(res){
            //如果上传失败
            if(res.code == 0){
                layer.open({
                    title: '温馨提示'
                    ,content: res.msg
                });  
                layer.closeAll('loading');  
            }
            else if(res.code == 1){
                layer.closeAll('loading'); 
                $("#showpic a").attr('href',res.url);
                $("#showpic img").attr('src',res.url);
                $("#url").val(res.url);
                $("#html").val("<img src = '" + res.url + "' />");
                $("#markdown").val("![](" + res.url + ")");
                $("#bbcode").val("[img]" + res.url + "[/img]");
                $("#upok").show();
                //请求接口处理图片
                $.get("./dispose.php?id="+res.id,function(data,status){
                    var obj = eval('(' + data + ')');
                    if(obj.level == 3){
                        layer.open({
                            title: '温馨提示'
                            ,content: '请勿上传违规图片！'
                        }); 
                    }
                    if(obj.level == null){
	                    $.get("./dispose.php?id="+res.id,function(data,status){
		                    var obj = eval('(' + data + ')');
		                    if(obj.level == 3){
		                        layer.open({
		                            title: '温馨提示'
		                            ,content: '请勿上传违规图片！'
		                        }); 
		                    }
	                    });
                    }
                });
            }
        }
    });
    //上传到sm.ms
    upload.render({
        elem: '#sm'
        ,url: 'https://sm.ms/api/upload'
        ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
            layer.load(); //上传loading
        }
        ,done: function(res){
            //如果上传失败
            if(res.code == 'error'){
                layer.open({
                    title: '温馨提示'
                    ,content: res.msg
                });  
                layer.closeAll('loading');  
            }
            else if(res.code == 'success'){
                layer.closeAll('loading'); 
                $("#showpic a").attr('href',res.data.url);
                $("#showpic img").attr('src',res.data.url);
                $("#url").val(res.data.url);
                $("#html").val("<img src = '" + res.data.url + "' />");
                $("#markdown").val("![](" + res.data.url + ")");
                $("#bbcode").val("[img]" + res.data.url + "[/img]");
                $("#upok").show();
                $.post("./functions/sm.php",{data:res.data},function(data,status){

                });
            }
        }
    });
    //上传到sm.ms end
});

//复制链接
function copy(info){
    var copy = new clipBoard(document.getElementById('piclink'), {
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
      
          layer.msg('复制成功！', {time: 2000})
    }); 
}
//后台复制URL
function copyurl(url){
    var copy = new clipBoard(document.getElementById('adminpic'), {
        beforeCopy: function() {
            
        },
        copy: function() {
            return url;
        },
        afterCopy: function() {

        }
    });
    layui.use('layer', function(){
          var layer = layui.layer;
      
          layer.msg('链接已复制！', {time: 2000})
    }); 
}

//复制链接
function newcopy(info){
    var copy = new clipBoard(document.getElementById('url'), {
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
      
          layer.msg('复制成功！', {time: 2000})
    }); 
}

//用户登录方法
function login(){
    // 获取用户提交的信息
    var user = $("#user").val();
    var password = $("#password").val();

    $.post("../functions/Controller.php?type=login",{user:user,password:password},function(data,status){
        layer.msg(data,{time:2000});
    });
}

//用户前台预览图片
function userpreview(imgurl,id){
    var showimg = "<center><img style = 'max-width:100%;max-height:100%;' src = '" + imgurl + "' /></center>";
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type: 1,
            title:"图片预览",
            area: ['80%', '80%'],
            content: showimg
      });
  }); 
}

//后台管理员查看图片
function adminshow(imgurl,id){
    $("#adminshow").show();
    $("#url").val(imgurl);
    $("#html").val("<img src = '" + imgurl + "' />");
    $("#markdown").val("![](" + imgurl + ")");
    $("#bbcode").val("[img]" + imgurl + "[/img]");
    
    $("#copy").show();
    $("#adminshow img").attr("src",imgurl);
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type: 1,
            title:false,
            area: '720px',
            content: $("#adminshow"),
            btn: ['删除'],
            cancel: function(index, layero){ 
	            $("#adminshow img").attr("src","");
			  	$("#copy").hide();
			},
            yes: function(index, layero){
                layer.confirm('确认删除？', {icon: 3, title:'温馨提示！'}, function(index){
                    $.get("./delete.php?id="+id,function(data,status){
                        if(data == 'ok') {
	                        
                            $("#imgid"+id).remove();
                            $("#adminshow img").attr("src","");
			  				$("#copy").hide();
                        }
                        else{
                            alert(data);
                        }
                    });
                
                	layer.closeAll();
                });
            }
      });
  }); 
}



//后台管理员查看SM.MS图片
function smshow(imgurl,id){
    var showimg = "<center><img style = 'max-width:100%;max-height:100%;' src = '" + imgurl + "' /></center>";
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type: 1,
            title:"图片预览",
            area: ['80%', '80%'],
            content: showimg,
            btn: ['压缩', '删除'],
            yes: function(index, layero){
                layer.msg('SM.MS图片不支持压缩！', {time: 2000})
            }
            //删除按钮
            ,btn2: function(index, layero){
                layer.confirm('确认删除？', {icon: 3, title:'温馨提示！'}, function(index){
                    $.get("./delete.php?type=sm&id="+id,function(data,status){
                        if(data == 'ok') {
                            $("#imgid"+id).remove();
                        }
                        else{
                            alert(data);
                        }
                    });
                
                layer.close(index);
                });
            }
      });
  }); 
}

//删除某张图片
function deleteimg(id){
    layer.confirm('确认删除？', {icon: 3, title:'温馨提示！'}, function(index){
        $.get("./delete.php?id="+id,function(data,status){
            if(data == 'ok') {
                $("#imgid"+id).remove();
            }
            else{
                alert(data);
            }
        });
    
    layer.close(index);
    });
}
//删除SM.MS图片
function deletesm(id){
    layer.confirm('确认删除？', {icon: 3, title:'温馨提示！'}, function(index){
        $.get("./delete.php?type=sm&id="+id,function(data,status){
            if(data == 'ok') {
                $("#imgid"+id).remove();
            }
            else{
                alert(data);
            }
        });
    
    layer.close(index);
    });
}

//取消图片可疑状态
function cdubious(id){
    layer.confirm('确认取消图片可疑状态？', {icon: 3, title:'温馨提示！'}, function(index){
        $.get("./operation.php?type=cdubious&id="+id,function(data,status){
            if(data == 'ok') {
                $("#imgid"+id).remove();
            }
            else{
                alert(data);
            }
        });
    
    layer.close(index);
    });
}

//图片压缩功能
function compress(id){
    //layer.msg('该功能还在开发中！', {time: 2000})
    layer.open({
	  	type:3
	  	,content: '处理中...'
	});
    $.get("../functions/class/class.pic.php?id=" + id,function(data,status){
	    if(status == 'success'){
		    layer.closeAll('loading');
	    }
        layer.open({
            title: '温馨提示：',
            time:2000
            ,content: data
        });  
    });
}

//IP查询
function ipquery(ip){
    $.get("https://ip.awk.sh/api.php?data=addr&ip=" + ip,function(data,status){
        if(status == 'success') {
            layer.open({
                title: 'IP查询结果：'
                ,content: data
                ,time:3000
            });  
        }
    });
}

//关于
function about(){
    url = window.location.protocol + '//';
    url = url + window.location.host + '/';
    layer.open({
        title: '关于',
        type: 2, 
        area: ['240px', '100px'],
        content: "./about.php"
    });
}

//删除本页所有照片
function delall(){
    layer.confirm('确认删除本页所有图片？', {icon: 3, title:'提示'}, function(index){
        //do something
        
        layer.close(index);
    });
}

//预览图片
function previewimg(id,url){
    var imgid = "img" + id;
    var upid = id - 1;
	
	var dnid = id + 1;
	
	$("#show" + upid).hide();
    $("#show" + dnid).hide();
    
    $("#img" + id).attr('src',url);
    $("#show" + id).show();
    
}
//隐藏图片
function hideimg(id){
	var upid = id - 1;
	
	var dnid = id + 1;
	$("#show" + id).hide();
	$("#show" + upid).hide();
	$("#show" + dnid).hide();
}

//Ctrl + V上传图片
//$(document).keyup(function(){
//    if(event.keyCode == 86){
        
//    }
//});

//预览图片
function viewimg(id,imgurl){
	id = "viewimg" + id;
	$("#" + id + " img").attr('src',imgurl);
	//显示图片
	$("#" + id).show();
	
}
//隐藏图片
function hideimg(id){
	id = "viewimg" + id;
	$("#" + id).hide();
}

//URL上传
function urlup(){
	layui.use('layer', function(){
	  	var layer = layui.layer;
	  	layer.open({
		  	type:3
		  	,content: '上传中，请等待...'
		});
	}); 
	arr = $("#arrurl").val();
	//如果地址为空
	if(arr == ''){
		layer.closeAll('loading');
		layer.msg('地址不能为空！');
		return false;
	}

	$.post("../functions/urlup.php",{arr:arr},function(data,status){
		var re = eval('(' + data + ')');
		if(re.code == 1){
			//关闭加载层
			layer.closeAll('loading');
			layer.msg(re.msg);
		}
		else if(re.code == 0){
			//关闭加载层
			layer.closeAll('loading');
			layer.msg(re.msg);
		}
		else{
			layer.closeAll('loading');
			layer.msg(re.msg);
		}
	});
}