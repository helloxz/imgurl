<?php
    /* 图片处理类 */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Image{
        protected $CI;

        //构造函数
        public function __construct(){
            //附属类，让其可以访问CI的资源
            $this->CI = & get_instance();
        }
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
            //图片MIME类型
            $mime = $imginfo['mime'];
            //获取源文件名
            $filename = end($imgarr);
            $imgname = explode(".",$filename);
            //缩略图名称
            $thumbnail_name = $imgname[0].'_thumb'.'.'.$imgname[1];
            
            //获取文件路径
            $dirname = dirname($source);    //获取的路径最后没有/
            //缩略图完整路径
            $thumbnail_full = $dirname.'/'.$thumbnail_name;
            // 创建缩略图
            //原图宽高大于缩略图
            if(($img_w > $width) || ($img_h > $height)){
                //如果是WEBP/SVG则不裁剪
                if(($mime === 'image/webp') OR ($mime === 'image/svg+xml')){
                    return FALSE;
                }
                //检测是否支持ImageMagick
                elseif($this->check()){
                    //使用ImageMagick裁剪图像
                    $image = new Imagick($source);
                    $image->cropThumbnailImage( $width, $height );
                    //将缩略图输出到文件
                    $image->writeImage( $thumbnail_full );
                    //清理工作
                    $image->clear();
                    return TRUE;
                }
                //不支持ImageMagick，使用GD2进行裁剪
                else{
                    //配置裁剪参数，参考：https://codeigniter.org.cn/user_guide/libraries/image_lib.html
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $source;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']     = $width;
                    $config['height']   = $height;
                    $this->CI->load->library('image_lib', $config);
                    $this->CI->image_lib->resize();
                    return TRUE;
                }  
            }
            //图片像素太小了，不创建缩略图
            else{
                return FALSE;
            }  
        }
        //检测是否支持ImageMagick
        protected function check(){
            $ext = get_loaded_extensions();
            //如果已经安装ImageMagick
            if(array_search('imagick',$ext)){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        //压缩图片
        public function compress($source){
            
        }
    }

?>