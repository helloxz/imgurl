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
    //当你执行这样一个方法时，即对页面中的全部带有lay-src的img元素开启了懒加载（当然你也可以指定相关img）
    // flow.lazyimg({
    //     elem:'#found-img img'
    // }); 

    //拖拽上传
    upload.render({
        elem: '#upimg'
        ,url: 'functions/upload.php'
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
                });
            }
        }
    });
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
                layer.msg('该功能还在开发中！', {time: 2000})
            }
            //删除按钮
            ,btn2: function(index, layero){
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
    $.get("../functions/class/class.pic.php?id=" + id,function(data,status){
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
