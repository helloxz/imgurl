<?php
    class Install{
        public $homedir;
        public $domain;
        //构造函数
        public function __construct(){
            //获取项目绝对路径
            $thedir = __DIR__;
            $homedir = str_replace("\\","/",$thedir);
            $homedir = str_replace("functions/class","",$homedir);
            $this->homedir = $homedir;

            //获取当前域名
            //获取当前端口
            $port = $_SERVER["SERVER_PORT"];
            //对端口进行判断
            switch ( $port )
            {
                case 80:
                    $protocol = "http://";
                    $port = '';
                    break;	
                case 443:
                    $protocol = "https://";
                    $port = '';
                    break;
                default:
                    $protocol = "http://";
                    $port = ":".$port;
                    break;
            }
            $uri =  $_SERVER["REQUEST_URI"];
            $uri = str_replace("check.php","",$uri);
            //组合为完整的URL
            $domain = $protocol.$_SERVER['SERVER_NAME'].$port.$uri;
            $domain = str_replace("install.php?setup=2","",$domain);
            $this->domain = $domain;
        }
        //检查环境是否符合条件
        public function check(){
            $homedir = $this->homedir;
            
            //echo $homedir.'db';
            //检查根目录是否可写，结果写入到一个数组
            //echo $thedir;
            $checkarr['home']   = is_writable($homedir);
            if($checkarr['home']){
                $statusarr['home'] = '通过';
                
            }
            else{
                $statusarr['home'] = '<span style = "color:red;">目录不可写！</span>';
                
            }
            $checkarr['db']     = is_writable($homedir.'db');
            if($checkarr['db']){
                $statusarr['db'] = '通过';
            }
            else{
                $statusarr['db'] = '<span style = "color:red;">目录不可写！</span>';
                
            }
            //检测组建是否支持
            $ext = get_loaded_extensions();
            if(array_search('pdo_sqlite',$ext)){
                $statusarr['pdo'] = '支持';
            }
            else{
                $statusarr['pdo'] = '<span style = "color:red;">不支持！</span>';
            }
            //return $checkarr;
            return $statusarr;
        }
        //获取站点信息
        public function info(){
            $homedir = $this->homedir;

            $info = array(
                "homedir"   =>  $this->homedir,
                "domain"    =>  $this->domain
            );

            return $info;
        }
        //验证函数
        protected function verify($data,$type){
            switch ($type) {
                //检查用户名
                case 'user':
                    $pattern = '/^[a-zA-Z0-9]+$/';
                    if($data == ''){
                        echo '请填写用户名！';
                        exit;
                    }
                    if(!preg_match($pattern,$data)){
                        echo '用户名格式有误！';
                        exit;
                    }
                    break;
                case 'pass':
                    $pattern = '/^[a-zA-Z0-9!@#$%^&*.]+$/';
                    if(!preg_match($pattern,$data)){
                        echo '密码格式有误！';
                        exit;
                    }
                    break;
                case 'pass2':
                    $pass1 = $data['pass1'];
                    $pass2 = $data['pass2'];
                    
                    if($pass1 != $pass2){
                        echo '两次密码不一致！';
                        exit;
                    }
                    break;
                case 'domain':
                    $domain = $data['domain'];
                    if(!filter_var($domain, FILTER_VALIDATE_URL)){
                        echo '域名格式有误！（需要包含https://）';
                        exit;
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
        //安装
        public function setup($data){
            $homedir = $this->homedir;
            $dbpath = $this->homedir.'db/';
            $user = $data['user'];
            $pass1 = $data['pass1'];
            $pass2 = $data['pass2'];

            
            $this->verify($user,'user');
            $this->verify($pass1,'pass');
            $this->verify($data,'pass2');
            $this->verify($data,'domain');

            //复制一份数据库
            copy($dbpath."imgurl-simple.db3",$dbpath."imgurl.db3");
            //复制一份配置文件
            if(copy($homedir."config-simple.php",$homedir."config.php")){
                $configdir = $homedir."config.php";

                $myfile = fopen($homedir."config.php", "r") or die("Unable to open file!");

                
                $content = fread($myfile,filesize($configdir));
                //执行替换
                $content = str_replace("imguser",$user,$content);
                $content = str_replace("imgpass",$pass2,$content);
                $content = str_replace("homedir",$data['homedir'],$content);
                $content = str_replace("https://imgurl.org/",$data['domain'],$content);

                //var_dump($content);

                //写入文件
                $myfile = fopen($homedir."config.php", "w+") or die("Unable to open file!");
                

                fwrite($myfile, $content);
                //关闭
                fclose($myfile);
                //更名安装文件
                rename($homedir."install.php",$homedir."install.php.bak");
            }
            
        }
    }
?>