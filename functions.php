<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	include_once('./config.php');

	$type = $_GET['type'];			//获取方法类型
	
	$user = $_POST['user'];			//用户名
	$pass = $_POST['pass'];			//密码
	$imgname = $_GET['dir'];		//获取图片路径

	//用户ID
	$userid	= md5($config['username'].$config['password']);
	//登录ID
	$loginid = md5($user.$pass);

	//方法判断
	switch($type) {
		case 'login':
			login($userid,$loginid);
			break;
		case 'logout':
			logout();
		case 'delete':
			$uid = $_COOKIE['uid'];
			$loginid = md5($config['username'].$config['password']);
			if($loginid == $uid) {
				delete($imgname,$config['userdir'],$config['admindir']);
			}
			else{
				echo '请先登录';
			}
			break;
		default:
			echo '错误的请求！';
			exit;
	}

	//登录方法
	function login($userid,$loginid) {
		if($userid == $loginid) {
			echo 'ok';
			//设置Cookie,保存7天
			setcookie(uid, $userid, time()+604800);
			exit;
		}
		else {
			echo 'no';
			exit;
		}
	}
	//退出
	function logout(){
		setcookie(uid, "", time() - 3600);
		echo '已退出';
		header("Location: ./index.php"); 
		exit;
	}
	//删除
	function delete($imgname,$userdir,$admindir) {
		//字符串分割
		$imgdir = explode("/",$imgname);
		//只允许删除用户目录和管理员目录
		if(($imgdir[0] == $userdir) || ($imgdir[0] == $admindir)){
			if(unlink($imgname)) {
				echo 'ok';	//删除图片成功
			}
			else {
				echo '删除失败，可能是图片不存在。';
			}
		}
		else {
			echo '非法操作';
			exit;
		}
	}
?>