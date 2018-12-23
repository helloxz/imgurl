<?php
    // 该控制器删除图片
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Del extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('query','',TRUE);
            //加载类
            $this->load->library('basic');
            //检测是否登录
            $this->basic->is_login(TRUE);
            
        }
        //根据img_images ID删除图片
        public function id($id){
            @$id = (int)$id;

            $img = $this->query->img_id($id);
            //加载数据库模型
            $this->load->model('delete','',TRUE);
            //从数据库中删除
            $this->delete->del_img($img->imgid);
            //从磁盘中删除
            $path = FCPATH.$img->path;
            $thumbnail_path = FCPATH.$img->thumb_path;
            //缩略图地址
            unlink($path);
            unlink($thumbnail_path);

            $re = array(
                "code"      =>  200,
                "id"        =>  $id,
                "msg"       =>  "删除成功！"
            );
            $re = json_encode($re);
            echo $re;
        }
    }
?>