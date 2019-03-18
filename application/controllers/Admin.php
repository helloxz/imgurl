<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('query','',TRUE);
            //加载辅助函数
            $this->load->helper('basic');
            //加载常用类
            $this->load->library('basic');
            $info = $this->query->userinfo()->values;
            $info = json_decode($info);

            //验证用户是否登录
            $this->basic->is_login(TRUE);
            //is_login($info->username,$info->password);
        }
        //后台首页
        public function index(){
            $this->load->library('basic');
            $data = $this->basic->analyze();
            $data['admin_title']    =   '后台首页';
            
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/index');
            $this->load->view('admin/footer');
        }
        //URL上传
        public function urlup(){
            $data['admin_title']    =   'URL上传';
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/urlup');
            $this->load->view('admin/footer');
        }
        
    }
?>