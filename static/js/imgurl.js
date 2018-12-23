// ==UserScript==
// @name         ImgURL上传脚本
// @namespace    https://imgurl.org/
// @version      0.22
// @description  ImgURL快捷上传工具
// @author       xiaoz.me
// @match        http://*/*
// @match        https://*/*
// @license      GPL
// @grant        none
// ==/UserScript==

(function() {
    'use strict';

    //定义一个全局弹出层
    window.layerstart = '<div id = "layer" style = "box-shadow: 1px 1px 2px #888888;border-radius:5px;top:0em;left:0;width:80%;height:720px;background-color:#FFFFFF;position:fixed;z-index:999;display:none;border:1px solid #d2d2d2">';
    layerstart += '<div style="text-align:right;padding:0.8em;border-bottom:1px solid #d2d2d2;"><a href="javascript:;" onclick="closelayer()" style="color:#FFFFFF;background-color:#FF5722;width:80px;text-align:center;padding:0.5em;border-radius:2px;padding-left:1em;padding-right:1em;">关闭</a></div>';
    window.layerend = '</div>';

    //让层居中显示
    window.layerCenter = function(){
	    var bwidth = window.screen.availWidth;
	    var bheight = window.screen.availHeight;
	    var layertop = (bheight - 720) / 2;
	    var layerleft = (bwidth - 1280) / 2;
	    
	    if(layertop <= 70){
		    layertop = "1em";
	    }
	    else{
		    layertop = layertop + "px";
	    }

	    //改变css
	    //$("#layer").css({"top":layertop,"left":layerleft});
	    //原生js改变css
	    //alert(layertop);
	    document.getElementById("layer").style.top = layertop;
	    document.getElementById("layer").style.left = "10%";
    }
    //创建一个遮罩层
    window.keepout = function(){
	    var fade = '<div id = "fade" style = "width:100%;height:100%;background:rgba(0, 0, 0, 0.5);position: fixed;left: 0;top: 0;z-index: 99;" onclick = "closelayer()"></div>';
	    //$("body").append(fade);
	    var div = document.createElement("div");
	    div.innerHTML = fade;
		document.body.appendChild(div);
    }

    //关闭层
    window.closelayer = function(){
	    //$("#layer").hide();
	    document.getElementById("layer").style.display = "none";
		//showSidebar();
		//$("#layer").remove();
		var layer = document.getElementById("layer");
		layer.parentNode.removeChild(layer);
		
		//$("#fade").remove();
		var fade = document.getElementById("fade");
		fade.parentNode.removeChild(fade);
    }

    //创建一个显示按钮
    function imgurl(){
	    //$("body").append('<div id = "imgbtn" style = "position:fixed;right:1em;bottom:1em;z-index:88;cursor:pointer;" onclick = "showImgurl()"><img src = "https://libs.xiaoz.top/material/image.png" width = "36px" height = "36px" /></div>');
	    //使用原生js添加按钮
	    var div = document.createElement("div");
	    div.innerHTML = '<div id = "imgbtn" style = "position:fixed;right:1em;bottom:1em;z-index:88;cursor:pointer;" onclick = "showImgurl()"><img src = "https://libs.xiaoz.top/material/image.png" width = "36px" height = "36px" /></div>';
	    document.body.appendChild(div);
    }
    //显示上传按钮
    window.showImgurl = function(){
	    var up = layerstart;
	    up += '<iframe src = "https://imgurl.org/" width="100%" height="660px" frameborder="0"></iframe>';
	    up += layerend;
	    //$("body").append(up);
	    var div = document.createElement("div");
	    div.innerHTML = up;
		document.body.appendChild(div);
		
	    //$("#layer").show();
	    document.getElementById("layer").style.display = "block";
	    
	    //显示遮罩
	    keepout();
	    //居中显示层
	    layerCenter();
    }

    imgurl();
})();