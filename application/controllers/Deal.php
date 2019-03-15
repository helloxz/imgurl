<?php
/*
    name:图片处理控制器，图片鉴黄、图片压缩...
*/
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Deal extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();
            //设置超时时间为5分钟
            set_time_limit(300);
            //加载数据库类
            $this->load->database();
        }
        //图片压缩服务，传入images的id
        public function compress($id){
            //只有管理员才有压缩权限
            $this->load->library('basic');
            $this->basic->is_login(TRUE);
            $id = (int)$id;
            //生成SQL语句
            $sql = "SELECT a.`id`,a.`path`,a.`compression`,b.`mime` FROM img_images AS a INNER JOIN img_imginfo AS b ON a.imgid = b.imgid AND a.id = $id";
            $query = $this->db->query($sql);
            $row = $query->row_array();
            //图片绝对路径
            $path = FCPATH.$row['path'];

            //如果图片已经压缩过，就不要再压缩了
            if($row['compression'] == 1){
                $this->err_msg('此图片已经压缩！');
            }
            //检查MIME类型，仅压缩jpeg & png
            if(($row['mime'] != 'image/jpeg') && ($row['mime'] != 'image/png')){
                $this->err_msg('此图片类型不支持压缩！');
            }
            
            //先取出tinypng信息
            $sql = "SELECT * FROM img_options WHERE name = 'tinypng' LIMIT 1";
            $row = $this->db->query($sql)->row_array();

            //验证是否启用了压缩功能
            if($row['switch'] == 'OFF'){
                $this->err_msg('您没有启用压缩功能！');
            }
            //上面验证通过，继续执行
            //取出tinypng key
            $kyes = $row['values'];
            $kyes = json_decode($kyes);
            $i = 'api'.rand(1,2);
            $key = $kyes->$i;

            $this->load->library('image');
            $ret = $this->image->compress($path);
            if(empty($ret)) {
                $this->err_msg('压缩失败,请稍后重试！');
            }

            //最后别忘了更新数据库呀
            $sql = "UPDATE img_images SET compression = 1 WHERE `id` = $id";
            if($this->db->query($sql)){
                $this->suc_msg('压缩完成！');
            }
        }
        //图片鉴黄识别
        public function identify($id){
            $id = (int)$id;
            //生成SQL语句
            $sql = "SELECT a.id,a.path,a.level,b.domains FROM img_images AS a INNER JOIN img_storage AS b ON b.engine = 'localhost' AND a.id = $id";
            $query = $this->db->query($sql);
            $row = $query->row_array();
            $imgurl = $row['domains'].$row['path'];
            //echo $row['level'];
            //如果图片已经识别过，就不要再次识别了
            if(($row['level'] != 'unknown') && ($row['level'] != NULL)){
                $this->err_msg('此图片已经识别过！');
            }
            //继续执行
            $sql = "SELECT * FROM img_options WHERE name = 'moderate' LIMIT 1";
            $row = $this->db->query($sql)->row_array();
            //如果没有启用压缩功能
            if($row['switch'] == 'OFF'){
                $this->err_msg('未启用图片鉴黄识别！');
            }

            $apiurl = "https://www.moderatecontent.com/api/v2?key=".$row['values']."&url=".$imgurl;
            $curl = curl_init($apiurl);
            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36");
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            $html = curl_exec($curl);
            curl_close($curl);

            $html = json_decode($html);
            @$level = $html->rating_label;
            @$error_code = (int)$html->error_code;

            //最后更新数据库
            $sql = "UPDATE img_images SET level = '$level' WHERE `id` = $id";

            //如果执行成功才进行更新
            if($error_code === 0){
                //更新数据库
                $this->db->query($sql);
                if($level == 'adult'){
                    $arr = array(
                        "code"      =>  400,
                        "msg"       =>  '您的IP已记录，请不要上传违规图片！'
                    );
                    $arr = json_encode($arr);
                    echo $arr;
                }
                else{
                    $this->suc_msg('识别完成！');
                }
            }
            else{
                $this->err_msg('识别失败！');
            }
        }
        //批量识别图片
        public function identify_more(){
            $sql = "SELECT * FROM img_images WHERE (`level` = 'unknown') OR (`level` = NULL) ORDER BY `id` DESC LIMIT 5";
            //查询数据库
            $query = $this->db->query($sql);
            $result = $query->result();

            //循环识别图片
            foreach($result as $row){
                $this->identify($row->id);
            }
        }
        
        //返回错误码
        protected function err_msg($msg){
            $arr = array(
                "code"      =>  0,
                "msg"       =>  $msg
            );
            $arr = json_encode($arr);
            echo $arr;
            exit;
        }
        //成功，返回正确的状态码
        protected function suc_msg($msg){
            $arr = array(
                "code"      =>  200,
                "msg"       =>  $msg
            );
            $arr = json_encode($arr);
            echo $arr;
        }
    }
?>