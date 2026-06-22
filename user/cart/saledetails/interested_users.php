<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

if (isset($_GET['productid'])) {
    $pid = $_GET['productid'];
    $flag = 0;
    $userid = array();
    
    $query3 = "SELECT * FROM tbl_userchat";
    $result3 = $connection->query($query3);
    while ($row3 = $result3->fetch_assoc()) {
        if (count($userid) > 1) {
            $uid = $userid[count($userid) - 1];
        } else {
            $uid = 0;
        }
        if ($row3['productid'] == $pid && $row3['userid'] != $_SESSION['id'] && $row3['userid'] != $uid) {
            $check = 0;
            $uid = $row3['userid']; 
            foreach ($userid as $value) {
                if ($uid == $value) {
                    $check = 1;
                    break;
                }
            }
            if ($check == 0) {
                $userid[] = $row3['userid']; 
                $flag++;
            }
        }
    }
    echo $flag . " Peoples";
}
$connection->close();
?>