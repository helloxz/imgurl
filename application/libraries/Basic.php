<?php
    /*
        name:常用方法附属类
        author:xiaoz.me
        QQ:337003006
    */
    class Basic{
        protected $CI;

        //构造函数
        public function __construct(){
            $this->CI = & get_instance();
        }

        /*
            该函数检测用户是否已经登录，只需要一个参数
            如果参数为FALSE时，不会exit中断只执行，仅返回bool类型结果
            如果参数为TURE时，如果没有登录会exit终止执行
        */
        public function is_login($type = FALSE){
            //获取COOKIE信息
            @$user = $_COOKIE['user'];
            @$token = $_COOKIE['token'];

            //加载模型
            $this->CI->load->model('query','',TRUE);
            //加载辅助函数
            $this->CI->load->helper('basic');

            //如果查询成功
            if($this->CI->query->userinfo()){
                $userinfo = $this->CI->query->userinfo();
                $userinfo = json_decode($userinfo->values);

                $username = $userinfo->username;
                $password = $userinfo->password;
                //echo get_ip();
                $password = $username.$password.get_ua();
                $password = md5($password);


                //判断用户名是否正确,用户名密码正确的情况
                if(($user == $username) && ($token == $password)){
                    //判断需要的类型
                    return TRUE;
                }
                //用户名和密码不正确的情况下
                else{
                    if($type === FALSE){
                        
                        return false;
                    }
                    else{
                        echo "权限不足，请<a href = '/user/login'>重新登录</a> 。";
                        //清除cookies
                        setcookie("user", '', time()-3600,"/");
                        setcookie("token", '', time()-3600,"/");
                        exit;
                    }
                }
            }
            else{
                echo '数据库查询错误！';
                exit;
            }
        }
        //查询上传数量限制，需要传入访客IP
        public function uplimit($ip){
            
        }
        //CURL下载图片
        public function dl_pic($url){
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36");
            //伪造reffer
            curl_setopt ($curl, CURLOPT_REFERER, $url);            
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            #设置超时时间，最小为1s（可选）
            curl_setopt($curl , CURLOPT_TIMEOUT, 60);

            $html = curl_exec($curl);
            
            curl_close($curl);
            //返回数据
            return $html;
        }
        //网站数据分析
        public function analyze(){
            //图片总数
            $data['num'] = $this->CI->db->count_all("images");
            //本月总数
            $data['month']  =   $this->CI->query->count_num('month')->num;
            //今日总数
            $data['day']  =   $this->CI->query->count_num('day')->num;
            //管理员上传总数
            $data['admin']  =   $this->CI->query->count_num('admin')->num;
            //游客上传总数
            $data['visitor']  =   $this->CI->query->count_num('visitor')->num;
            //可疑图片总数
            $data['dubious']  =   $this->CI->query->count_num('dubious')->num;

            return $data;
        }
        //读取站点配置文件
        public function conf($arg = ''){
            //检查配置文件是否存在，并读取对应内容
            if(is_file(FCPATH."data/json/config.js")){
                $conf_path = FCPATH."data/json/config.js";
            }
            //配置文件不存在，读取默认配置
            else{
                $conf_path = FCPATH."data/json/config.simple.js";
            }
            $conf_path = str_replace("\\","/",$conf_path);
            //echo $conf_path;
            //读取配置文件内容
            $content = json_decode(file_get_contents($conf_path));
            
            //根据传入的参数来返回不同的数据
            switch ($arg) {
                case 'alert':
                    return $content->alert;
                    break;
                case 'info':
                    return $content->info;
                    break;
                default:
                    return $content;
                    break;
            }
        }
        //获取站点主域名
        public function domain(){
            $domain = $this->CI->query->get_domain();
            return $domain;
        }
    }
?>