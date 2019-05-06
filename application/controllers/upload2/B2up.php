<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class B2up extends CI_Controller{
    protected $b2;
    //构造函数
    public function __construct(){
        parent::__construct();
        //加载类
        $this->load->library('backblaze');
    }
    public function test(){
        $this->backblaze->b2_authorize_account();
    }
    public function test2(){
        
        $this->backblaze->b2_get_upload_url();
    }
    public function test3(){
        $this->backblaze->upload();
    }
}