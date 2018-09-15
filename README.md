# ImgURL
ImgURL是一款简单、纯粹的图床程序，使用PHP + SQLite 3开发，不需要复杂的配置，开箱即用。

### 环境要求
* PHP >= 5.6
* 需要exif函数支持
* SQLite 3

### 安装
* 访问：<a href = "https://github.com/helloxz/imgurl/archive/master.zip" target = "_blank" rel = "nofollow">master.zip</a>下载最新版ImgURL程序，放到您的站点根目录并解压。
* 访问 `http(s)://domain.com/check.php` 获取配置信息，并记录下来。
* 修改 `config.php` 设置你自己的域名和密码，访问 `http(s)://domain.com/` 即可，就是这么简单。
* **更多设置请参考帮助文档：[https://doc.xiaoz.me/#/imgurl/](https://doc.xiaoz.me/#/imgurl/) （必看）**

### 开发计划
- [x] 图片上传与预览
- [x] 一键生成链接
- [x] 浏览与删除图片
- [x] 限制访客上传数量
- [x] 图片压缩
- [x] 图片鉴黄
- [x] API上传
- [x] 油猴脚本上传
- [ ] 图片水印



### 更新日志
#### v1.3 - 2018.09.11
* 新增粘贴上传（Ctrl + V）
* 期待已久的API上传
* 后台新增按时间筛选图片
* 优化“探索发现”，之前为随机显示12张，现在显示本月所有图片（流加载）
* 优化后台“看图模式”
* 修复一些BGU，优化CSS
* 增加ImgURL脚本，可在任意网页上传图片，参考：[https://www.xiaoz.me/archives/11038](https://www.xiaoz.me/archives/11038)

#### v1.2 - 2018.08.11
* 增加URL批量上传
* 去掉一些不必要的菜单
* 优化CSS样式
* 优化图片查看器
* 修复一些BUG


#### v1.1 - 2018.05.04
* 可上传至SM.MS图床
* 优化IP获取，及其它细节优化
* 修复一些BUG


### 安全设置
* 配置完毕后测试功能没问题，请删除根目录的`check.php`
* Apache默认已经通过`.htaccess`文件来屏蔽数据库下载
* Nginx用户请在server段内添加如下配置，并重启Nginx
```nginx
location ~* \.(db3)$ {  
    deny all;  
} 
location ~* ^/(temp|upload)/.*.(php|php5)$ {
    return 444;
}
```

### Demo
* [http://test.imgurl.org/](http://test.imgurl.org/) ，账号：`xiaoz`，密码：`xiaoz.me`

![](https://imgurl.org/upload/1804/3ccc55eeb47965c3.png)

### 获取捐赠版
ImgURL普通版和捐赠版功能上没有任何区别，不过您可以请xiaoz喝一杯咖啡或吃一顿午餐即可获得捐赠版。描下方二维码获取，并在付款说明填写您的网址。

![](https://imgurl.org/upload/1712/cb349aa4a1b95997.png)

#### 捐赠版说明
* 可提供首次安装及调试
* 可去除底部版权

#### 捐赠列表
* 2018-05-02 lackk.com 捐赠30元
* 2018-05-04 zip30.com 捐赠30元
* 2018-05-06 sopoy.com 捐赠30元
* 2018-05-06 tuchuang.app 捐赠60元
* 2018-05-15 coolsong.com 捐赠30元

### 鸣谢
ImgURL的诞生离不开以下开源项目。

* LayUI: [https://github.com/sentsin/layui](https://github.com/sentsin/layui)
* class.upload.php: [https://github.com/verot/class.upload.php](https://github.com/verot/class.upload.php)
* clipBoard.js: [https://github.com/baixuexiyang/clipBoard.js](https://github.com/baixuexiyang/clipBoard.js)

### 联系我
* Blog：[https://www.xiaoz.me/](https://www.xiaoz.me/)
* QQ:337003006
