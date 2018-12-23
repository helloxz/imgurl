<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Storage extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('query','',TRUE);
            //加载辅助函数
            $this->load->helper('basic');
            $info = $this->query->userinfo()->values;
            $info = json_decode($info);

            //验证用户是否登录
            is_login($info->username,$info->password);
        }
        //后台首页
        public function localhost(){
            $localhost = $this->query->storage('localhost');

            $data['admin_title']    =   '存储设置（localhost）';
            $data['domains']    =   $localhost->domains;
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/localhost',$data);
            $this->load->view('admin/footer');
        }
        
    }
?>