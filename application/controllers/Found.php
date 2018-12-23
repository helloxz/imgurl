<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Found extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('query','',TRUE);
            //加载辅助函数
        }
        //探索发现页面
        public function index(){
            $siteinfo = $this->query->site_setting();
            $siteinfo = $siteinfo->values;
            $siteinfo = json_decode($siteinfo);

            $siteinfo->title = '探索发现 - '.$siteinfo->title;

            //查询图片信息,返回对象
            $data['imgs'] = $this->query->found(32);
            //查询域名
            $data['domain'] = $this->query->domain('localhost');

            //加载视图
            $this->load->view('user/header',$siteinfo);
            $this->load->view('user/found',$data);
            
            $this->load->view('user/footer');
        }
        //链接页面
        public function link($id){
            $id = strip_tags($id);
            $id = (int)$id;
            $siteinfo = $this->query->site_setting();
            $siteinfo = $siteinfo->values;
            $siteinfo = json_decode($siteinfo);

            //查询图片信息,返回对象
            $data['imgs'] = $this->query->found(32);
            //查询域名
            $data['domain'] = $this->query->domain('localhost');

            //加载视图
            $this->load->view('user/header',$siteinfo);
            $this->load->view('user/link',$data);
            
            $this->load->view('user/footer');
        }
        
    }
?>