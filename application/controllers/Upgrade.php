<?php
/**
 * ImgURL升级类
 *
 * @package upgrade
 * @author xiaoz
 * @link https://imgurl.org/
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Upgrade extends CI_Controller{
    //构造函数
    public function __construct(){
        parent::__construct();

        //加载辅助类
        $this->load->library('basic');
        $this->basic->is_login(TRUE);
        //加载模型
        $this->load->model('query','',TRUE);
    }
    public function v22_to_v23(){
        //升级数据库操作
        $result = $this->query->to23();
        if($result){
            echo '升级完毕，请关闭此页面！';
        }
        else{
            echo '升级失败，未知错误！';
        }
    }
}