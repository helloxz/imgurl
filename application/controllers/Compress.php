<?php
    /*
        name：图片压缩类
        anthor：xiaoz.me
        QQ:337003006
    */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Compress extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();
            //设置超时时间
            ini_set('max_execution_time','0');
        }
        //压缩单张图片,需要传入图片ID
        public function img($id){
            $t1 = microtime(true);

            //通过图片ID查询出图片基本信息
            $this->load->model('query','',TRUE);
            $img = $this->query->img($id);

            //如果图片没有压缩过,则调用压缩接口
            if($img->compression == 0){
                //获取图片完整路径
                $fullpath = FCPATH.$img->path;
                $this->load->library('image');
                $this->image->compress($fullpath);
                //更新数据库
                $this->load->model('update','',TRUE);
                $this->update->compress($id);
                $t2 = microtime(true);
                //计算执行时间
                $used_time = round($t2 - $t1).'s';
                $info = array(
                    "code"      =>  200,
                    "used_time" =>  $used_time,
                    "msg"   =>  'compressing.'
                );
                $info = json_encode($info);
                echo $info;
            }
            //图片已经压缩过情况
            else{
                $info = array(
                    "code"  =>  0,
                    "msg"   =>  'error：The image has been compressed！'
                );
                $info = json_encode($info);
                echo $info;
            }
        }
    } 
?>