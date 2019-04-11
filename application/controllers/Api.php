<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Api extends CI_Controller{
        //获取图片数据
        public function found($type = 'all'){
            //允许跨域访问
            header("Access-Control-Allow-Origin: *");
            //返回json类型
            header('Content-Type:application/json; charset=utf-8');
            //加载模型
            $this->load->model('query','',TRUE);
            //查询图片
            $datas = $this->query->found_img($type,1);
            
            $json = json_encode($datas);
            echo $json;
        }
    }
?>