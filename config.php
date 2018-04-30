<?php
    //项目绝对路径
    define("APP","D:/wwwroot/imgurl/");
    
    //载入数据库类
    include_once(APP."functions/class/Medoo.php");

    $config = array(
        "domain"    =>  "http://localhost/imgurl/", //站点地址
        "user"      =>  "xiaoz",                    //管理员账号
        "password"  =>  "xiaoz.me",                 //管理员密码
        "limit"		=>	5,							//游客上传数量限制
        "watermark"	=>	"imgurl.org",				//图片文字水印
        "userdir"   =>  "temp",                     //游客上传目录，一般不用做修改
        "admindir"  =>  "upload",                   //管理员上传目录，一般不用做修改
        "datadir"   =>  APP."db/imgurl.db3"       	//数据库路径，一般不用做修改
    );
    // TinyPNG压缩图片
    $tinypng = array(
        "option"    =>  false,
        "key"       =>  array(
        	"xxx",				//TinyPNG API KEY，支持填写多行key
        	"xxx"				//如果只有一个key，请删除此行
        )
    );
    //ModerateContent 图片鉴黄，请参考帮助文档：https://doc.xiaoz.me/docs/imgurl/imgurl-jh
    $ModerateContent = array(
        "option"    =>  false,
        "key"       =>  "xxx"
    );

	//初始化Medoo
    use Medoo\Medoo;
    $database = new medoo([
        'database_type' => 'sqlite',
        'database_file' => $config['datadir']
    ]);
?>