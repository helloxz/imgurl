<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Found extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载模型
            $this->load->model('query','',TRUE);
            //加载辅助函数
        }
        //方法映射
        public function _remap($type = 'all',$params = array())
        {
            $page = @$params[0];
            //var_dump($params);
            //exit;
            if(!isset($page)){
                $page = 0;
            }
            $this->index($type,$page);
        }
        //探索发现页面
        public function index($type = 'all',$page = 0){
            //加载常用类
            $this->load->library('basic');
            //检测用户是否登录
            $data['is_login'] = $this->basic->is_login();
            $siteinfo = $this->query->site_setting();
            $siteinfo = $siteinfo->values;
            $siteinfo = json_decode($siteinfo);
            //每页显示16张图片
            $limit = 16;
            //echo $page;
            //设置页面标题
            if($page == 0){
                $siteinfo->title = $siteinfo->title.'，探索发现';
            }
            else{
                $page_num = $page / 16 + 1;
                $siteinfo->title = $siteinfo->title.'，探索发现 - '."第{$page_num}页";
            }
            
            //出于安全性考虑，最多显示160张图片
            
            //根据条件生成不同的SQL语句
            switch($type){
                case 'all':
                    //查询游客上传图片总数
                    $num = $this->query->count_num('visitor')->num;
                    $num = ($num >= 160) ? 160 : $num;
                    $config['base_url'] = "/found/all/";
                    break;
                case 'gif':
                    $num = $this->query->count_num('gif')->num;
                    $num = ($num >= 160) ? 160 : $num;
                    $config['base_url'] = "/found/gif/";
                    break;
                case 'views':  
                    $num = $this->query->count_num('visitor')->num;
                    $num = ($num >= 160) ? 160 : $num;
                    $config['base_url'] = "/found/views/";
                    break;
                case 'large':
                    $num = $this->query->count_num('large')->num;
                    $num = ($num >= 160) ? 160 : $num;
                    $config['base_url'] = "/found/large/";
                    break;
                default:
                    $num = $this->query->count_num('visitor')->num;
                    $num = ($num >= 160) ? 160 : $num;
                    $config['base_url'] = "/found/all/";
                    break;
            }
            //查询图片信息,返回对象
            //$data['imgs'] = $this->query->found(96);
            //$data['imgs'] = $this->db->query($sql)->result_array();
            $data['imgs'] = $this->query->found_img($type,$page);
            //查询域名
            $data['domain'] = $this->query->domain('localhost');
            

            //进行分页
            //调用分页类
            $this->load->library('pagination');
            //$config['base_url'] = "/found/all/";
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

            //设置标题
            //加载视图
            $this->load->view('user/header',$siteinfo);
            $this->load->view('user/found',$data);
            
            $this->load->view('user/footer');
        }
        //链接页面
        public function link($id){
            $id = strip_tags($id);
            $id = (int)$id;
            $siteinfo = $this->query->site_setting();
            $siteinfo = $siteinfo->values;
            $siteinfo = json_decode($siteinfo);

            //查询图片信息,返回对象
            $data['imgs'] = $this->query->found(32);
            //查询域名
            $data['domain'] = $this->query->domain('localhost');

            //加载视图
            $this->load->view('user/header',$siteinfo);
            $this->load->view('user/link',$data);
            
            $this->load->view('user/footer');
        }
    }
?>