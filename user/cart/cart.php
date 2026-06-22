
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['productid']) && isset($_GET['sellerid'])) {
    if ($_SESSION['username'] == '') {
        header("location: /miniproject/user/login/login.php");
        exit();
    }

    $productid = $_GET['productid'];
    $sellerid= $_GET['sellerid'];
    include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
    $query="SELECT * FROM tbl_usercart";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            if($row['userid']==$_SESSION['id']&&$productid==$row['productid'])
            {
                header("location: /miniproject/user/products/productdetails/productdetails.php?statuscart=1&product_id=$productid&user-id=$sellerid");
                exit();
            }
        }
    }
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $query="SELECT * FROM usercart";
    $stmt = $connection->prepare("INSERT INTO tbl_usercart (userid,productid, sellerid) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die('MySQL prepare error: ' . $connection->error);
    }

    $stmt->bind_param("iis", $_SESSION['id'], $productid, $sellerid);

    if (!$stmt->execute()) {
        die('Execute error: ' . $stmt->error);
    }

    header("location: /miniproject/user/products/productdetails/productdetails.php?statuscart=1&product_id=$productid&user-id=$sellerid");
    exit();
}
if (isset($_GET['product-id']) && isset($_GET['user-id'])) {

    $userid=$_GET['user-id'];
    $productid=$_GET['product-id'];
    include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
    $query = "DELETE FROM tbl_usercart WHERE userid = '$userid' AND productid = '$productid'";
    echo $productid;
    $result = $connection->query($query);
    header("location: /miniproject/user/cart/cartdetails/cartdetails.php");
    exit();
}
?>
