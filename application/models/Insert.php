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
        
    }
?>