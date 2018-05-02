<?php
    include_once("../config.php");

    $year = date('Y',time());

    $version = file_get_contents(APP."functions/version.txt");
    echo "当前版本：".$version."<br />";
?>