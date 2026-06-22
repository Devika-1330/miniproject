<?php
   if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
if ((isset($_GET['product-id']))&&(isset($_GET['seller-id']))) {
 
    
    if($_SESSION['username']== '')
    {
      header("location: /miniproject/user/login/login.php");
        exit();
    }
    $flag=0;
    $pid=$_GET['product-id'];
    $sellerid=$_GET['seller-id'];
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $query="SELECT * FROM tbl_userchat";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {
          if($_SESSION['id']==$row['userid']&&$row['sellerid']==$sellerid&&$pid==$row['productid'])
       {
        $flag=1;
       }
      }
    }
    if($flag==0){
    $msg="Hello!!";
    $stmt = $connection->prepare(
     "INSERT INTO tbl_userchat (userid,	productid,	sellerid, message) 
      VALUES (?,?,?,?)"
 );
 
 $stmt->bind_param( 
     "iiis", 
     $_SESSION['id'], 
     $pid,
     $sellerid,
     $msg
    );
      if ($stmt->execute()) {
        $query2="select title from tbl_products where productid='$pid'";
        $result2=$connection->query($query2);
        if($result2->num_rows>0)
        {
          $row2=$result2->fetch_assoc();
        
        }
        
        $title=$row2['title'];
        $currdate = date('Y-m-d'); 
        $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
        $msg = "Date: ".$currdate." A user has sent you a message regarding the purchase of your book titled: ".$title.". Please review their request at your earliest convenience and respond with the next steps. If you need any assistance managing this transaction, feel free to ask!";

        $stat=0;
            $stmt1->bind_param("isi", $sellerid, $msg,$stat);
            $stmt1->execute();
            $stmt1->close();
        header("location: /miniproject/user/userchat/userchat.php?seller-id=$sellerid&pid=$pid&buyer=1");
        exit();
      }
    }
    else{
        header("location: /miniproject/user/userchat/userchat.php?seller-id=$sellerid&pid=$pid&buyer=1");
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
    $message=$_POST['message-input'];
    $pid=$_GET['productid'];
    $sellerid=$_GET['sellerid'];
    $stmt = $connection->prepare(
        "INSERT INTO tbl_userchat (userid, productid,	sellerid, message) 
         VALUES (?,?,?,?)"
    );
    
    $stmt->bind_param( 
        "iiis", 
        $_SESSION['id'], 
        $pid,
        $sellerid,
        $message
       );
         $stmt->execute();
}

$connection->close();
?>