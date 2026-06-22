
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if($_SESSION['username']== '')
{
  header("location: /miniproject/user/login/login.php");
    exit();
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Interface</title>
  <link rel="stylesheet" href="/miniproject/user/userchat/userchat.css">
  <style>
    </style>
</head>
<body>
<div class="container">
<div class="chatbar">
  <?php   
  include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
    $ptint=array();
    $usint=array();
    $query="SELECT * FROM userchat";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if($_SESSION['id']==$row['userid']||$row['sellerid']==$_SESSION['id']){
          $stmt = $connection->prepare("SELECT title FROM tbl_ogproducts WHERE productid = ?");
          $stmt->bind_param("i", $row['productid']); 
          $stmt->execute();
          $result2 = $stmt->get_result();
$title = $result2->fetch_assoc()['title']; 
$usint[]=$row['userid'];
          if(!in_array($title, $ptint)){ ?>
          <ul>
          <li onclick="window.location.href = '/miniproject/user/userchat/userchat.php?seller-id=<?php if($row['sellerid']==$_SESSION['id']) {echo $row['userid'];} else {echo $row['sellerid'];} ?>&pid=<?php echo $row['productid']; ?>'">
          <?php
          echo $title; $ptint[]=$title; }?>
        </li>
      </ul>
      <?php } ?><?php $flag=1;}} ?>
      </div>
          </body>
          </html>