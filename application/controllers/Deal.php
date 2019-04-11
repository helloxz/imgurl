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
            //拼写错误处理
            $keys = $row['values'];

            //可以使用任意多个key
            //@todo 建议使用列表类型而不是联名数组类型保存key
            $keys = json_decode($keys, true);
            $i = 'api'.rand(1, count($keys));
            $key = $keys[$i];
            
            $url = "https://api.tinify.com/shrink";
            $data = file_get_contents($path);
            
            $ch = curl_init();
            $user = "api";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$key}");
            // post数据
            curl_setopt($ch, CURLOPT_POST, 1);
            // post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output);
            //获取压缩后的图片链接
            $outurl = $output->output->url;

            //先判断是否是正常的URL，万一请求接口失败了呢
            if(!filter_var($outurl, FILTER_VALIDATE_URL)){
                //糟糕，没有验证通过，那就结束了
                $this->err_msg('请求接口失败！');
            }

            //下载图片并保存覆盖
            $curl = curl_init($outurl);
            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36");
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            #设置超时时间，最小为1s（可选）

            $data = curl_exec($curl);
            curl_close($curl);
            
            //重新保存图片
            file_put_contents($path,$data);

            //最后别忘了更新数据库呀
            $sql = "UPDATE img_images SET compression = 1 WHERE `id` = $id";
            if($this->db->query($sql)){
                $this->suc_msg('压缩完成！');
            }
        }
        //图片鉴黄识别
        public function identify($id){
            //允许跨域访问
            header("Access-Control-Allow-Origin: *");
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
        //重置密码
        public function resetpass(){
            $password1 = $this->input->post('password1', TRUE);
            $password2 = $this->input->post('password2', TRUE);
            //验证文件路径
            $pass_txt = FCPATH."data/password.txt";
            if(!file_exists($pass_txt)){
                $this->err_msg("没有权限，请参考帮助文档操作！");
            }
            else{
                $pattern = '/^[a-zA-Z0-9!@#$%^&*.]+$/';
                if($password1 != $password2){
                    $this->err_msg("两次密码不一致！");
                }
                else if(!preg_match($pattern,$password2)){
                    $this->err_msg("密码格式有误！");
                    exit;
                }
                else{
                    //进行密码重置
                    $password = md5($password2.'imgurl');
                    
                    //加载数据库模型
                    $this->load->model('query','',TRUE);
                    $this->load->model('update','',TRUE);
                    //查询用户信息
                    $userinfo = $this->query->userinfo()->values;
                    $userinfo = json_decode($userinfo);
                    $userinfo->password = $password;
                    $values = json_encode($userinfo);
                    //更新数据库
                    if($this->update->password($values)){
                        //删除验证文件
                        unlink($pass_txt);
                        $this->suc_msg("密码已重置，请重新登录。");
                    }
                    else{
                        $this->err_msg("更新失败，未知错误！");
                    }
                }
            }
        }
    }
?>