<?php
    class Update extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            // Your own constructor code
        }
        //浏览次数+1
        public function views($imgid){
            $sql = "update img_imginfo set views=views+1 where `imgid` = '$imgid'";

            $query = $this->db->query($sql);
            if($query){
                return true;
            }
            else{
                return false;
            }
        }
        //更新图片压缩
        public function compress($id){
            $id = strip_tags($id);
            $id = (int)$id;
            $sql = "UPDATE img_images SET `compression` = 1 WHERE imgid={$id}";
            $query = $this->db->query($sql);
            if($query){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //更新站点信息
        public function site($name,$data){
            $name = strip_tags($name);
            
            $sql = "UPDATE img_options SET `values` = '$data' WHERE `name` = '{$name}'";
            $query = $this->db->query($sql);
            if($query){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //更新tinypng设置
        public function tinypng($values,$switch){
            $sql = "UPDATE img_options SET `values` = '$values',`switch` = '$switch' WHERE `name` = 'tinypng'";

            //echo $sql;

            $query = $this->db->query($sql);
            if($query){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //更新moderate
        public function moderate($values,$switch){
            $sql = "UPDATE img_options SET `values` = '$values',`switch` = '$switch' WHERE `name` = 'moderate'";
            $query = $this->db->query($sql);
            if($query){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //更新存储引擎
        public function storage($data,$engine){
            $this->db->where('engine', $engine);
            $up = $this->db->update('storage', $data);

            if($up){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //更新密码
        public function password($values){
            $sql = "UPDATE img_options SET `values` = '{$values}' WHERE `name` = 'userinfo'";
            $query = $this->db->query($sql);
            if($query){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        
    }
?>