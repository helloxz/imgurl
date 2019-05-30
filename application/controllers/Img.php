<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Img extends CI_Controller{
        public function _remap($imgid){
            //加载数据库模型
            $this->load->model('query','',TRUE);
            $siteinfo = $this->query->site_setting();
            $siteinfo = json_decode($siteinfo->values);
            
            //加载常用基本类库
            $this->load->library("basic");
            //获取配置文件信息的内容
            $conf = $this->basic->conf("info");
            //var_dump($conf->img_info);
            //过滤imgid
            $imgid = strip_tags($imgid);
            //计算imgid长度
            $id_length = strlen($imgid);
            //判断是否是有效的ID
            if($id_length != 16){
                show_404();
            }
            //继续执行
            //加载模型
            $this->load->model('query','',TRUE);
            $this->load->model('update','',TRUE);
            //浏览测试+1
            $this->update->views($imgid);
            //查询图片信息
            $imginfo = $this->query->onepic($imgid);
            //查询的img_imginfo
            $picinfo = $this->query->imginfo($imgid);
            $siteinfo->description = $picinfo->client_name.",由网友上传至ImgURL图床。";
            //查询图片域名
            @$domain = $this->query->domain($imginfo->storage);

            //如果没有查询到结果
            if(!$domain){
                show_404();
            }

            //var_dump($siteinfo);
            //获取文件大小
            $this->load->helper('basic');
            $fullpath = FCPATH.$imginfo->path;
            
            $size = file_size($fullpath);
            
            //重组数组
            $datas = array(
                "logo"          =>  $siteinfo->logo,
                "title"         =>  $picinfo->client_name,
                "url"           =>  $domain.$imginfo->path,
                "date"          =>  $imginfo->date,
                "mime"          =>  $picinfo->mime,
                "width"         =>  $picinfo->width,
                "height"        =>  $picinfo->height,
                "views"         =>  $picinfo->views,
                "tags"          =>  $picinfo->tags,
                "keywords"      =>  $picinfo->client_name,
                "analytics"     =>  $siteinfo->analytics,
                "description"   =>  $siteinfo->description,
                "comments"      =>  $siteinfo->comments,
                "ext"           =>  $picinfo->ext,
                "size"          =>  $size
            );

            $datas['img_info'] = $conf->img_info;
            //检测用户是否登录
            $datas['is_login'] = $this->basic->is_login();
            // $data['title']  =   '图片浏览';
            // $data['url']    =   $domain.$imginfo->path;
            // $data['date']   =   $imginfo->date;

            //echo $domain.$imginfo->path;

            //加载视图
            $this->load->view('user/header',$datas);
            $this->load->view('user/img',$datas);
            $this->load->view('user/footer');
        }
    }
?>