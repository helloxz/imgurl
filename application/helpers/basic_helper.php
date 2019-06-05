<?php
    error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
    //获取真实IP
    function get_ip() { 
        if (getenv('HTTP_CLIENT_IP')) { 
        $ip = getenv('HTTP_CLIENT_IP'); 
        } 
        elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
        $ip = getenv('HTTP_X_FORWARDED_FOR'); 
        } 
        elseif (getenv('HTTP_X_FORWARDED')) { 
        $ip = getenv('HTTP_X_FORWARDED'); 
        } 
        elseif (getenv('HTTP_FORWARDED_FOR')) { 
        $ip = getenv('HTTP_FORWARDED_FOR'); 

        } 
        elseif (getenv('HTTP_FORWARDED')) { 
        $ip = getenv('HTTP_FORWARDED'); 
        } 
        else { 
        $ip = $_SERVER['REMOTE_ADDR']; 
        } 
        return $ip; 
    } 
    //获取UA
    function get_ua(){
        $ua = $_SERVER['HTTP_USER_AGENT'];
        return $ua;
    }
    //创建token
    function token($user,$pass){
        //token生成算法为：用户名 + md5后的密码 + ip + ua
        $token = $user.$pass.get_ua();
        $token = md5($token);
        
        return $token;
    }
    //判断用户是否登录
    function is_login($user,$pass){
        $token = $user.$pass.get_ua();
        $token = md5($token);

        $username = $_COOKIE['user'];
        $password = $_COOKIE['token'];

        //进行判断
        if(($user != $username) || ($password != $token)){
            echo '权限不足！';
            exit;
        }
        else{
            return true;
        }
    }
    //判断文件MIME类型
    function mime($path){
        $mime = mime_content_type($path);
        switch ( $mime )
        {
            case 'image/gif':
            case 'image/png':
            case 'image/jpeg':
            case 'image/bmp':
            case 'image/x-ms-bmp':
            case 'image/webp':
            case 'image/svg+xml':
                return TRUE;
                break;		
            default:
                return FALSE;
                break;
        }
    }
    //根据MIME类型返回文件后缀
    function ext($path){
        $mime = mime_content_type($path);
        switch ( $mime )
        {
            case 'image/gif':
                return '.gif';
                break;
            case 'image/png':
                return '.png';
                break;
            case 'image/jpeg':
                return '.jpg';
                break;
            case 'image/x-ms-bmp':
                return '.bmp';
                break;
            case 'image/webp':
                return '.webp';
                break;	
            default:
                return FALSE;
                break;
        }
    }
    //获取文件大小
    function file_size($path){
        //先判断文件是否存在
        if(!is_file($path)){
            $name = '0 byte';
        }
        else{
            //继续执行
            $size = filesize($path);
            //转换为KB
            $size = $size / 1024;
            $size = round($size,1);
            $name = $size.' KB';
            //转换为Mb
            if($size >= 1024){
                $size = $size / 1024;
                $size = round($size,1);
                $name = $size.' MB';
            }
            
        }
        return $name;
    }
    //缩略图函数
    function thumbnail($img){
        //返回路径
        $dir = dirname($img['path']);
        $thumbnail_name = $dir.'/'.$img['imgid'].'_thumb'.$img['ext'];

        
        //缩略图完整地址
        $fullpath = FCPATH.$thumbnail_name;
        //echo $fullpath;
        //判断缩略图是否存在
        if(is_file($fullpath)){
            return $thumbnail_name;
        }
        //$thumbnail_name = $dir.$name.'_thumb';
        //返回缩略图地址，不带文件名
        //返回原图
        else{
            return $img['path'];
        }
    }
    //生成4位随机数，方法来自：https://blog.csdn.net/happy_jijiawei/article/details/50581094
    function GetRandStr($len) 
    { 
        $chars = array( 
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
            "3", "4", "5", "6", "7", "8", "9" 
        ); 
        $charsLen = count($chars) - 1; 
        shuffle($chars);   
        $output = ""; 
        for ($i=0; $i<$len; $i++) 
        { 
            $output .= $chars[mt_rand(0, $charsLen)]; 
        }  
        return $output;  
    }
?>