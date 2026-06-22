<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  
$uid = $_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$query="select * from tbl_notification where userid='$uid' and status = 0";
$result = $connection->query($query);
if ($result->num_rows > 0) {
  echo json_encode(['display' => true]);
} else {
  echo json_encode(['display' => false]);
}

?>