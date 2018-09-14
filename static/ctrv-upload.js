'use strict';
(function(root, factory){
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof exports === 'object') {
        module.exports = factory();
    } else {
        root.ctrlVUtil = factory();
    }
}(this, function(){
    function ctrlVUtil(option){
        this.targetElement = null;
        this.uploadInput = null;
        this.uploadUrl = "http://www.oa.com/screenshot/create-file";
        this.isCompleteImg = false;
        var that = this;
        that.mixinConfig(option);
        that.targetElement.addEventListener("mouseover", function() {
            that.uploadInput.focus();
        });
        that.targetElement.addEventListener("click", function() {
            that.uploadInput.focus();
        });
        that.targetElement.addEventListener("mouseleave", function() {
            that.uploadInput.blur();
        });
        that.uploadInput.addEventListener('paste', function(e) {
            that.handlePaste(e);
        });
    }
    ctrlVUtil.prototype.mixinConfig = function(option){
        this.targetElement = option.targetElement || document.querySelector(".js-upload");
        this.uploadInput =  this.createInputTarget();
        this.isCompleteImg = "isCompleteImg" in option ? option.isCompleteImg : this.isCompleteImg;
        this.uploadUrl = option.uploadUrl || this.uploadUrl;
        this.data = option.data;
        this.success = option.success || function(data) {
            console.log(data);
        };
        this.error = option.error || function(error) {
            console.log(error);
        };
    };
    ctrlVUtil.prototype.createInputTarget = function() {
        var imgContinaer = document.createElement("div");
        imgContinaer.style.cssText = "border:none;margin:0;padding:0;font-size: 0;height:1px;width:1px;opacity:0;position:fixed;z-index:-1;";
        imgContinaer.contentEditable = true;
        imgContinaer.class = "ui-ctrlv-uploadInput";
        this.targetElement.parentNode.insertBefore(imgContinaer, this.targetElement);
        return imgContinaer;
    };
    ctrlVUtil.prototype.handlePaste = function(e){
        var that = this;
        if (e && e.clipboardData && e.clipboardData.items) {
            var item = e.clipboardData.items[0],
                that = this;
            if (item.type.indexOf('image') != -1) {
                var blob = item.getAsFile();
                var fileReader = new FileReader();
                fileReader.readAsDataURL(blob);
                fileReader.addEventListener('load', function(e) {
                    var file = e.target.result;
                    that.send(file);
                }, false);
            } else {
                layer.msg('请粘贴image类型！');
            }
        } else {
            setTimeout(function() {
                var $img = that.uploadInput.querySelector("img");
                if ($img) {
                    that.send($img.src);
                } else {
                    layer.msg('当前浏览器不支持剪贴板操作！');
                    return;
                }
            }, 200);
        }
    };
    ctrlVUtil.prototype.send = function(imgcontent) {
	    layer.load();
        var that = this;
        that.uploadInput.innerHTML = "";
        var data = that.data || {};
        data.content = this.isCompleteImg ? imgcontent : imgcontent.split(';')[1].split(',')[1];
        var xhr = new XMLHttpRequest();
        xhr.open("post",that.uploadUrl,true);
        xhr.onreadystatechange = function(e) {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var ret = JSON.parse(xhr.responseText);
                    that.success && that.success(ret);
                } else {
                    that.error && that.error(e, xhr);
                }
            }
        };
        xhr.onerror = function(e) {
            that.error && that.error(e, xhr);
        };
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var dataString = [];
        for(var key in data){
            dataString.push(key+"="+encodeURIComponent(data[key]));
        }
        xhr.send(dataString.join("&"));
    };
    ctrlVUtil.prototype.alertMsg = function(content){
        alert(content);
    }
    return ctrlVUtil;
}));