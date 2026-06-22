<?php
include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['productid'])) {
    $uid = $_SESSION['id'];
    $productid = $_POST['productid'];

    $query = "SELECT DISTINCT userid FROM tbl_userchat WHERE productid='$productid' and userid !='$uid'";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $bid=$row['userid'];
        $stmt2 = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
            $stmt2->bind_param("i", $bid); 
            $stmt2->execute();
            $result3 = $stmt2->get_result();
            $username=$result3->fetch_assoc()['username'];

        echo "<option value='".$row['userid']."'>".$username."</option>";
    }
}
?>
