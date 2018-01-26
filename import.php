<?php
	include_once( 'config.php' );

	$dir = $_GET['dir'];
	$year = $_GET['year'];
	$month = $_GET['month'];
	$date = $year.$month;
	$user = $_GET['user'];
	$thedate = '20'.$year.$month.'01';
	//echo $thedate;
	

	

	$dir = $dir.'/'.$date;
	//echo $dir;
	//exit;
	$dir = new RecursiveDirectoryIterator($dir);
	$arr = get_files($dir);
	//print_r($arr);
	$num = count($arr);
	echo $num;

	for($i=0;$i < $num;$i++){
		$add = $database->insert("uploads",["dir" => $arr[$i],"date" => $thedate,"ip" => '127.0.0.1',"method" => 'localhost',"user" => $user]);
		echo '导入成功！';
	}
	echo "共导入".$num;
	//遍历目录
	function get_files($dir) {
    $files = array();
 
    for (; $dir->valid(); $dir->next()) {
        if ($dir->isDir() && !$dir->isDot()) {
            if ($dir->haschildren()) {
                $files = array_merge($files, get_files($dir->getChildren()));
            };
        }else if($dir->isFile()){
            $files[] = $dir->getPathName();
        }
    }
    return $files;
	}
?>