<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Setting extends CI_Controller{
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
        //站点设置
        public function site(){  
           $siteinfo = $this->query->site_setting();
           $siteinfo = json_decode($siteinfo->values);
           
            //页面标题
            $siteinfo->admin_title  =   '站点设置';
            
            //加载视图
            $this->load->view('admin/header',$siteinfo);
            $this->load->view('admin/left');
            $this->load->view('admin/site');
            $this->load->view('admin/footer');
        }
        //上传限制
        public function uplimit(){

            $siteinfo = $this->query->option('uplimit');
            
            $siteinfo = json_decode($siteinfo->values);
            if($siteinfo->limit != 0){
                $switch = 'checked';
            }
            else{
                $switch = '';
            }
            //页面标题
            $siteinfo->admin_title  =   '上传限制';
            $siteinfo->switch = $switch;
            //var_dump($siteinfo);
            //加载视图
            $this->load->view('admin/header',$siteinfo);
            $this->load->view('admin/left');
            $this->load->view('admin/uplimit');
            $this->load->view('admin/footer');
        }
        //图片压缩
        public function compress(){
            //页面标题
            $data['admin_title']  =   '图片压缩';

            //加载模型
            $this->load->model('query','',TRUE);
            
            $tinypng = $this->query->option('tinypng');
            $data['switch'] = $tinypng->switch;
            if($data['switch'] == 'OFF'){
                $data['switch'] = '';
            }
            else{
                $data['switch'] = 'checked';
            }
            
            $data['values'] = json_decode($tinypng->values);

            //var_dump($data['values']->api1);
            //exit;
            
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/tinypng',$data);
            $this->load->view('admin/footer');
        }
        //图片鉴黄
        public function identify(){
            //页面标题
            $data['admin_title']  =   '图片鉴黄';
            //加载模型
            $this->load->model('query','',TRUE);
            $moderate = $this->query->option('moderate');

            $data['switch'] = $moderate->switch;
            $data['values'] = $moderate->values;
            if($data['switch'] == 'OFF'){
                $data['switch'] = '';
            }
            else{
                $data['switch'] = 'checked';
            }
            
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/identify');
            $this->load->view('admin/footer');
        }
    }
?>