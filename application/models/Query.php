<?php
    class Query extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            // Your own constructor code
        }
        //查询域名
        public function domain($storage){
            $sql = "SELECT domains FROM img_storage WHERE `engine` = '$storage'";

            $query = $this->db->query($sql);
            

            if($query){
                $row = $query->row();
                $domain = $row->domains;
                //var_dump($domain);
                return $domain;

            }
            else{
                return FALSE;
            }
        }
        //查询是否重复
        public function repeat($imgid){
            $sql = "SELECT * FROM img_images WHERE `imgid` = '$imgid'";

            $query = $this->db->query($sql);
            if($query){
                $row = $query->row();
                //var_dump($domain);
                return $row;
            }
            else{
                return false;
            }
        }
        //根据ID查询1张图片
        public function onepic($imgid){
            $sql = "SELECT * FROM img_images WHERE `imgid` = '$imgid'";

            $query = $this->db->query($sql);
            if($query){
                $row = $query->row();
                //var_dump($domain);
                return $row;
            }
            else{
                return false;
            }
        }
        public function img($id){
            $id = strip_tags($id);
            $id = (int)$id;
            $sql = "SELECT * FROM img_images WHERE `id` = '$id'";

            $query = $this->db->query($sql);
            if($query){
                $row = $query->row();
                //var_dump($domain);
                return $row;
            }
            else{
                return false;
            }
        }
        //查询图片信息
        public function imginfo($imgid){
            $sql = "SELECT * FROM img_imginfo WHERE `imgid` = '$imgid'";

            $query = $this->db->query($sql);
            if($query){
                $row = $query->row();
                //var_dump($domain);
                return $row;
            }
            else{
                return false;
            }
        }
        //查询用户信息
        public function userinfo(){
            $sql = "SELECT * FROM `img_options` WHERE `name` = 'userinfo' LIMIT 1";
            
            $query = $this->db->query($sql);

            if($query){
                $row = $query->row();
                
                return $row;
            }
            else{
                return false;
            }
        }
        //查询tinypng设置
        public function tinypng(){
            $sql = "SELECT * FROM `img_options` WHERE `name` = 'tinypng' LIMIT 1";
            @$query = $this->db->query($sql);
            
            if($query){
                $row = $query->row();
                return $row;
            }
            else{
                return FALSE;
            }
        }
        //查询站点信息
        public function site_setting($type = ''){
            $sql = "SELECT * FROM 'img_options' WHERE name = 'site_setting' LIMIT 1";
            $query = $this->db->query($sql);

            //如果类型为空，则返回完整对象
            if($type == '') {
                if($query){
                    $row = $query->row();
                    
                    return $row;
                }
                else{
                    return FALSE;
                }
            }
            else{
                if($query){
                    $row = $query->row();
                    $row = json_decode($row->values);
                    return $row;
                }
                else{
                    return FALSE;
                }
            }

            
        }
        //新版查询站点信息
        public function siteinfo(){
            $sql = "SELECT * FROM 'img_options' WHERE name = 'site_setting' LIMIT 1";
            $query = $this->db->query($sql);

            if($query){
                $row = $query->row();
                var_dump($row);
                return $row;
            }
            else{
                return FALSE;
            }
        }
        //查询各种设置
        public function option($name){
            $sql = "SELECT * FROM 'img_options' WHERE name = '$name' LIMIT 1";
            $query = $this->db->query($sql);

            if($query){
                $row = $query->row();
                
                return $row;
            }
            else{
                return FALSE;
            }
        }
        //查询上传数量限制,传入参数IP
        public function uplimit($ip){
            //获取今天的日期
            $date = date('Y-m-d',time());
            $date = $date.'%';
            //查询出今天上传的数量
            $sql = "select count(*) num from img_images where `ip` = '$ip' AND `user` = 'visitor' AND `date` LIKE '$date'";
            $query = $this->db->query($sql);
            //获取用户已经上传的数量
            $num = (int)$query->row()->num;
            // var_dump($num);
             
            //  exit;
            //查询系统限制的条数
            $sql = "SELECT * FROM 'img_options' WHERE name = 'uplimit' LIMIT 1";
            $query = $this->db->query($sql);
            $limit = $query->row();
            $limit = $limit->values;
            $limit = json_decode($limit);
            $limit = $limit->limit;
            
            //进行判断
            //上传达到限制了，返回FALSE
            if($num >= $limit){
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
        //查询图片完整信息，用于探索发现,$num为要查询的图片数量
        public function found($num){
            //先写一个强大的SQL语句
            $sql = "SELECT a.id,a.imgid,a.path,a.date,b.mime,b.width,b.height,b.views,b.ext,b.client_name FROM img_images AS a INNER JOIN img_imginfo AS b ON a.imgid = b.imgid AND a.user = 'visitor' AND a.level != 'adult' ORDER BY a.id DESC LIMIT $num";

            $query = $this->db->query($sql);

            $query = $query->result_array();
            return $query;
        }
        //查询存储引擎
        public function storage($name){
            $sql = "SELECT * FROM `img_storage` WHERE `engine` = '$name' LIMIT 1";

            $query = $this->db->query($sql);
            if($query){
                $row = $query->row();
                return $row;
            }
            else{
                return FALSE;
            }
        }
        //统计数量
        public function count_num($type){
            switch ($type) {
                case 'admin':
                    $sql = "SELECT count(*) AS num FROM `img_images` WHERE `user` = 'admin'";
                    break;
                case 'visitor':
                    $sql = "SELECT count(*) AS num FROM `img_images` WHERE `user` = 'visitor'";
                    break;
                case 'dubious':
                    $sql = "SELECT count(*) AS num FROM `img_images` WHERE `level` = 'adult'";
                    break;
                case 'day':
                    $sql = "SELECT count(*) AS num FROM `img_images` WHERE date LIKE date('now') || '%'";
                    break;
                case 'month':
                    $sql = "SELECT count(*) AS num FROM `img_images` WHERE date LIKE strftime('%Y-%m','now') || '%'";
                    break;
                case 'gif':
                    $sql = "SELECT count(*) AS num FROM (SELECT a.id,b.ext FROM img_images a INNER JOIN img_imginfo b ON a.imgid = b.imgid AND a.user = 'visitor' AND b.ext = '.gif')";
                    break;
                case 'large':
                    $sql = "SELECT count(*) AS num FROM
                    (
                        SELECT a.id,a.imgid,a.path,a.thumb_path,a.date,a.compression,a.level,b.mime,b.width,b.height,b.views,b.ext,b.client_name 
                        FROM img_images 
                        AS a INNER JOIN img_imginfo AS b 
                        ON a.imgid = b.imgid 
                        AND a.user = 'visitor' 
                        AND a.level = 'everyone' 
                        AND b.width >= 1920 
                        AND b.height >= 1080 
                        ORDER BY a.id DESC
                    )";
                    break;
                default:
                    # code...
                    break;
            }
            $query = $this->db->query($sql);
            $row = $query->row();
            return $row;
        }
        //查询单张图片信息
        public function picinfo($imgid){
            $sql = "SELECT a.id,a.ip,a.imgid,a.path,a.date,b.mime,b.width,b.height,b.views,b.ext,b.client_name FROM img_images AS a INNER JOIN img_imginfo AS b ON a.imgid = b.imgid AND b.imgid = '$imgid' LIMIT 1";

            $query = $this->db->query($sql);

            $query = $query->row();
            return $query;
        }
        //根据img_images id查出图片信息
        public function img_id($id){
            $id = (int)$id;
            //先获取img id
            $sql = "SELECT a.*,b.mime,b.width,b.height,b.views,b.ext,b.client_name FROM img_images AS a INNER JOIN img_imginfo AS b ON a.id = $id AND a.imgid = b.imgid";
            $imginfo = $this->db->query($sql)->row();
            return $imginfo;
        }
        //各种条件的图片查询
        public function found_img($type,$page){
            //探索发现每页显示16张图片
            $limit = 16;
            //通用的SQL语句头部
            $sql_header = "SELECT a.id,a.imgid,a.path,a.thumb_path,a.date,a.compression,a.level,b.mime,b.width,b.height,b.views,b.ext,b.client_name 
            FROM img_images AS a 
            INNER JOIN img_imginfo AS b 
            ON a.imgid = b.imgid 
            AND a.user = 'visitor' 
            AND (a.level = 'everyone' OR a.level = 'unknown') ";
            //根据条件生成不同的SQL语句
            switch($type){
                case 'all':
                    //查询游客上传图片总数
                    $num = $this->count_num('visitor')->num;
                    //$config['base_url'] = "/found/all/";
                    $sql = $sql_header."ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    break;
                case 'gif':
                    $num = $this->count_num('gif')->num;
                    //$config['base_url'] = "/found/gif/";
                    $sql = $sql_header."AND b.ext = '.gif' ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    break;
                case 'views':
                    $num = $this->count_num('visitor')->num;
                    //$config['base_url'] = "/found/views/";
                    $sql = $sql_header."ORDER BY b.views DESC LIMIT $limit OFFSET $page";
                    break;
                case 'large':
                    $num = $this->count_num('large')->num;
                    //$config['base_url'] = "/found/large/";
                    $sql = $sql_header."AND b.width >= 1920 AND b.height >= 1080 ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    break;
                default:
                    //查询游客上传图片总数
                    $num = $this->count_num('visitor')->num;
                    //$config['base_url'] = "/found/all/";
                    $sql = $sql_header."ORDER BY a.id DESC LIMIT $limit OFFSET $page";
                    break;
            }
            $datas = $this->db->query($sql)->result_array();
            return $datas;
        }
        //v2.2升级v2.3
        public function to23(){
            // $sql = 'alter table "img_images" ADD "token"  TEXT(16) DEFAULT NULL;
            // CREATE UNIQUE INDEX "token" ON "img_images" ("token" ASC);
            // ';
            $sqls = array(
                'alter table "img_images" ADD "token"  TEXT(16) DEFAULT NULL;',
                'CREATE UNIQUE INDEX "token" ON "img_images" ("token" ASC)',
                'CREATE UNIQUE INDEX "imginfo_imgid" ON "img_imginfo" ("imgid" ASC)'
            );
            //遍历SQL语句
            foreach ($sqls as $value) {
                $datas = $this->db->query($value);
            }
            //var_dump($datas);
            if($datas){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //查询站点主域名
        public function get_domain() {
            $sql = 'SELECT "values" FROM "img_options" WHERE `name` = "site_url"';
            $data = $this->db->query($sql)->row();
            
            if($data){
                return $data->values;
            }
            else{
                return FALSE;
            }
        }
        //根据token查询图片信息
        public function get_token($value){
           //先获取img id
           $sql = "SELECT a.*,b.mime,b.width,b.height,b.views,b.ext,b.client_name FROM img_images AS a INNER JOIN img_imginfo AS b ON a.token = '{$value}' AND a.imgid = b.imgid";
           $imginfo = $this->db->query($sql)->row();
           return $imginfo;
        }
        //获取上传限制
        public function get_limit(){
            $sql = "SELECT `values` FROM img_options WHERE `name` = 'uplimit' LIMIT 1;";
            $query = $this->db->query($sql);
            //只获取一行
            $row = $query->row();
            return $row->values;
        }
    }
?>