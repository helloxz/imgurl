<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Maintain extends CI_Controller{
        //构造函数
        public function __construct(){
            parent::__construct();

            //加载辅助类
            $this->load->library('basic');
            $this->basic->is_login(TRUE);
            //加载模型
            $this->load->model('query','',TRUE);
        }
        //后台首页
        public function index(){
            
            $data['admin_title']    =   '管理维护';
            
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/index');
            $this->load->view('admin/footer');
        }
        //当前版本
        public function version(){
            $v_file = FCPATH.'data/version.txt';
            $version = file_get_contents($v_file);
            echo $version;
        }
        //升级至2.0
        public function upto2(){
            $data['admin_title']    =   '1.x升级至2.x';
            
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/upto2');
            $this->load->view('admin/footer');
        }
        //导入1.x的数据
        public function import($id){
            $id = (int)$id;

            //加载medoo
            include_once(APPPATH.'libraries/Medoo.php');

            echo APPPATH.'libraries/Medoo.php';

            $database = new Medoo([
                'database_type' => 'sqlite',
                'database_file' => FCPATH.'/data/temp/imgurl.db3'
            ]);

            //$this->load->database($db['old']);

            // $sql = "SELECT * FROM imginfo WHERE id = $id";
            // $query = $this->db->query($sql)->row();
            // var_dump($query);
        }
        //版本升级
        public function upgrade(){
            $data['admin_title']    =   'ImgURL升级';
            //加载视图
            $this->load->view('admin/header',$data);
            $this->load->view('admin/left');
            $this->load->view('admin/upgrade');
            $this->load->view('admin/footer');
        }
        
    }
?>