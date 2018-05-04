<?php
	//载入配置文件
	include_once("./config.php");
	//获取要升级的版本
	$v = $_GET['v'];

	//如果版本为空或不存在
	if(($v == '') || (!isset($v))) {
		echo '版本号错误！';
		exit;
	}

	//判断版本号
	switch ( $v )
	{
		case "1.1":
			//增加表
			$sql = 'CREATE TABLE "main"."sm" (
"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
"ip" TEXT NOT NULL,
"ua" TEXT NOT NULL,
"date" TEXT NOT NULL,
"url" TEXT NOT NULL,
"delete" TEXT NOT NULL,
CONSTRAINT "delete" UNIQUE ("delete")
)
;';			$data = $database->query($sql);
			if($data) {
				echo '数据表创建成功！';
			}
			else{
				echo '数据表创建失败，可能是数据库不可写或已经升级过！';
			}
			break;		
		default:
			echo '未知的版本号！';
			exit;
			break;
	}
?>