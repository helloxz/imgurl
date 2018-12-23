<?php
/*
    name:各种设置、更新、删除操作
*/
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Set extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('update','',TRUE);
            //加载类
            $this->load->library('basic');
            //验证用户是否登录
            $this->basic->is_login(TRUE);
        }
        //更新站点设置
        public function site(){
            //var_dump($data);
            //接收表单数据
            $data['logo'] = $this->input->post('logo',TRUE);
            $data['title'] = $this->input->post('title',TRUE);
            $data['keywords'] = $this->input->post('keywords',TRUE);
            $data['description'] = $this->input->post('description',TRUE);
            $data['analytics'] = $this->input->post('analytics');
            //$data['comments']   =   $this->input->post('comments');
            

            $data = json_encode($data);
            
            
            //如果更新成功
            if($this->update->site('site_setting',$data)){
                $ref = $_SERVER["HTTP_REFERER"];
                echo '更新成功，3s后返回上一页！';
                header("Refresh:3;url=$ref");
            }
            else{
                echo '更新发生错误!';
                exit;
            } 
        }
        //更新上传限制
        public function uplimit(){
            $data['max_size'] = (int)$this->input->post('max_size',TRUE);
            $data['limit'] = (int)$this->input->post('limit',TRUE);

            $data = json_encode($data);
            
            //如果更新成功
            if($this->update->site('uplimit',$data)){
                $ref = $_SERVER["HTTP_REFERER"];
                echo '更新成功，3s后返回上一页！';
                header("Refresh:3;url=$ref");
            }
            else{
                echo '更新发生错误!';
                exit;
            } 
        }
        //更新tinypng设置
        public function tinypng(){
            $data['api1']   =   $this->input->post('api1',TRUE);
            $data['api2']   =   $this->input->post('api2',TRUE);
            @$switch =   $this->input->post('switch',TRUE);
            if($switch != 'on'){
                $switch = 'OFF';
            }
            else{
                $switch = 'ON';
            }
            
            $data = json_encode($data);
            //如果更新成功
            if($this->update->tinypng($data,$switch)){
                $ref = $_SERVER["HTTP_REFERER"];
                echo '更新成功，3s后返回上一页！';
                header("Refresh:3;url=$ref");
            }
            else{
                echo '更新发生错误!';
                exit;
            }
        }
        //更新moderate
        public function moderate(){
            //获取API key
            $data['api']   =   $this->input->post('api',TRUE);
            //获取开关
            @$switch =   $this->input->post('switch',TRUE);
            if($switch != 'on'){
                $switch = 'OFF';
            }
            else{
                $switch = 'ON';
            }
            //更新数据库
            //如果更新成功
            if($this->update->moderate($data['api'],$switch)){
                $ref = $_SERVER["HTTP_REFERER"];
                echo '更新成功，3s后返回上一页！';
                header("Refresh:3;url=$ref");
            }
            else{
                echo '更新发生错误!';
                exit;
            }
        }
        //更新存储引擎
        public function storage($engine){
            //获取API key
            $data['domains']   =   $this->input->post('domain',TRUE);
            $data['switch'] = 'ON';
            
            //更新数据库
            //如果更新成功
            if($this->update->storage($data,$engine)){
                $ref = $_SERVER["HTTP_REFERER"];
                echo '更新成功，3s后返回上一页！';
                header("Refresh:3;url=$ref");
            }
            else{
                echo '更新发生错误!';
                exit;
            }
        }
        //删除单张图片,需传入图片ID，及文件路径
        public function del_img(){
            //获取数据
            @$imgid  = $this->input->post('imgid',TRUE);
            @$path   = $this->input->post('path',TRUE);
            @$thumbnail_path = $this->input->post('thumbnail_path',TRUE);
            //加载数据库模型
            $this->load->model('delete','',TRUE);
            //从数据库中删除
            $this->delete->del_img($imgid);
            //从磁盘中删除
            $path = FCPATH.$path;
            $thumbnail_path = FCPATH.$thumbnail_path;
            //缩略图地址
            unlink($path);
            unlink($thumbnail_path);

            $re = array(
                "code"      =>  200,
                "msg"       =>  "删除成功！"
            );
            $re = json_encode($re);
            echo $re;
        }
        //取消图片可疑状态
        public function cancel($id){
            $id = (int)$id;

            $sql = "UPDATE img_images SET level = 'everyone' WHERE `id` = $id";
            $this->load->database();
            if($this->db->query($sql)){
                $this->suc_msg('操作成功！');
            }
        }
        //操作成功返回json
        protected function suc_msg($msg){
            $arr = array(
                "code"      =>  200,
                "msg"       =>  $msg
            );
            $info = json_encode($arr);
            echo $info;
        }
    }
?>