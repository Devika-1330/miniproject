<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

header('Content-Type: application/json');

if(!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$uid = $_SESSION['id'];

if(isset($_POST['seller-id']) && isset($_POST['product-id'])) {
    $sellerid = $_POST['seller-id'];
    $productid = $_POST['product-id'];
    
    $connection->begin_transaction();
    
    try {
        
        $query = "DELETE FROM tbl_history WHERE userid=? AND sellerid=? AND productid=? AND status=1";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("iii", $uid, $sellerid, $productid);
        $stmt->execute();
        
        if($stmt->affected_rows > 0) {
           
            $query1 = "SELECT title, archive FROM tbl_products WHERE productid=? AND userid=?";
            $stmt1 = $connection->prepare($query1);
            $stmt1->bind_param("ii", $productid, $sellerid);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            
            if($result1->num_rows > 0) {
                $row = $result1->fetch_assoc();
                $tit = $row['title'];
                $isArchived = $row['archive'];
                
                
                $query3 = "DELETE FROM tbl_userchat WHERE productid=? AND (userid=? OR sellerid=?)";
                $stmt3 = $connection->prepare($query3);
                $stmt3->bind_param("iii", $productid, $uid, $uid);
                $stmt3->execute();
                
                if(!$isArchived) {
                   
                    $query4 = "SELECT username FROM tbl_users WHERE id=?";
                    $stmt4 = $connection->prepare($query4);
                    $stmt4->bind_param("i", $uid);
                    $stmt4->execute();
                    $result4 = $stmt4->get_result();
                    $username = $result4->fetch_assoc()['username'];
                    
                    
                    $currdate = date('Y-m-d');
                    $msg = "Date: " . $currdate . " Dear Seller, the buyer " . $username . " has canceled their reservation for your book titled: " . $tit . ". The book is now available for other potential buyers. You may choose to keep the listing active or make any necessary updates. Thank you for using our platform.";
                    $stat = 0;
                    
                    $stmt5 = $connection->prepare("INSERT INTO tbl_notification (userid, message, status) VALUES (?, ?, ?)");
                    $stmt5->bind_param("isi", $sellerid, $msg, $stat);
                    $stmt5->execute();
                    
                    
                    $opt = 1;
                    $query2 = "UPDATE tbl_products SET avstatus=? WHERE productid=? AND userid=?";
                    $stmt2 = $connection->prepare($query2);
                    $stmt2->bind_param("iii", $opt, $productid, $sellerid);
                    $stmt2->execute();
                }
                
                
                $connection->commit();
                echo json_encode(['status' => 'success', 'message' => 'Reservation cancelled successfully']);
            } else {
                throw new Exception('Product not found');
            }
        } else {
            throw new Exception('No active reservation found to cancel');
        }
    } catch (Exception $e) {
        $connection->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    
    
    if(isset($stmt)) $stmt->close();
    if(isset($stmt1)) $stmt1->close();
    if(isset($stmt2)) $stmt2->close();
    if(isset($stmt3)) $stmt3->close();
    if(isset($stmt4)) $stmt4->close();
    if(isset($stmt5)) $stmt5->close();
    $connection->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request parameters']);
}
?>