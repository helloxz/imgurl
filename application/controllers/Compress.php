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
                $this->tinypng($fullpath);
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
        //请求tinypng压缩接口,传入图片完整路径
        protected function tinypng($path){

            //tinypng API地址
            $api_url = "https://api.tinify.com/shrink";
            $data = file_get_contents($path);
            //$post_data = array ("username" => "bob","key" => "12345");
            //$ch = curl_init();
            $ch = curl_init();
            $user = "api";
            $pass = "F8rNr5lh25WYcOECQvAqvcilBMAkhtIM";
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
            // post数据
            curl_setopt($ch, CURLOPT_POST, 1);
            // post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $output = curl_exec($ch);
            curl_close($ch);
            //打印获得的数据
            $data = json_decode($output);
            //获取图片压缩后的URL
            $url =  $data->output->url;
            //保存图片
            $this->save($url,$path);
        }
        //传递图片URL，并保存文件
        protected function save($url,$path){
            //获取图片数据并保存
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36");
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            #设置超时时间，最小为1s（可选）
            #curl_setopt($curl , CURLOPT_TIMEOUT, 1);

            $filedata = curl_exec($curl);
            curl_close($curl);

            //将图片数据覆盖源文件
            file_put_contents($path,$filedata);
        }
    } 
?>