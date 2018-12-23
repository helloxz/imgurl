<?php
    /*
        name:页面
    */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Page extends CI_Controller{
        public function _remap($name){
            //获取URI
            $name = strip_tags($name);
            
            //查找文件
            $pagefile = FCPATH.'data/pages/'.$name.'.md';
            $pagefile = str_replace('\\','/',$pagefile);
            
            //如果文件不存在，直接返回404
            if(!is_file($pagefile)){
                show_404();
            }
            //读取文件内容
            $content = file_get_contents($pagefile);
            //载入markdown解析类
            $this->load->library("parsedown");
            $content = $this->parsedown->text($content);

            //$data['content'] = $content;
            //加载数据库视图
            $this->load->model('query','',TRUE);
            $data = $this->query->site_setting('1');
            $data->content = $content;
            //载入页面视图
            $this->load->view('/user/header',$data);
            $this->load->view('/user/page',$data);
            $this->load->view('/user/footer');
        }
    }
?>