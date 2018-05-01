# ImgURL
ImgURL是一款简单、纯粹的图床程序，使用PHP + SQLite 3开发，不需要复杂的配置，做到开箱即用。

### 待修复BUG
* 无法压缩`.jpeg`图片
* 统一将文件后缀改为小写
* 后台压缩功能存在BUG，压缩无效。

### 环境要求
* PHP >= 5.6
* 需要exif函数支持
* SQLite 3

### 开发计划
- [x] 图片上传与预览
- [x] 一键生成链接
- [x] 浏览与删除图片
- [x] 图片压缩
- [x] 图片鉴黄
- [ ] 图片水印
- [ ] API上传

### 安装
* 访问：<a href = "https://github.com/helloxz/imgurl/archive/master.zip" target = "_blank" rel = "nofollow">master.zip</a>下载最新版ImgURL程序，放到您的站点根目录并解压。
* 访问`http(s)://domain.com/check.php`获取配置信息，并记录下来。
* 修改`config.php`设置你自己的域名和密码，访问http(s)://domain.com/ 即可，就是这么简单。
* 更多设置请参考帮助文档：[https://doc.xiaoz.me/docs/imgurl](https://doc.xiaoz.me/docs/imgurl)


### 安全设置
* 配置完毕后测试功能没问题，请删除根目录的`check.php`
* Apache默认已经通过`.htaccess`文件来屏蔽数据库下载
* Nginx用户请在server段内添加如下配置，并重启Nginx
```
location ~* \.(db3)$ {  
    deny all;  
} 
```

### Demo
* [http://test.imgurl.org/](http://test.imgurl.org/) ，账号：`xiaoz`，密码：`xiaoz.me`

![](https://imgurl.org/upload/1804/3ccc55eeb47965c3.png)


### 联系我
* Blog：[https://www.xiaoz.me/](https://www.xiaoz.me/)
* QQ:337003006