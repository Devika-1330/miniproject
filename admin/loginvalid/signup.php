<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$flag=0;
$flag2=0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    
    echo "Connected successfully<br>";
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $res="SELECT * FROM tbl_users";
    $result = $connection->query($res);
    if ($result && $result->num_rows > 0) {
        while($row= $result->fetch_assoc())
        {
           if($username==$row['username']){
                $flag=1;
                break;
           }
           else if($email==$row['email'])
           {
            $flag2=1;
            break;
           }
          
           
            }
        }
        if($flag==1)
        {
            $connection->close();
            header("Location: /miniproject/user/login/signup/signupemail.php?error=User name already taken try another");
            exit;
        }
        else if($flag2==1)
        {
            $connection->close();
            header("Location: /miniproject/user/login/signup/signupemail.php?error2=Email already taken try another");
            exit;
        }
        else{
            $_SESSION['username1']=$username;
            $_SESSION['password1']=$password;
            header("location: /miniproject/admin/emailvalid/sendmail.php?email=$email");
        }

}
?>