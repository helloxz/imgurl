<?php
    /* 图片处理类 */
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Image{
        public function thumbnail($source,$width,$height){
            //获取缩略图名称
            $source = str_replace("\\","/",$source);
            //获取图片信息
            $imginfo = getimagesize($source);
            //图片宽
            $img_w = $imginfo[0];
            //图片高
            $img_h = $imginfo[1];

            //缩略图完整路径
            $thumbnail_full = $this->thumbnailPath($source);

            //原图宽高小于缩略图
            if(($img_w <= $width) && ($img_h <= $height)){
                return copy($source, $thumbnail_full);
            }

            //计算目标图片尺寸，防止挤压变形
            $dstSize = $this->dstSize($img_w, $img_h, $width, $height);
            return $this->gdResize($source, $thumbnail_full, $dstSize['width'], $dstSize['height']);
            //imagick扩展安装难度较大，先用gd库的方案替代，后期再进行优化
            /*
            //有则用imagick压缩,没有则用gd压缩
            if (class_exists('imagick')) {
                return $this->imagickResize($source, $thumbnail_full, $dstSize['width'], $dstSize['height']);
            } else {
              return $this->gdResize($source, $thumbnail_full, $dstSize['width'], $dstSize['height']);
            }*/

        }

        public function thumbnailPath($file)
        {
            $str = explode(".", $file);
            return $str[0].'_thumb.'.$str[1];
        }
        //压缩图片
        public function compress($source){
            
        }

        /**
         * 使用imagick扩展生成缩略图,图片质量更好更方便
         * @param $src
         * @param $dst
         * @param $width
         * @param $height
         */
        /*
        public function imagickResize($src, $dst, $width, $height)
        {
            $imginfo = getimagesize($src);
            //图片宽
            $img_w = $imginfo[0];
            //图片高
            $img_h = $imginfo[1];
            $image = new Imagick($src);
            // 创建缩略图
            //原图宽高大于缩略图
            if (($img_w > $width) || ($img_h > $height)) {
                //$image->setImageCompressionQuality(90);
                $image->cropThumbnailImage( $width, $height );
            }

            //将缩略图输出到文件
            $image->writeImage( $dst );

            //清理工作
            $image->clear();
        }
        */

        /**
         * 使用gd扩展生成缩略图
         *
         * @param $src
         * @param $dst
         * @param $width
         * @param $height
         *
         * @return bool
         */
        public function gdResize($src, $dst, $width, $height)
        {
            $localInfo = getimagesize($src);
            //创建图像句柄
            $im = $this->gdCreateImg($src, $localInfo[2]);
            if (!$im) {
                return false;
            }
            $dstSize = $this->dstSize($localInfo[0], $localInfo[1], $width, $height);
            $dstImage = @imagecreatetruecolor($dstSize["width"], $dstSize["height"]);
            $whiteColor = @imagecolorallocatealpha($dstImage, 0, 0, 0, 127);
            imagefill($dstImage, 0, 0, $whiteColor);
            $re = @imagecopyresampled($dstImage, $im, 0, 0, 0, 0, $dstSize["width"], $dstSize["height"], $localInfo[0], $localInfo[1]);
            if (!$re) {
                return false;
            }
            if (!$this->gdCreateImgFile($dstImage, $dst, $localInfo[2])) {
                return false;
            }
            return true;
        }

        /**
         * 计算目标文件尺寸
         *
         * @param $srcWidth
         * @param $srcHeight
         * @param $dstWidth
         * @param $dstHeight
         *
         * @return mixed
         */
        public function dstSize($srcWidth, $srcHeight, $dstWidth, $dstHeight)
        {
            if (($srcWidth / $srcHeight) < ($dstWidth / $dstHeight)) {
                $dstWidth = floor($dstHeight * $srcWidth / $srcHeight);
            } else {
                $dstHeight = floor($dstWidth * $srcHeight / $srcWidth);
            }
            $dstSize["width"] = $dstWidth;
            $dstSize["height"] = $dstHeight;
            return $dstSize;
        }

        /**
         * 获取图像对象
         *
         * @param $src
         * @param $code
         *
         * @return bool|resource
         */
        public function gdCreateImg($src, $code)
        {
            switch ($code) {
                case 1:
                    return imagecreatefromgif($src);
                case 2:
                    return imagecreatefromjpeg($src);
                case 3:
                    return imagecreatefrompng($src);
                default :
                    return false;
            }
        }

        /**
         * 生成缩略图文件
         * @param $img
         * @param $path
         * @param $code
         * @return bool
         */
        public function gdCreateImgFile($img, $path, $code)
        {
            switch ($code) {
                case 1:
                    return imagegif($img, $path);
                case 2:
                    return imagejpeg($img, $path);
                case 3:
                    return imagepng($img, $path);
                default :
                    return false;
            }
        }
    }

?>