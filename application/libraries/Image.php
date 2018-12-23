<?php
    /* 图片处理类 */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Image{
        public function thumbnail($source,$width,$height){
            //获取缩略图名称
            $source = str_replace("\\","/",$source);
            $imgarr = explode("/",$source);
            //获取图片信息
            $imginfo = getimagesize($source);
            //图片宽
            $img_w = $imginfo[0];
            //图片高
            $img_h = $imginfo[1];
            //获取源文件名
            $filename = end($imgarr);
            $imgname = explode(".",$filename);
            //缩略图名称
            $thumbnail_name = $imgname[0].'_thumb'.'.'.$imgname[1];
            
            //获取文件路径
            $dirname = dirname($source);    //获取的路径最后没有/
            //缩略图完整路径
            $thumbnail_full = $dirname.'/'.$thumbnail_name;
            $image = new Imagick($source);
            // 创建缩略图
            //原图宽高大于缩略图
            if(($img_w > $width) || ($img_h > $height)){
                //$image->setImageCompressionQuality(90);
                $image->cropThumbnailImage( $width, $height );
            }
            
            //将缩略图输出到文件
            $image->writeImage( $thumbnail_full );
            
            //清理工作
            $image->clear();
        }
        //压缩图片
        public function compress($source){
            
        }
    }

?>