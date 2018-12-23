<?php
    class Delete extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            // Your own constructor code
        }
        //删除单张图片数据,需要传入图片ID
        public function del_img($imgid){
            $sql1 = "DELETE FROM `img_images` WHERE imgid = '$imgid'";
            $sql2 = "DELETE FROM `img_imginfo` WHERE imgid = '$imgid'";

            //执行删除数据库
            $this->db->query($sql1);
            $this->db->query($sql2);
        }
        
        
    }
?>