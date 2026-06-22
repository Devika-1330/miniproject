<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if($_SESSION['username']== '')
  {
    header("location: /miniproject/user/login/login.php");
      exit();
  }
if(isset($_GET['product-id'])&&isset($_GET['avstatus'])&&isset($_GET['optstatus']))
{
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $productid=$_GET['product-id'];
    $ruser=$_GET['avstatus'];
    $userid=$_SESSION['id'];
    $opt=$_GET['optstatus'];
    $query="UPDATE tbl_products set avstatus='$opt' where productid = '$productid' and userid = '$userid'";
    $result=$connection->query($query);
    if($opt==1)
    {
      $query1="delete from tbl_history where productid='$productid' and sellerid='$userid' and status=1";
      $result1=$connection->query($query1);
    }
    if($opt==2)
    {
    $opt1=$opt-1;
    $currdate = date('Y-m-d'); 
    $stmt1 = $connection->prepare("INSERT INTO tbl_history (userid, productid, status, sellerid, method, trdate) VALUES (?, ?, ?, ?, ?, ?)");
    $stat=$_GET['method'];
        $stmt1->bind_param("iiiiis", $ruser,$productid,$opt1,$userid,$stat,$currdate);
        $stmt1->execute();
        $stmt1->close();
        $stmt2 = $connection->prepare("SELECT title FROM tbl_products WHERE productid = ?");
        $stmt2->bind_param("i", $productid); 
        $stmt2->execute();
        $result3 = $stmt2->get_result();
        $tit=$result3->fetch_assoc()['title']; 
        $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
        $msg = "Date: ".$currdate." Good news! The book titled: " . $tit . " has been reserved for you by the seller. Please coordinate with the seller to finalize the exchange. Thank you for using our platform, and happy reading!";
          $stat=0;
              $stmt1->bind_param("isi", $ruser, $msg,$stat);
              $stmt1->execute();
              $stmt1->close();
    }
    if($opt==3)
    {
      $opt1=$opt-1;
      
      $query1="select userid,method from tbl_history where productid='$productid' and status=1 and (method=1 or method=2)";
      $result1=$connection->query($query1);
      if($result1->num_rows>0)
      {
        while ($row = $result1->fetch_assoc()) {
          $buyerid = $row['userid'];
          $method = $row['method'];
          echo "User ID: $userid, Method: $method <br>";
      }
      $currdate = date('Y-m-d'); 
        $queryinsert="update tbl_history set status='$opt1', trdate='$currdate'  where productid='$productid' and sellerid='$userid'";
        $resultinsert=$connection->query($queryinsert);
        $stmt2 = $connection->prepare("SELECT title FROM tbl_products WHERE productid = ?");
        $stmt2->bind_param("i", $productid); 
        $stmt2->execute();
        $result3 = $stmt2->get_result();
        $tit=$result3->fetch_assoc()['title'];
        if($method==2)
        {
          
          $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
          $msg = "Date: ".$currdate." Great news! The book titled: " . $tit . " has been marked as 'Sold Out' by the seller, confirming that the transaction is complete. Please coordinate with the seller to arrange the exchange. Thank you for using our platform, and happy reading!";
          $stat=0;
              $stmt1->bind_param("isi", $buyerid, $msg,$stat);
              $stmt1->execute();
              $stmt1->close();
              
        }
        else
        {
          $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
          $msg = "Date: ".$currdate." The book titled: " . $tit . " has been marked as 'Sold Out' by the seller, confirming that the exchange has been successfully completed. We hope you enjoy your new book! Thank you for using our platform, and happy reading!";
          $stat=0;
          $stmt1->bind_param("isi", $buyerid, $msg,$stat);
          $stmt1->execute();
          $stmt1->close();
          $querydel="DELETE FROM tbl_userchat WHERE productid='$productid' AND (userid='$buyerid' OR sellerid='$buyerid');";
            $resuldel=$connection->query($querydel);
        }

      }
    }
    if($result){
     
        header("location: /miniproject/user/cart/saledetails/saledetails.php");
        exit();
    }

    $connection->close();
}
if(isset($_GET['pidarchieve']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
  $a=1;
  $productid=$_GET['pidarchieve'];
  $userid=$_SESSION['id'];
  $stmt2 = $connection->prepare("SELECT title FROM tbl_products WHERE productid = ?");
            $stmt2->bind_param("i", $productid); 
            $stmt2->execute();
            $result3 = $stmt2->get_result();
            $tit=$result3->fetch_assoc()['title'];
  $query="UPDATE tbl_products set archive='$a',avstatus='' where productid = '$productid' and userid = '$userid'";
  $result=$connection->query($query);
  $query1="delete from tbl_usercart where productid='$productid'";
  $result1=$connection->query($query1);
  $query1="delete from tbl_userchat where productid='$productid'";
  $result1=$connection->query($query1);

  $query1="select userid from tbl_history where productid='$productid' and status=1";
  $result1=$connection->query($query1);
  if($result1->num_rows>0)
  {
    while ($row = $result1->fetch_assoc()) {
      $resultid = $row['userid'];
  }
  $currdate = date('Y-m-d'); 
    $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
    $msg = "Date: ".$currdate." We regret to inform you that the book titled: " . $tit . " is no longer available for sale. The seller has removed the listing. We apologize for any inconvenience this may cause. Please explore our platform for other interesting titles.";
    $stat=0;
        $stmt1->bind_param("isi", $resultid, $msg,$stat);
        $stmt1->execute();
        $stmt1->close();
  }
  $query1="select userid from tbl_history where productid='$productid' and status=2 and (method=1 or method=2)";
  $result1=$connection->query($query1);
  if($result1->num_rows>0)
  {
    while ($row = $result1->fetch_assoc()) {
      $resultid = $row['userid'];
  }
  $currdate = date('Y-m-d'); 
    $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
    $msg = "Date: " . $currdate . " The book titled: '" . $tit . "' has been removed from the site by the seller. Since your purchase and exchange are complete, this is just a heads-up that the listing is now archived. The seller has finalized the transaction by removing it from our platform, ensuring no further inquiries will be made about this item. We hope you’re enjoying your new book! Thanks for using our platform, and feel free to explore more titles or reach out if you need any assistance.";
    $stat=0;
        $stmt1->bind_param("isi", $resultid, $msg,$stat);
        $stmt1->execute();
        $stmt1->close();
  }
  if($result){
      header("location: /miniproject/user/cart/saledetails/saledetails.php");
      exit();
  }
  $connection->close();
 
}
if(isset($_GET['pidcancel']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
  $productid=$_GET['pidcancel'];
  $opt=1;
  $userid=$_SESSION['id'];
  $query="UPDATE tbl_products set avstatus='$opt' where productid = '$productid' and userid = '$userid'";
    $result=$connection->query($query);
    $queryfetch="select userid from tbl_history where productid='$productid' and sellerid='$userid' and status=2";
    $resultfetch=$connection->query($queryfetch);
    if($resultfetch->num_rows>0){
      while($row=$resultfetch->fetch_assoc())
      {
        $buyerid=$row['userid'];
      }
    $query1="delete from tbl_history where productid='$productid' and sellerid='$userid' and status=2 and method=2";
      $result1=$connection->query($query1);
      $querydel="DELETE FROM tbl_userchat WHERE productid='$productid' AND (userid='$buyerid' OR sellerid='$buyerid');";
      $resuldel=$connection->query($querydel);
      $stmt2 = $connection->prepare("SELECT title FROM tbl_products WHERE productid = ?");
      $stmt2->bind_param("i", $productid); 
      $stmt2->execute();
      $result3 = $stmt2->get_result();
      $tit=$result3->fetch_assoc()['title'];
      $currdate = date('Y-m-d'); 
      $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
    $msg = "Date: ".$currdate." Dear Buyer, we regret to inform you that the sale of ". $tit . " has been cancelled by the seller. Unfortunately, the exchange could not be completed. Please contact the seller directly for a refund or further assistance. We apologize for any inconvenience this may have caused.";
    $stat=0;
        $stmt1->bind_param("isi", $buyerid, $msg,$stat);
        $stmt1->execute();
        $stmt1->close();
      if($result){
       header("location: /miniproject/user/cart/saledetails/saledetails.php");
        exit();
    }
  }
    $connection->close();
}


?>