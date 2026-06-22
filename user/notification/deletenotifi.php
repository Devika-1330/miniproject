<?php
if (isset($_GET['noid'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $noid=$_GET['noid'];
    $query = "DELETE FROM tbl_notification WHERE noid = '$noid'";
    $result = $connection->query($query);
    $connection->close();
    header("location: /miniproject/user/notification/notification.php");
    exit();
}
?>