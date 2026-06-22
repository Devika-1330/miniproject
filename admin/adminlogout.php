<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['adminid']='';
header("location: /miniproject/user/welcomepage/homepage.php");
            
exit();
?>