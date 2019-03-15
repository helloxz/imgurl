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
        public function compress($source,$output='',$channel='tinypng'){
            if (empty($output)) {
                $output = $source;
            }
            switch ($channel) {
                case 'tinypng':
                    $key = "F8rNr5lh25WYcOECQvAqvcilBMAkhtIM";
                    $this->tinypng($source,$output, $key);
                default :
                    return $source;
            }
            
        }

        //请求tinypng压缩接口,传入图片完整路径
        protected function tinypng($path, $outputPath='', $key=''){
            if (empty($outputPath)) {
                $outputPath = $path;
            }

            //tinypng API地址
            $api_url = "https://api.tinify.com/shrink";
            $data = file_get_contents($path);
            //$post_data = array ("username" => "bob","key" => "12345");
            //$ch = curl_init();
            $ch = curl_init();
            $user = "api";
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$key}");
            // post数据
            curl_setopt($ch, CURLOPT_POST, 1);
            // post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $output = curl_exec($ch);
            curl_close($ch);
            //打印获得的数据
            $data = json_decode($output);
            //获取图片压缩后的URL
            $url =  $data->output->url;
            //保存图片
            $this->download($url, $outputPath);
        }

        //传递图片URL，并保存文件
        protected function download($url, $path){
            //获取图片数据并保存
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36");
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            #设置超时时间，最小为1s（可选）
            #curl_setopt($curl , CURLOPT_TIMEOUT, 1);

            $filedata = curl_exec($curl);
            curl_close($curl);

            //将图片数据覆盖源文件
            return file_put_contents($path,$filedata);
        }
    }

?>