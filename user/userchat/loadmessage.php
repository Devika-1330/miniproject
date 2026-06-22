
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();}

include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


$sellerid = $_GET['seller-id'];
$pid = $_GET['pid'];


$query = "SELECT * FROM tbl_userchat WHERE productid = '$pid' AND (userid = '$sellerid' OR sellerid = '$sellerid')";
$result = $connection->query($query);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if($row['userid']==$_SESSION['id']&&$row['message']!=' '&&$row['productid']==$pid&&$sellerid==$row['sellerid']) {
            echo '<div class="message user">' . $row['message'] . '</div>';
             echo "<p style='font-size:10px; margin-top:-8px;'>", $row['timest']," </p>"; 
        } else if($row['userid']==$sellerid&&$row['sellerid']==$_SESSION['id']&&$row['productid']==$pid&&$row['message']!=' '){
            echo '<div class="message seller">' . $row['message'] . '</div>';
         echo "<p style='font-size:10px; text-align:right; margin-top:-8px;'>", $row['timest']," </p>"; 
        }
    }
}
?>
