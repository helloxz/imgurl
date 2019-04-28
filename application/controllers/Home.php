<?php
    /*
        name:首页
    */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Home extends CI_Controller{
        public function __construct(){
            parent::__construct();
            //检测是否已安装
            $lock_file = FCPATH.'data/install.lock';
            

            //如果锁文件不存在
            if(!is_file($lock_file)){
                header("location:/install/");
                exit;
            }
        }
        public function index(){
            //加载数据库模型
            $this->load->model('query','',TRUE);
            $siteinfo = $this->query->site_setting();
            //读取配置文件内容
            $this->load->library("basic");
            $conf = $this->basic->conf("info");
            
            
            $siteinfo = json_decode($siteinfo->values);
            $siteinfo->info = $conf->index_info;
            //echo $siteinfo->title;
            //$data['title']  =   '图片上传';
            $this->load->view('user/header.php',$siteinfo);
            $this->load->view('user/home.php',$siteinfo);
            $this->load->view('user/footer.php');
        }
        //首页多图上传
        public function multiple(){
            //加载数据库模型
            $this->load->model('query','',TRUE);
            $siteinfo = $this->query->site_setting();
            $siteinfo = json_decode($siteinfo->values);
            //echo $siteinfo->title;
            //$data['title']  =   '图片上传';
            $this->load->view('user/header.php',$siteinfo);
            $this->load->view('user/multiple.php');
            $this->load->view('user/footer.php');
        }
        //更新日志
        public function log(){
            //加载数据库模型
            $this->load->model('query','',TRUE);
            $siteinfo = $this->query->site_setting();
            $siteinfo = json_decode($siteinfo->values);
            //echo $siteinfo->title;
            //$data['title']  =   '图片上传';
            $siteinfo->title = "ImgURL更新日志";
            $this->load->view('user/header.php',$siteinfo);
            $this->load->view('user/log.php');
            $this->load->view('user/footer.php');
        }
        //站点地图页面
        public function sitemap(){
            //页面路径
            $page_path = FCPATH.'data/pages';
            $pages = scandir($page_path);
            
            foreach ($pages as $page) {
                if(($page === '.') OR ($page === '..')){
                    continue;
                }
                $page = str_replace('.md','',$page);
                echo "<li><a href = '/page/{$page}'>{$page}</a></li>";
            }
            
            //加载数据库模型
            $this->load->view('user/sitemap.php');
        }
    }
?>