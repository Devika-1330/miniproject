<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
        if (isset($_FILES['profile-pic'])) {
            if ($_FILES['profile-pic']['error'] == 0) {
                $allowedExtensions = array("jpg", "jpeg", "png", "gif");
                $imageExtension = pathinfo($_FILES['profile-pic']['name'], PATHINFO_EXTENSION);
    
                if (!in_array(strtolower($imageExtension), $allowedExtensions)) {
                    echo "Invalid file extension.";
                    exit();
                }
    
                $imagePath = "C:/wamp64/www/miniproject/user/login/loginimg/" . $_FILES['profile-pic']['name'];

    
                if (!move_uploaded_file($_FILES['profile-pic']['tmp_name'], $imagePath)) {
                    echo "Error moving uploaded file.";
                    exit();
                }
    
                $_SESSION['profile-pic'] = $imagePath;
            }
            else{
                $_SESSION['profile-pic'] = '';
            } 
        }
        else {
            $_SESSION['profile-pic'] = '';
            echo "Error uploading image.";
        }
    
    
    $name = $_POST['name'];
    $add = $_POST['address'];
    $phone = $_POST['phone'];
    $location=$_POST['location'];
    $pin = $_POST['pin'];
    $bio = $_POST['bio'];
    $dob = $_POST['dob'];
    header("Location: /miniproject/admin/loginvalid/dataenter.php?address=$add&name=$name&phone=$phone&location=$location&pin=$pin&bio=$bio&dob=$dob");
    exit();
}
?>
