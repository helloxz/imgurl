<?php
    class Insert extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            // Your own constructor code
        }
        //插入到images表
        public function images($datas){
            
            if($this->db->insert('images', $datas)){
                
                //如果插入成功返回ID
                return $this->db->insert_id();
            }
            else{
                return false;
                exit;
                
            }
        }
        //插入到imginfo表
        public function imginfo($datas){
            if($this->db->insert('imginfo', $datas)){
                
                //如果插入成功返回ID
                return $this->db->insert_id();
            }
            else{
                return false;
                exit;
            }
        }
        //插入安装的默认数据
        public function default(){
            //上传限制初始数据
            // $uplimit_values = array(
            //     "max_size"      =>  5,
            //     "number"        =>  10
            // );
            // $uplimit_values = json_encode($uplimit_values);
            // $uplimit = array(
            //     "name"      =>  "uplimit",
            //     "values"    =>  $uplimit_values,
            //     "switch"    =>  "ON"
            // );
            // //插入数据
            // $this->db->insert('options',$uplimit);

            //图片压缩初始数据

        }
        
    }
?>