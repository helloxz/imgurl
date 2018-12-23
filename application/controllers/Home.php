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
            $siteinfo = json_decode($siteinfo->values);
            //echo $siteinfo->title;
            //$data['title']  =   '图片上传';
            $this->load->view('user/header.php',$siteinfo);
            $this->load->view('user/home.php');
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
    }
?>