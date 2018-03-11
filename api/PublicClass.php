<?php
	include_once("../config.php");
	class LgoinStatus {
		var $uid = $_COOKIE['uid'];
		var $login = md5($config['username'].$config['password']);
		function status(){
			$uid = $this->uid;
			$loginid = $this->login;
			if($uid != $loginid) {
				return false;
				echo '权限不足';
				exit;
			}
		}
		
	}
?>