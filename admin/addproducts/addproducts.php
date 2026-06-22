<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $_SESSION['title'] = $_POST['title'];
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['description'] = $_POST['description'];
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['genre'] = $_POST['genre'];
    $_SESSION['condition'] = $_POST['condition'];
    
        header("location: /miniproject/user/sellproduct/sellimage.php");
        exit();
}
?>