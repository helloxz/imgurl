<?php
    /*
        name:图片管理
        author:xiaoz.me
        QQ:337003006
    */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Manage extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();
            //加载基础操作类
            $this->load->library('basic');
            //验证用户是否登录
            $this->basic->is_login(TRUE);
            //加载查询模型
            $this->load->model('query','',TRUE);
        }
        //管理员上传
        public function images($type = 'all',$page = 0){
            $type = strip_tags($type);
            $page = (int)strip_tags($page);
            $limit = 16;        //要查询的条数
            $data['admin_title'] = '图片管理';
            $sql1 = "SELECT a.id,a.imgid,a.path,a.thumb_path,a.date,a.compression,a.level,b.mime,b.width,b.height,b.views,b.ext,b.client_name FROM img_images AS a INNER JOIN img_imginfo AS b ON a.imgid = b.imgid ";
            //根据不同的条件生成不同的SQL语句
            switch ($type) {
                case 'all':
                    $sql = $sql1."ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    $num = $this->db->count_all("images");
                    break;
                case 'admin':
                    $sql = $sql1."AND a.user = 'admin' ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    $num = $this->query->count_num('admin')->num;
                    break;
                case 'visitor':
                    $sql = $sql1."AND a.user = 'visitor' ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    $num = $this->query->count_num('visitor')->num;
                    break;
                case 'dubious':
                    $sql = $sql1."AND a.level = 'adult' ORDER BY a.id DESC";
                    //$num = $this->query->count_num('visitor')->num;
                    break;
                default:
                    $sql = $sql1."AND a.user = '$type' ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    break;
            }
            //连接数据库
            $this->load->database();
            $data['imgs'] = $this->db->query($sql)->result_array();

             //调用分页类
             $this->load->library('pagination');
             $config['base_url'] = "/manage/images/$type/";
             $config['total_rows'] = $num;
             $config['per_page'] = $limit;
             $config['first_url'] = 0;
             $config['first_link'] = '首页';
             $config['last_link'] = '尾页';
             $config['attributes'] = array('class' => 'paging');   //设置分页的class
             $config['next_link'] = '下一页';         //下一页文本
             $config['prev_link'] = '上一页';          //上一页文本
             
             $this->pagination->initialize($config);
             $data['page'] = $this->pagination->create_links();

             //获取域名
             $data['domain']    =   $this->query->domain('localhost');
            
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/images',$data);
            $this->load->view('admin/footer');
        }
        //获取单张图片信息
        public function imginfo($imgid){
            $imgid = strip_tags($imgid);
            $row = $this->query->picinfo($imgid);
            //获取文件大小
            $this->load->helper('basic');
            $fullpath = FCPATH.$row->path;
            
            $size = file_size($fullpath);
            $row->size = $size;

            //加载视图
            $this->load->view("admin/imginfo",$row);
        }
    }
?>