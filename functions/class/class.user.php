<?php
    error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
    // 载入配置文件
    include_once("../config.php");

    class User{
        var $config;
        var $database;

        //构造函数
        public function __construct($config,$database){
            $this->config = $config;
            $this->database = $database;
        }

        // 用户登录，两个参数，一个是用户输入，一个是配置文件里面的用户信息
        function login($user,$admin){
            
            // 用户输入的信息进行md5加密和对比
            $pw1 = md5($user['user'].$user['password']);
            $pw2 = md5($admin['user'].$admin['password']);
            

            // 判断用户名密码是否正确
            if($pw1 != $pw2){
                echo '用户名或密码不正确！';
                setcookie("user", '', time()-3600,"/");
                setcookie("password", '', time()-3600,"/");
                exit;
            }
            else{
                $password = md5("imgurl".$admin['password']);
                //生成cookie
                setcookie("user", $user['user'], time()+3600 * 24 * 30,"/");
                setcookie("password", $password, time()+3600 * 24 * 30,"/");
                echo "<script>window.location.href = './index.php'</script>";
                exit;
            }
        }
        //判断用户状态
        function check($userinfo){
            //配置文件里面的用户信息
            $user1 = $userinfo['user'].md5("imgurl".$userinfo['password']);
            // echo $user1;
            //COOKIES里面的信息
            $user2 = $_COOKIE['user'].$_COOKIE['password'];
            
            //如果两者信息相符，说明已登录
            if($user1 == $user2) {
                return'islogin';
                exit;
            }
            else{
                return 'nologin';
                setcookie("user", '', time()-3600,"/");
                setcookie("password", '', time()-3600,"/");
                exit;
            }
        }
        //检查某张图片是否已经上传
        function isupload($path){
            $num = $this->database->count("imginfo",["path"   =>  $path]);

            //如果图片已经上传过，直接返回图片信息
            if($num >=1) {
                $info = $this->database->get("imginfo","*",["path"  =>  $path]);
                $imgurl = $this->config['domain'].$path;
                //返回json数据
                $redata = array(
                    "code"      =>  1,
                    "id"        =>  $info['id'],
                    "url"       =>  $imgurl,
                    "width"     =>  0,
                    "height"    =>  0
                );
                echo $redata = json_encode($redata);
                exit;
            }
        }
        //限制访客上传数量
        function limitnum(){
            //获取访客IP
            $ip = $_SERVER['REMOTE_ADDR'];
            //获取当前时间
            $date = date('Y-m-d',time());
            //获取配置文件限额
            $limit = $this->config['limit'];
            //获取用户上传目录
            $dir = $this->config['userdir'];
            //查询数据库统计数量
            $database = $this->database;
            $num = $database->count("imginfo",[
                "date"      =>  $date,
                "ip"        =>  $ip,
                "dir"       =>  $dir
            ]);
            
            if($num >= $limit) {
                $redata = array(
                    "code"      =>  0,
                    "msg"       =>  "上传达到限制！"
                );
                echo $redata = json_encode($redata);
                exit;
            }
        }
        //获取访客真实IP
        function getip(){
            if (getenv('HTTP_CLIENT_IP')) { 
                    $ip = getenv('HTTP_CLIENT_IP'); 
                } 
                elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
                    $ip = getenv('HTTP_X_FORWARDED_FOR'); 
                } 
                elseif (getenv('HTTP_X_FORWARDED')) { 
                    $ip = getenv('HTTP_X_FORWARDED'); 
                } 
                elseif (getenv('HTTP_FORWARDED_FOR')) { 
                    $ip = getenv('HTTP_FORWARDED_FOR'); 
            
                } 
                elseif (getenv('HTTP_FORWARDED')) { 
                    $ip = getenv('HTTP_FORWARDED'); 
                } 
                else { 
                    $ip = $_SERVER['REMOTE_ADDR']; 
                } 
                return $ip; 
        }
       	//判断文件MIME类型
       	function mime($path){
	       	$mime = mime_content_type($path);
	       	switch ( $mime )
	       	{
	       		case 'image/gif':
	       		case 'image/png':
	       		case 'image/jpeg':
	       		case 'image/bmp':
	       			return true;
	       			break;		
	       		default:
	       			return false;
	       			break;
	       	}
       	}
    }

    //自动初始化完成一些基础操作
    $basis  =   new User($config,$database);
?>