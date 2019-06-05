<?php
/**
 * ImgURL删除图片类
 *
 * @package upgrade
 * @author xiaoz
 * @link https://imgurl.org/
 */
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Del extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('query','',TRUE);
            //加载数据库模型
            $this->load->model('delete','',TRUE);
            //加载类
            $this->load->library('basic');
        }
        //根据img_images ID删除图片，需要检查用户是否登录
        public function id($id){
            //检测是否登录
            $this->basic->is_login(TRUE);

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
        //根据token删除单张图片，不需要登录，只需要知道token即可
        public function token($value){
            //对value进行过滤
            $value = trim($value);
            $value = strip_tags($value);
            $len = strlen($value);
            if($len !== 16){
                exit('不是有效的token！');
            }
            //获取图片信息
            $img = $this->query->get_token($value);
            //如果返回空，说明token不存在
            if($img === NULL){
                exit('token不存在，可能是图片已经被删除！');
            }
            //删除图片
            //从数据库中删除
            $this->delete->del_img($img->imgid);
            //从磁盘中删除
            $path = FCPATH.$img->path;
            $thumbnail_path = FCPATH.$img->thumb_path;
            //缩略图地址
            unlink($path);
            unlink($thumbnail_path);

            echo '图片已删除！';
        }
    }
?>