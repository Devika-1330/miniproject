<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if(isset($_GET['status']))
  {
    $_SESSION['username']='';
    $_SESSION['id']='';
    header("location: /miniproject/user/welcomepage/homepage.php");
    exit();
  }

?>