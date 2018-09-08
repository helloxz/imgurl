/*!
 *
 * @author: diandian & alanzhang
 * @date: 2016/8/19
 * @overview: [截屏后，按粘贴快捷键ctrl+v上传，]
 * @兼容性说明： IE11，Firefox，chrome
 *
 */


'use strict';

(function(root, factory){
    if (typeof define === 'function' && define.amd) {
        // AMD
        define([], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory();
    } else {
        // Browser globals (root is window)
        root.ctrlVUtil = factory();
    }
}(this, function(){

    function ctrlVUtil(option){

        // 鼠标在该元素上，使用ctrl+v键时上传
        this.targetElement = null;

        // 用于响应paste事件的元素，如果页面不传递，则创建该元素，并位于targetElement前面
        this.uploadInput = null;

        // 默认的上传地址
        this.uploadUrl = "http://www.oa.com/screenshot/create-file";

        // 对于读取的图片base64，前缀为data:image/jpg;base64,base64content
        // isCompleteImg为false则去掉前缀直接上传内容部分，为true则上传完整的base64字符串
        this.isCompleteImg = false;

        var that = this;

        // 合并参数
        that.mixinConfig(option);

        // 鼠标移入和点击时上传，移出时失焦
        that.targetElement.addEventListener("mouseover", function() {
            that.uploadInput.focus();
        });

        that.targetElement.addEventListener("click", function() {
            that.uploadInput.focus();
        });

        // 移除鼠标则input失去交掉
        that.targetElement.addEventListener("mouseleave", function() {
            that.uploadInput.blur();
        });

        // 监听paste的事件
        that.uploadInput.addEventListener('paste', function(e) {
            that.handlePaste(e);
        });

    }

    /**
     * [mixinConfig 整合参数]
     * @param  {[type]} option [description]
     * @return {[type]}        [description]
     */
    ctrlVUtil.prototype.mixinConfig = function(option){
        this.targetElement = option.targetElement || document.querySelector(".js-upload");
        this.uploadInput =  this.createInputTarget();

        this.isCompleteImg = "isCompleteImg" in option ? option.isCompleteImg : this.isCompleteImg;

        // 上传地址
        this.uploadUrl = option.uploadUrl || this.uploadUrl;

        // 除了图片内容以外的其他数据
        this.data = option.data;

        // 上传成功时的回调函数
        this.success = option.success || function(data) {
            console.log(data);
        };

        // 上传失败时的回调函数
        this.error = option.error || function(error) {
            console.log(error);
        };
    };

    /**
     * [createInputTarget 创建div元素，用于响应paste事件]
     * @return {Element} [description]
     */
    ctrlVUtil.prototype.createInputTarget = function() {
        var imgContinaer = document.createElement("div");

        // 使其不可见
        imgContinaer.style.cssText = "border:none;margin:0;padding:0;font-size: 0;height:1px;width:1px;opacity:0;position:fixed;z-index:-1;";

        // 让其可编辑，能响应paste事件
        imgContinaer.contentEditable = true;
        imgContinaer.class = "ui-ctrlv-uploadInput";

        // 插入targeElementn前面
        this.targetElement.parentNode.insertBefore(imgContinaer, this.targetElement);

        return imgContinaer;
    };

    /**
     * [handlePaste 处理粘贴行为]
     * @param  {Event} e [粘贴事件]
     * @return {[type]}   [description]
     */
    ctrlVUtil.prototype.handlePaste = function(e){

        var that = this;

        // webkit 内核支持items方法
        if (e && e.clipboardData && e.clipboardData.items) {

            // 获取item
            var item = e.clipboardData.items[0],
                that = this;

            if (item.type.indexOf('image') != -1) {

                var blob = item.getAsFile();

                // 创建读取对象
                var fileReader = new FileReader();

                // 将文件读取为字符串
                fileReader.readAsDataURL(blob);

                fileReader.addEventListener('load', function(e) {
                    var file = e.target.result;
                    that.send(file);
                }, false);

            } else {

                that.alertMsg("请粘贴image类型");

            }

        // firefox无法使用items方法，在粘贴时，图片会作为img标签插入targetElement中，
        // 获取img标签的src内容进行上传
        } else {

            setTimeout(function() {
                var $img = that.uploadInput.querySelector("img");

                if ($img) {
                    that.send($img.src);
                } else {
                    that.alertMsg("浏览器不支持剪贴板操作");
                    return;
                }

            }, 200);
        }


    };

    /**
     * [send 上传图片]
     * @param  {string} imgcontent [图片内容base64格式]
     * @return {[type]}            [description]
     */
    ctrlVUtil.prototype.send = function(imgcontent) {
        var that = this;

        that.uploadInput.innerHTML = "";

        var data = that.data || {};

        // 根据sCompleteImg来决定上传的是整体的base64字符串还是仅仅为内容部分
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

    // 暴露构造函数
    return ctrlVUtil;
}));



