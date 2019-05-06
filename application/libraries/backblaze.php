<?php
/**
 * 上传到backblaze类
 *
 * @package backblaze
 * @subpackage Subpackage
 * @category Category
 * @author xiaoz
 * @link https://www.xiaoz.me/
 */

class Backblaze {
    protected $CI;
    //构造函数
    public function __construct(){
        $this->CI = & get_instance();
        //初始化SESSION类
        $this->CI->load->library('session');
    }
    //首先获取授权令牌
    public function b2_authorize_account(){
        //判断SESSION是否存在
        if( (!isset($_SESSION['api_url']))  OR (!isset($_SESSION['auth_token']))){
            $application_key_id = "d0aa4a0ab50e"; // Obtained from your B2 account page
            $application_key = "002ba3a22d1496fbd2590ce91b01d100f641270e1e"; // Obtained from your B2 account page
            $credentials = base64_encode($application_key_id . ":" . $application_key);
            $url = "https://api.backblazeb2.com/b2api/v2/b2_authorize_account";

            $session = curl_init($url);

            // Add headers
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Authorization: Basic " . $credentials;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers

            curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
            curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
            $server_output = curl_exec($session);
            curl_close ($session);
            $data = json_decode($server_output);
            //将api_url和token存入session
            $this->CI->session->set_userdata('api_url', $data->apiUrl);
            //echo 'APIURL:'.$data->apiUrl."<br />";
            $this->CI->session->set_userdata('auth_token',$data->authorizationToken);
            //echo 'authorizationToken'.$data->authorizationToken;
        }
        else{
            return TRUE;
        }
    }
    //获取上传URL
    public function b2_get_upload_url(){
        //先判断api_url和auth_token是否存在
        //如果SESSION不存在
        if( (!isset($_SESSION['api_url']))  OR (!isset($_SESSION['auth_token']))){
            //调用函数auth_token
            $this->b2_authorize_account();
        }
        //再次判断upload_url和upload_auth_token是否存在，如果不存在则生成SESSION
        if( (!isset($_SESSION['upload_url']))  OR (!isset($_SESSION['upload_auth_token']))){
            $api_url = $_SESSION['api_url']; // From b2_authorize_account call
            $auth_token = $_SESSION['auth_token']; // From b2_authorize_account call
            $bucket_id = "1d30babae40a300a6b75001e";  // The ID of the bucket you want to upload to

            $session = curl_init($api_url .  "/b2api/v2/b2_get_upload_url");

            // Add post fields
            $data = array("bucketId" => $bucket_id);
            $post_fields = json_encode($data);
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields); 
            curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
            // Add headers
            $headers = array();
            $headers[] = "Authorization: " . $auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
            $server_output = curl_exec($session); // Let's do this!
            curl_close ($session); // Clean up
            //echo ($server_output); // Tell me about the rabbits, George!
            $data = json_decode($server_output);
            $this->CI->session->set_userdata('upload_url', $data->uploadUrl);
            //echo 'APIURL:'.$data->apiUrl."<br />";
            $this->CI->session->set_userdata('upload_auth_token',$data->authorizationToken);
        }
        else{
            return TRUE;
        }
    }
    //上传文件
    public function upload(){
        //如果SESSION不存在
        if( (!isset($_SESSION['upload_url']))  OR (!isset($_SESSION['upload_auth_token']))){
            //调用函数auth_token
            $this->b2_get_upload_url();
        }
        $file_name = "123.txt";
        $my_file = "E:/temp/" . $file_name;
        $handle = fopen($my_file, 'r');
        $read_file = fread($handle,filesize($my_file));

        $upload_url = $_SESSION['upload_url']; // Provided by b2_get_upload_url
        $upload_auth_token = $_SESSION['upload_auth_token']; // Provided by b2_get_upload_url
        $bucket_id = "1d30babae40a300a6b75001e";  // The ID of the bucket
        $content_type = "text/plain";
        $sha1_of_file_data = sha1_file($my_file);

        $session = curl_init($upload_url);

        // Add read file as post field
        curl_setopt($session, CURLOPT_POSTFIELDS, $read_file); 
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);

        // Add headers
        $headers = array();
        $headers[] = "Authorization: " . $upload_auth_token;
        $headers[] = "X-Bz-File-Name: " . $file_name;
        $headers[] = "Content-Type: " . $content_type;
        $headers[] = "X-Bz-Content-Sha1: " . $sha1_of_file_data;
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 

        curl_setopt($session, CURLOPT_POST, true); // HTTP POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
        $server_output = curl_exec($session); // Let's do this!
        curl_close ($session); // Clean up
        echo ($server_output); // Tell me about the rabbits, George!
    }
}