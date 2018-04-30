<?php
    //清除COOKIE
    setcookie("user", '', time()-3600,"/");
    setcookie("password", '', time()-3600,"/");

    echo "<script>window.location.href = './login.php'</script>";
?>