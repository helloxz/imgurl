<?php
	error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	include_once('../config.php');
	$uid = $_COOKIE['uid'];
	$loginid = md5($config['username'].$config['password']);
	if($uid != $loginid) {
		echo '权限不足';
		exit;
	}

	//图片ID
	$id = $_GET['id'];

	$imginfo = $database->get("uploads",["id","dir"],["id" => $id]);

	//如果查询到了ID
	if($imginfo) {
		//如果文件删除成功
		if(unlink("../".$imginfo['dir'])) {
			//删除数据库记录
			$delinfo = $database->delete("uploads",["id" => $id]);
			if($delinfo) {
				echo 'ok';
			}
			else{
				echo '数据库删除失败';
				exit;
			}
		}
		else{
			echo '删除失败，可能是文件不存在';
		}
	}
	else {
		echo 'ID不存在';
		exit;
	}
?>