<?php
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$flag=0;
if (isset($_GET['name'])) {
    $flag = 0;
    $requiredParams = ['name', 'phone','location', 'address', 'dob', 'bio', 'pin'];

    foreach ($requiredParams as $param) {
        if (isset($_GET[$param])) {
            $_SESSION[$param] = $_GET[$param];
            $flag = 1;
        }
    }
    if ($flag == 1) {
        header("Location: /miniproject/user/login/signup/signupemail.php");
        exit();
    }
}
if (isset($_GET['email'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    echo "Connected successfully<br>";
    $_SESSION['username']=$_SESSION['username1'];
    $_SESSION['password']=$_SESSION['password1'];
    $image =  $_SESSION['profile-pic'];
    $imageExtension = pathinfo($_SESSION['profile-pic'], PATHINFO_EXTENSION);
    echo $image;
    echo 'seperate',$_SESSION['profile-pic'];
    if($image!='')
    {
        $dirPath = "C:/wamp64/www/miniproject/user/login/loginimg/";
        $defaultdir='C:/wamp64/www/miniproject/user/login/loginimg/default-profile-pic.png';
        $imageName = $_SESSION['username'] . ".$imageExtension";
        $imagePath = $dirPath . "/" . $imageName;
        if (!copy($image, $imagePath)) {
            echo "Error copying profile picture.";
            exit();
        }
        if (file_exists($image)&&$image!=$defaultdir) {
            unlink($image);
            echo "Old image deleted successfully.";
        } else {
            echo "No old image found.";
        }
        
        $image = $imagePath;
    }
    $roll=0;
    $stmt = $connection->prepare(
        "INSERT INTO tbl_users (username, name, address, phone, location, pin, dob, bio, image, email,role) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sssdsissssi",
        $_SESSION['username'],
        $_SESSION['name'],
        $_SESSION['address'],
        $_SESSION['phone'],
        $_SESSION['location'],
        $_SESSION['pin'],
        $_SESSION['dob'],
        $_SESSION['bio'],
        $image,
        $_SESSION['emaill'],
        $roll
    );


    if ($stmt->execute()) {
        echo "New record created successfully";
        $requiredParams = ['name', 'phone','location', 'address', 'dob', 'bio', 'pin','email','image', 'username1', 'password1'];
        foreach ($requiredParams as $param) {
            if (isset($_SESSION[$param])) {
                unset($_SESSION[$param]);
                echo "\nsuccess";
            }
        }
        $userFind = $connection->prepare("SELECT id FROM tbl_users WHERE username = ?");
        $userFind->bind_param("s", $_SESSION['username']); 
        $userFind->execute();
        $result2 = $userFind->get_result();
        $userid=$result2->fetch_assoc()['id']; 
$stmt = $connection->prepare("INSERT INTO tbl_logininfo (userid,username, password) VALUES (?, ?, ?)");
$stmt->bind_param("iss",$userid, $_SESSION['username'], $_SESSION['password']);
if (!$stmt->execute()) {
    echo "Error: " . $stmt->error;
} else {
    echo "Profile saved successfully!";
}
        $flag=1;

    } else {
        echo "Error: " . $stmt->error;
    }
    
    
   if($flag==1)
    {
        $_SESSION['id'] = $userid;
        unset($_SESSION['password']);
        header("location: /miniproject/user/welcomepage/homepage.php");
        exit();
       
    }
    $connection->close();
}
?>
