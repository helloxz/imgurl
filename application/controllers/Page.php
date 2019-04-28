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
            //截取页面标题
            $pattern = '/<h1>(.*)<\/h1>/';
            preg_match($pattern,$content,$arr);
            //截取描述
            $description = mb_substr($content, 0, 180,'utf-8');
            $description = str_replace('#','',$description);
            //$description = str_replace('','',$description);
            $description = strip_tags($description);
            $description = trim($description);
            //echo $description;
            //echo $title;

            //$data['content'] = $content;
            //加载数据库视图
            $this->load->model('query','',TRUE);
            $data = $this->query->site_setting('1');
            $data->content = $content;
            $data->title = $arr[1];
            $data->description  = $description;
            //载入页面视图
            $this->load->view('/user/header',$data);
            $this->load->view('/user/page',$data);
            $this->load->view('/user/footer');
        }
    }
?>