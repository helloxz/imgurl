<?php
    //安装ImgURL
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Install extends CI_Controller {
        public function index(){
            //检查是否已经安装
            $this->is_install();
            $setup = (int)$_GET['setup'];
            $data['env'] = $this->check('full');
            $data['sum'] = $this->check('part');
            //var_dump($data['sum']);
            $data['title']  = "ImgURL安装向导";
            $data['logo']   = "/static/images/logo.png";
            
            //安装步骤
            switch ($setup) {
                //安装步骤1
                case 1:
                    $this->load->view('user/header.php',$data);
                    $this->load->view('user/install1.php',$data);
                    $this->load->view('user/footer.php');
                    break;
                //安装步骤2
                case 2:
                    //获取网站域名
                    $data['domain'] = $this->get_domain();
                    //加载视图
                    $this->load->view('user/header.php',$data);
                    $this->load->view('user/install2.php',$data);
                    $this->load->view('user/footer.php');
                    break;
                case 3:
                    //获取域名
                    @$info['domain'] = $this->input->post('domain',TRUE);
                    //获取用户名
                    @$info['user'] = $this->input->post('user',TRUE);
                    //获取密码
                    @$info['pass1'] = $this->input->post('pass1',TRUE);
                    @$info['pass2'] = $this->input->post('pass2',TRUE);
                    //验证信息
                    $this->verify($info,'domain');
                    $this->verify($info,'user');
                    $this->verify($info,'pass');
                    $this->verify($info,'pass2');
                    //开始安装ImgURL
                    $this->setup($info);
                    //加载视图
                    $this->load->view('user/header.php',$data);
                    $this->load->view('user/install3.php',$data);
                    $this->load->view('user/footer.php');
                    break;
                default:
                    header("location:/install/?setup=1");
                    break;
            }
        }

        //环境检测
        protected function check($type){
            //检测通过
            $yes = '<span style = "color:green;">通过！</span>';
            $no = '<span style = "color:red;">未通过！</span>';
            //获取组件信息
            $ext = get_loaded_extensions();
            //PHP版本信息
            $env['php'] = array(
                "name"      =>  'PHP',
                "requir"    =>  'PHP >= 5.6',
                "info"      =>  PHP_VERSION,
                "result"    =>  is_php('5.6') ? $yes : $no
            );
            //PDO_SQLite
            $env['sqlite'] = array(
                "name"      =>  'PDO_SQLite',
                "requir"    =>  '必须支持',
                "info"      =>  array_search('pdo_sqlite',$ext) ? 'Yes':'No',
                "result"    =>  array_search('pdo_sqlite',$ext) ? $yes : $no
            );
            //GD2
            $env['gd'] = array(
                "name"      =>  'GD2',
                "requir"    =>  '必须支持',
                "info"      =>  array_search('gd',$ext) ? 'Yes':'No',
                "result"    =>  array_search('gd',$ext) ? $yes : $no
            );
            //imagick
            $env['imagick'] = array(
                "name"      =>  'ImageMagick',
                "requir"    =>  '可选',
                "info"      =>  array_search('imagick',$ext) ? 'Yes':'No',
                "result"    =>  array_search('imagick',$ext) ? $yes : $no
            );
            //fileinfo
            $env['fileinfo'] = array(
                "name"      =>  'Fileinfo',
                "requir"    =>  '必须支持',
                "info"      =>  array_search('fileinfo',$ext) ? 'Yes':'No',
                "result"    =>  array_search('fileinfo',$ext) ? $yes : $no
            );
            //检查目录是否可写
            $env['data'] = array(
                "name"      =>  '/data',
                "requir"    =>  '可写',
                "info"      =>  is_writable(FCPATH.'data') ? 'Yes':'No',
                "result"    =>  is_writable(FCPATH.'data') ? $yes : $no
            );
            $env['upload'] = array(
                "name"      =>  '/imgs',
                "requir"    =>  '可写',
                "info"      =>  is_writable(FCPATH.'imgs') ? 'Yes':'No',
                "result"    =>  is_writable(FCPATH.'imgs') ? $yes : $no
            );

            //遍历结果
            if($type == 'part'){
                //检测不通过
                foreach($env as $value){
                    //当检测到ImageMagick的时候直接让其通过
                    if($value['name'] == 'ImageMagick'){
                        
                    }
                    elseif($value['result'] == $no){
                        return FALSE;
                        exit;
                    }
                }
            }
            else{
                return $env;
            }
        }
        //获取网站域名
        protected function get_domain(){
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
            $domain = $protocol.$_SERVER['SERVER_NAME'].$port;
            //$domain = str_replace("install.php?setup=2","",$domain);
            return $domain;
        }
        //验证函数
        protected function verify($data,$type){
            switch ($type) {
                //检查用户名
                case 'user':
                    $pattern = '/^[a-zA-Z0-9]+$/';
                    if($data['user'] == ''){
                        echo '请填写用户名！';
                        exit;
                    }
                    if(!preg_match($pattern,$data['user'])){
                        echo '用户名格式有误！';
                        exit;
                    }
                    break;
                case 'pass':
                    $pattern = '/^[a-zA-Z0-9!@#$%^&*.]+$/';
                    if(!preg_match($pattern,$data['pass1'])){
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
        //安装函数
        protected function setup($data){
            //默认数据库路径
            $default_db = FCPATH."data/imgurl-simple.db3";
            //数据库路径
            $db_path = FCPATH."data/imgurl.db3";
            //锁文件
            $lock_file = FCPATH."data/install.lock";
            //用户密码
            $password = md5($data['pass2'].'imgurl');
            //用户信息，json格式
            $user_values = array(
                "username"      =>  $data['user'],
                "password"      =>  $password
            );
            $user_values = json_encode($user_values);

            //拷贝数据库
            copy($default_db,$db_path);
            //写入默认数据
            //连接数据库
            $this->load->database();
            //用户信息
            $userinfo = array(
                'name'      => 'userinfo',
                'values'    =>  $user_values
            );
            
            //本地存储信息
            $local_storage = array(
                "engine"    =>  "localhost",
                "domains"   =>  $data['domain'],
                "switch"    =>  'ON'
            );
            //站点地址
            $site_url = array(
                "name"      =>  'site_url',
                "values"    =>  $data['domain']
            );
            //$where = "name = 'site_url'";
            
            // var_dump($this->db->update_string('options', $site_url, $where));
            // exit;
            // var_dump($site_url);
            // exit;
            //设置用户信息
            $this->db->insert('options', $userinfo);
            $this->db->insert('options', $site_url);
            
            //设置默认存储
            $this->db->insert('storage', $local_storage);

            //创建锁文件
            $myfile = fopen($lock_file, "w") or die("Unable to open file!");
            $txt = "ImgURL";
            fwrite($myfile, $txt);
            fclose($myfile);

            return TRUE;
        }
        //检查是否已经安装过
        protected function is_install(){
            //锁文件
            $lock_file = FCPATH."data/install.lock";
            if(is_file($lock_file)){
                header("location:/");
                exit;
            }
        }
    }
?>